'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, Button, Icon, notification} from 'antd';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import ModalGroupCreate from './ModalGroupCreate.jsx';

@observer
export default class PageGroupList extends React.Component {
    state = {
        groups: Metadata.groups.slice(),
        modalGroupCreateVisible: false,
    };

    constructor(props) {
        super(props);
    }

    handleGroupCreate() {
        this.setState({
            modalGroupCreateVisible: true,
        });
    }

    handleCancelGroupCreate() {
        this.setState({
            modalGroupCreateVisible: false,
        });
    }

    handleSubmitGroupCreate() {
        this.setState({
            modalGroupCreateVisible: false,
        });
    }

    render() {
        const columns = [
            {
                title: 'ID',
                key: 'id',
                dataIndex: 'id',
            },
            {
                title: '小组名称',
                key: 'name',
                dataIndex: 'name'
            },
            {
                title: '创建时间',
                key: 'created_at',
                dataIndex: 'created_at'
            },
            {
                title: '状态',
                key: 'is_deleted',
                dataIndex: 'is_deleted',
                render(is_deleted) {
                    return is_deleted === 0 ? '正常': '已禁用';
                }
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
                    onCancel={this.handleCancelGroupCreate.bind(this)}
                    onOk={this.handleSubmitGroupCreate.bind(this)}
                ></ModalGroupCreate>
            </Page>
        )
    }
}