'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, notification} from 'antd';
import { Link } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import ListFilter from './ListFilter.jsx';
import ModalGroupAssign from './ModalGroupAssign.jsx';
import Pond from '../../models/Pond.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
export default class PagePondList extends React.Component {
    state = {
        initializing: false,
        loading: false,
        filters: {},
        pagination: {},
        ponds: [],

        groupAssignModalVisible: false,
        selectedPonds: null,
    };

    constructor(props) {
        super(props);
    }

    fetchPonds() {
        this.setState({
            loading: true,
        });

        Pond.list({
            ...this.state.filters,
            offset: ((this.state.pagination.current || 1) - 1) * 10
        }).then(response => {
            let { data: { totalCount, results } } = response;

            const pagination = this.state.pagination;

            pagination.total = totalCount;

            results = results.map(record => {
                return {
                    ...record,
                    key: record.id
                }
            });

            this.setState({
                loading: false,
                ponds: results,
                pagination,
            });
        }).catch(error => {
            notification.error({
                message: '获取数据失败',
                description: ErrorMessageExtractor.extractResponseError(error),
                duration: 5,
            });
        });
    }

    handleFilterChange(filters) {
        this.setState({
            filters: filters,
        }, () => this.fetchPonds());
    }

    handleTableChange(pagination, filters, sorter) {
        const pager = this.state.pagination;
        pager.current = pagination.current;

        this.setState({
            pagination: pager,
        });

        this.fetchPonds();
    }

    handleGroupAssign(pond) {
        this.setState({
            groupAssignModalVisible: true,
            selectedPonds: [pond],
        });
    }

    handleCancelGroupAssign() {
        this.setState({
            groupAssignModalVisible: false,
            selectedPonds: [],
        });
    }
    
    handleSubmitGroupAssign(group) {
        let ponds = this.state.ponds.slice();
        let selectedPond = { ...this.state.selectedPonds[0] };
        let index = ponds.findIndex(customer => {
            return customer.id === selectedPond.id;
        });

        selectedPond.group_id = group.id;
        ponds.splice(index, 1, selectedPond);

        this.setState({
            groupAssignModalVisible: false,
            selectedPonds: [],
            ponds,
        });
    }

    componentDidMount() {
        this.fetchPonds();
    }

    render() {
        const formItemLayout = {
            labelCol: { span: 4 },
            wrapperCol: { span: 20 }
        };
        const handleGroupAssign = this.handleGroupAssign.bind(this);
        const columns = [
            {
                title: '来源',
                key: 'channel_id',
                dataIndex: 'channel_id',
                render(id) {
                    let channel = Metadata.channel.find(channel => {
                        return channel.id == id;
                    });
                    return channel && channel.name || '';
                },
            },
            {
                title: '姓名(ID)',
                key: 'name',
                dataIndex: 'name',
                render(name, record) {
                    return `${name}(${record.id})`;
                }
            },
            {
                title: '手机号码',
                key: 'mobile',
                dataIndex: 'mobile',
            },
            {
                title: 'QQ号码',
                key: 'qq',
                dataIndex: 'qq',
            },
            {
                title: 'Email',
                key: 'email',
                dataIndex: 'email',
            },
            {
                title: '意向',
                key: 'project',
                dataIndex: 'project',
                width: 250,
                render(project, record) {
                    return project ? <a href={record.project_url} target="_blank">{project}</a> : '';
                }
            },
            {
                title: '小组',
                key: 'group_id',
                dataIndex: 'group_id',
                render(group_id) {
                    if (group_id) {
                        let group = Metadata.groups.find(group => {
                            return group.id == group_id;
                        });

                        return group && group.name || '未知';
                    }

                    return '未分配';
                }
            },
            {
                title: '操作',
                dataIndex: 'id',
                render(id, record) {
                    return record.customer_id ? '' : (
                        <div className="layout-table-actions">
                            <a onClick={() => handleGroupAssign(record)}>分配小组</a>
                        </div>
                    );
                }
            },
        ];

        return (
            <Page>
                <ListFilter onChange={this.handleFilterChange.bind(this)}></ListFilter>
                <Table
                    columns={columns}
                    dataSource={this.state.ponds}
                    pagination={this.state.pagination}
                    onChange={this.handleTableChange.bind(this)}
                    loading={this.state.loading}
                    bordered
                />
                <ModalGroupAssign
                    visible={this.state.groupAssignModalVisible}
                    ponds={this.state.selectedPonds}
                    onCancel={this.handleCancelGroupAssign.bind(this)}
                    onOk={this.handleSubmitGroupAssign.bind(this)}
                ></ModalGroupAssign>
            </Page>
        )
    }
}