'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, Modal, notification} from 'antd';
import { Link } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import ListFilter from './ListFilter.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
export default class PageUserList extends React.Component {
    state = {
        loading: false,
        filters: {},
        pagination: {},
        users: []
    };

    constructor(props) {
        super(props);
    }

    fetchCustomers() {
        this.setState({
            loading: true,
        });

        User.list({
            ...this.state.filters,
            offset: ((this.state.pagination.current || 1) - 1) * 10,
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
                users: results,
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
        }, () => this.fetchCustomers());
    }

    handleTableChange(pagination, filters, sorter) {
        const pager = this.state.pagination;
        pager.current = pagination.current;

        this.setState({
            pagination: pager,
        });

        this.fetchCustomers();
    }

    componentDidMount() {
        this.fetchCustomers();
    }

    render() {
        const user = AppState.User;
        const columns = [
            {
                title: '姓名',
                key: 'name',
                dataIndex: 'name',
            },
            {
                title: '邮箱',
                key: 'email',
                dataIndex: 'email',
            },
            {
                title: '手机',
                key: 'mobile',
                dataIndex: 'mobile',
            },
            {
                title: '系统角色',
                key: 'user_role_id',
                dataIndex: 'user_role_id',
                render(user_role_id) {
                    let role = Metadata.role.find(role => {
                        return role.id === user_role_id;
                    });

                    return role ? role.name : '';
                }
            },
            {
                title: '所属小组',
                key: 'group_id',
                dataIndex: 'group_id',
                render(group_id) {
                    let group = Metadata.groups.find(group => {
                        return group.id === group_id;
                    });

                    return group ? group.name : '';
                }
            },
            {
                title: '操作',
                dataIndex: 'id',
                width: 200,
                render(id) {
                    return (
                        <div className="layout-table-actions">
                            <Link to={`/users/${id}`}>编辑</Link>
                        </div>
                    )
                },
            },
        ];

        return (
            <Page>
                <ListFilter onChange={this.handleFilterChange.bind(this)}></ListFilter>
                <Table
                    columns={columns}
                    dataSource={this.state.users}
                    pagination={this.state.pagination}
                    onChange={this.handleTableChange.bind(this)}
                    loading={this.state.loading}
                    bordered
                />
            </Page>
        )
    }
}