'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, Button, Icon, notification} from 'antd';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import User from '../../models/User.jsx';
import ModalGroupCreate from './ModalGroupCreate.jsx';

@observer
export default class PageGroupList extends React.Component {
    state = {
        groups: Metadata.groups.slice(),
        modalGroupCreateVisible: false,
        loadingUsers: false,
        users: [],
    };

    constructor(props) {
        super(props);
    }

    fetchUsers() {
        this.setState({
            loadingUsers: true,
        });

        User.getUsersByName('').then(response => {
            this.setState({
                loadingUsers: false,
                users: response.data,
            });
        }).catch(error => {
            notification.error({
                message: '获取数据失败',
                description: ErrorMessageExtractor.extractResponseError(error),
                duration: 5,
            });
        });
    }

    handleGroupCreate() {
        this.setState({
            modalGroupCreateVisible: true,
        }, () => {
            this.fetchUsers();
        });
    }

    handleCancelGroupCreate() {
        this.setState({
            modalGroupCreateVisible: false,
        });
    }

    handleSubmitGroupCreate(group) {
        let groups = this.state.groups.slice();

        groups.unshift(group);

        this.setState({
            groups,
            modalGroupCreateVisible: false,
        });
    }

    render() {
        const columns = [
            {
                title: 'ID',
                key: 'id',
                dataIndex: 'id',
                width: 200,
            },
            {
                title: '小组名称',
                key: 'name',
                dataIndex: 'name'
            },
            {
                title: '创建时间',
                key: 'created_at',
                dataIndex: 'created_at',
                width: 200,
            },
        ];

        return (
            <Page>
                <div className="layout-page-action-bar">
                    <Button type="primary" onClick={this.handleGroupCreate.bind(this)}><Icon type="plus" />新建小组</Button>
                </div>
                <Table
                    columns={columns}
                    dataSource={this.state.groups}
                    bordered
                />
                <ModalGroupCreate
                    visible={this.state.modalGroupCreateVisible}
                    loading={this.state.loadingUsers}
                    users={this.state.users}
                    onCancel={this.handleCancelGroupCreate.bind(this)}
                    onOk={this.handleSubmitGroupCreate.bind(this)}
                ></ModalGroupCreate>
            </Page>
        )
    }
}