'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Select, Input, Button, Spin, notification } from 'antd';
const FormItem = Form.Item;
const Option = Select.Option;

import FormDetail from './FormDetail.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

export default class PageUserDetail extends React.Component {
    static fetchUser(id) {
        return User.get(id).then(response => response.data);
    }

    state = {
        initializing: true,
        saving: false,
        user: {},
    };

    constructor(props) {
        super(props);

        PageUserDetail.fetchUser(props.params.id).then(user => {
            this.setState({
                initializing: false,
                user: user,
            });
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
            <Spin spinning={this.state.initializing} tip="请稍候">
                <Page title="用户资料">
                    <h2 className="layout-page-section-title"><span>用户资料</span></h2>
                    <FormDetail user={this.state.user}></FormDetail>
                </Page>
            </Spin>
        )
    }
}

