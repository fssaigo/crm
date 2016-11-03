'use strict';

import React from 'react';
import { observer, action } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, Button, Icon, notification} from 'antd';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import User from '../../models/User.jsx';
import ModalGroupCreate from './ModalGroupCreate.jsx';
import ModalGroupEdit from './ModalGroupEdit.jsx';

@observer
export default class PageGroupList extends React.Component {
    state = {
        groups: Metadata.groups,
        modalGroupCreateVisible: false,
        loadingUsers: false,
        users: [],
        modalGroupEditVisible: false,
        selectedGroups: [],
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
        this.state.groups.unshift(group);

        this.setState({
            modalGroupCreateVisible: false,
        });
    }

    handleGroupEdit(group) {
        this.setState({
            modalGroupEditVisible: true,
            selectedGroups: [group],
        }, () => {
            this.fetchUsers();
        });
    }

    handleCancelGroupEdit() {
        this.setState({
            modalGroupEditVisible: false,
            selectedGroups: [],
        });
    }

    handleSubmitGroupEdit(props) {
        let index = this.state.groups.findIndex(group => {
            return group.id = props.id;
        });
        let group = this.state.groups[index];

        group = {
            ...group,
            user_id: props.user_id,
            name: props.name
        };
        this.state.groups.splice(index, 1, group);

        this.setState({
            modalGroupEditVisible: false,
            selectedGroups: [],
        });
    }

    render() {
        const handleGroupEdit = this.handleGroupEdit.bind(this);
        const columns = [
            {
                title: '小组名称',
                key: 'name',
                dataIndex: 'name',
            },
            {
                title: '组长',
                key: 'user_name',
                dataIndex: 'user_name',
            },
            {
                title: '创建时间',
                key: 'created_at',
                dataIndex: 'created_at',
                width: 300,
            },
            {
                title: '操作',
                key: 'id',
                dataIndex: 'id',
                width: 100,
                render(id, record) {
                    return <a href="javascript:;" onClick={() => handleGroupEdit(record)}>编辑</a>
                },
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
                <ModalGroupEdit
                    visible={this.state.modalGroupEditVisible}
                    loading={this.state.loadingUsers}
                    users={this.state.users}
                    group={this.state.selectedGroups[0]}
                    onCancel={this.handleCancelGroupEdit.bind(this)}
                    onOk={this.handleSubmitGroupEdit.bind(this)}
                ></ModalGroupEdit>
            </Page>
        )
    }
}