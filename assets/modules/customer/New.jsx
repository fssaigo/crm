'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Spin, notification } from 'antd';

import FormNew from './FormNew.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
export default class PageCustomerNew extends React.Component {
    state = {
        initializing: true,
        users: [],
    }

    constructor(props) {
        super(props);

        this.fetchUsers('', (users) => {
            this.setState({
                initializing: false,
                users: users,
            });
        });
    }

    fetchUsers(name, callback) {
        User.getUsersByName(name).then(response => {
            callback(response.data);
        }).catch(error => {
            notification.error({
                message: '获取数据失败',
                description: ErrorMessageExtractor.extractResponseError(error),
                duration: 5,
            });
        });
    }

    render() {
        return (
            <Page title="新增客户">
                <Spin spinning={this.state.initializing} tip="请稍候...">
                    <h2 className="layout-page-section-title"><span>新客户资料</span></h2>
                    <FormNew users={this.state.users}></FormNew>
                </Spin>
            </Page>
        );
    }
}