'use strict';

import React from 'react';
import { observable } from "mobx";
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Spin, notification } from 'antd';

import FormBasicInfo from './FormBasicInfo.jsx';
import FormBusinessInfo from './FormBusinessInfo.jsx';
import FormVisitLog from './FormVisitLog.jsx';

import * as request from '../../util/Request.jsx';
import Customer from '../../models/Customer.jsx';
import User from '../../models/User.jsx';
import Visit from '../../models/Visit.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
export default class PageCustomerDetail extends React.Component {
    static fetchCustomer(id) {
        return Customer.get(id).then(response => response.data);
    }

    static fetchUsers(name) {
        return User.getUsersByName(name).then(response => response.data);
    }

    static fetchVisits(customerId) {
        return Visit.list(customerId).then(response => response.data.results);
    }

    state = {
        initializing: true,
        users: [],
        customer: {},
        @observable visits: [],
    };

    constructor(props) {
        super(props);

        request.all([
            PageCustomerDetail.fetchCustomer(props.params.id),
            PageCustomerDetail.fetchUsers(''),
            PageCustomerDetail.fetchVisits(props.params.id)
        ]).then(request.spread((customer, users, visits) => {
            this.setState({
                initializing: false,
                users,
                customer,
                visits,
            })
        })).catch(error => {
            notification.error({
                message: '获取数据失败',
                description: ErrorMessageExtractor.extractResponseError(error),
                duration: 5,
            });
        })
    }

    render() {
        return (
            <Page title="新增客户">
                <Spin spinning={this.state.initializing} tip="请稍候...">
                    <h2 className="layout-page-section-title"><span>客户基本资料</span></h2>
                    <FormBasicInfo customer={this.state.customer} />
                </Spin>
                <Spin spinning={this.state.initializing} tip="请稍候...">
                    <h2 className="layout-page-section-title"><span>业务跟踪资料</span></h2>
                    <FormBusinessInfo customer={this.state.customer} users={this.state.users} />
                </Spin>
                <Spin spinning={this.state.initializing} tip="请稍候...">
                    <h2 className="layout-page-section-title"><span>回访沟通记录</span></h2>
                    <FormVisitLog customer={this.state.customer} visits={this.state.visits} />
                </Spin>
            </Page>
        )
    }
}