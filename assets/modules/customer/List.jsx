'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, Modal, notification} from 'antd';
import { Link } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import FilterList from './FilterList.jsx';
import ModalUserAssign from './ModalUserAssign.jsx';
import Customer from '../../models/Customer.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
export default class PageCustomerList extends React.Component {
    state = {
        initializing: false,
        loading: false,
        filters: {},
        pagination: {},
        customers: [],

        userAssignModalVisible: false,
        loadingGroupUsers: false,
        groupUsers: [],
        selectedCustomers: null,

        cancelAssistModalVisible: false,
    };

    constructor(props) {
        super(props);
    }

    fetchCustomers() {
        this.setState({
            loading: true,
        });

        Customer.list({
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
                customers: results,
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

    fetchGroupUsers() {
        let user = AppState.User;
        User.getUserByMerchantAndGroup(user.merchant_id, user.group_id).then(response => {
            this.setState({
                loadingGroupUsers: false,
                groupUsers: response.data,
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

    handleUserAssign(customer) {
        this.setState({
            userAssignModalVisible: true,
            loadingGroupUsers: true,
            selectedCustomers: [customer],
        }, () => {
            this.fetchGroupUsers();
        });
    }

    handleCancelUserAssign() {
        this.setState({
            userAssignModalVisible: false,
            selectedCustomers: [],
        });
    }

    handleSubmitUserAssign(user) {
        let customers = this.state.customers.slice();
        let selectedCustomer = { ...this.state.selectedCustomers[0] };
        let index = customers.findIndex(customer => {
            return customer.id === selectedCustomer.id;
        });

        selectedCustomer.user_id = user.id;
        selectedCustomer.user_name = user.name;
        customers.splice(index, 1, selectedCustomer);

        this.setState({
            userAssignModalVisible: false,
            selectedCustomers: [],
            customers,
        });
    }

    showConfirmCancelAssist(customer, index) {
        this.setState({
            selectedCustomers: [customer],
        });

        Modal.confirm({
            title: '操作确认',
            content: '确定要撤销协助人员吗？',
            okText: '确定',
            cancelText: '取消',
            maskClosable: false,
            onOk: () => {
                return Customer.update(this.state.selectedCustomers[0].id, {
                    assist: 0,
                }).then(response => {
                    let customers = this.state.customers.slice();

                    customers.splice(index, 1, {
                        ...customer,
                        assist_id: 0,
                        assist_name: '',
                    });

                    this.setState({
                        customers,
                        selectedCustomers: [],
                    });
                    notification.success({
                        message: '操作成功',
                        description: '协助人员已撤销',
                        duration: 5,
                    });
                }).catch(error => {
                    this.setState({
                        selectedCustomers: [],
                    });
                    notification.error({
                        message: '操作失败',
                        description: ErrorMessageExtractor.extractResponseError(error),
                        duration: 5,
                    });
                })
            }
        });
    }

    componentDidMount() {
        this.fetchCustomers();
    }

    render() {
        const formItemLayout = {
            labelCol: { span: 4 },
            wrapperCol: { span: 20 }
        };
        const handleUserAssign = this.handleUserAssign.bind(this);
        const showConfirmCancelAssist = this.showConfirmCancelAssist.bind(this);
        const user = AppState.User;
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
                title: '评级',
                key: 'level',
                dataIndex: 'level',
                render(id) {
                    let level = Metadata.level.find(level => {
                        return level.id == id;
                    });
                    return level && level.name || '';
                },
            },
            {
                title: '加盟区域',
                key: 'province_name',
                dataIndex: 'province_name',
                render(province_name, record) {
                    return province_name ? `${province_name}/${record.city_name}/${record.area_name}`: '未知';
                }
            },
            { title: '下次回访时间', dataIndex: 'next_visit_time' },
            {
                title: '小组',
                key: 'group_name',
                dataIndex: 'group_name',
                render(group_name) {
                    return group_name ? group_name : '未分配';
                }
            },
            {
                title: '信息状态',
                key: 'user_name',
                dataIndex: 'user_name',
                render(user_name, record) {
                    return (
                        <div>
                            {user_name ? <p>归属: {user_name}</p> : '未分配'}
                            {record.assist_id ? <p>协助: {record.assist_name}</p> : ''}
                        </div>
                    )
                }
            },
            {
                title: '操作',
                dataIndex: 'id',
                render(id, record, index) {
                    return (
                        <div className="layout-table-actions">
                            {(user.is_leader || user.is_charge) ? <a onClick={() => handleUserAssign(record)}>分配组员</a> : ''}
                            {(user.is_leader || user.is_charge) && (record.assist_id !== 0) ? <a onClick={() => showConfirmCancelAssist(record, index)}>撤销协助</a> : ''}
                            <Link to={`/customers/${id}`}>追踪</Link>
                        </div>
                    )
                }
            },
        ];
        const expandedRowRender = record => {
            return (
                <div>
                    <Row>
                        <Col span={12}>
                            <Form.Item label="电话" {...formItemLayout}>
                                <p className="ant-form-text">{record.mobile || '无'}</p>
                            </Form.Item>
                        </Col>
                        <Col span={12}>
                            <Form.Item label="QQ" {...formItemLayout}>
                                <p className="ant-form-text">{record.qq || '无'}</p>
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={12}>
                            <Form.Item label="微信" {...formItemLayout}>
                                <p className="ant-form-text">{record.weixin || '无'}</p>
                            </Form.Item>
                        </Col>
                        <Col span={12}>
                            <Form.Item label="意向" {...formItemLayout}>
                                <p className="ant-form-text">{record.mark || '无'}</p>
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item label="追踪信息" labelCol={{span:2}} wrapperCol={{span:22}}>
                                <p className="ant-form-text">{record.weixin || '无'}</p>
                            </Form.Item>
                        </Col>
                    </Row>
                </div>
            )
        };

        return (
            <Page>
                <FilterList onChange={this.handleFilterChange.bind(this)}></FilterList>
                <Table
                    columns={columns}
                    dataSource={this.state.customers}
                    pagination={this.state.pagination}
                    expandedRowRender={expandedRowRender}
                    rowClassName={record => {
                        switch (record.level) {
                            case '1':
                                return 'layout-table-row-red';
                            case '2':
                                return 'layout-table-row-blue';
                            default:
                                break;
                        }
                    }}
                    onChange={this.handleTableChange.bind(this)}
                    loading={this.state.loading}
                    bordered
                />
                <ModalUserAssign
                    visible={this.state.userAssignModalVisible}
                    loading={this.state.loadingGroupUsers}
                    groupUsers={this.state.groupUsers}
                    customers={this.state.selectedCustomers}
                    onCancel={this.handleCancelUserAssign.bind(this)}
                    onOk={this.handleSubmitUserAssign.bind(this)}
                ></ModalUserAssign>
            </Page>
        )
    }
}