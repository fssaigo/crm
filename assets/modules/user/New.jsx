'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Select, Input, Button, Spin, notification } from 'antd';
const FormItem = Form.Item;
const Option = Select.Option;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import * as Validators from '../../util/Validators.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

// @observer
class PageUserNew extends React.Component {
    state = {
        saving: false,
    };

    constructor(props) {
        super(props);
    }

    handleSubmit(e) {
        e.preventDefault();

        this.setState({
            saving: true,
        });

        this.props.form.validateFields((errors, values) => {
            if (errors) {
                console.log('Errors in PageUserNew', errors);
                return;
            }

            User.save({
                ...values
            }).then(response => {
                this.setState({
                    saving: false,
                });

                notification.success({
                    message: '操作成功',
                    description: '页面将跳转到该用户详情页面',
                    duration: 2,
                });
            }).catch(error => {
                this.setState({
                    saving: false,
                });

                notification.error({
                    message: '操作失败',
                    description: ErrorMessageExtractor.extractResponseError(error),
                    duration: 5,
                });
            });
        });
    }

    render() {
        const formItemLayout = {
            labelCol: { span: 6 },
            wrapperCol: { span: 14 },
        };
        const { getFieldDecorator } = this.props.form;
        const groupOptions = Metadata.groups.map(group => {
            return <Option key={group.id}>{group.name}</Option>
        });

        return (
            <Page title="新增用户">
                <h2 className="layout-page-section-title"><span>新用户资料</span></h2>
                <Form horizontal>
                    <Row>
                        <Col span={8}>
                            <FormItem label="归属小组" {...formItemLayout}>
                                {getFieldDecorator('groupId', {
                                    rules: [
                                        {required: true, message: '请选择用户归属小组'},
                                    ]
                                })(
                                    <Select placeholder="选择用户归属小组">
                                        {groupOptions}
                                    </Select>
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <FormItem label="姓名" {...formItemLayout}>
                                {getFieldDecorator('name', {
                                    rules: [
                                        {required: true, message: '请填写用户姓名'},
                                    ]
                                })(
                                    <Input placeholder="用户姓名" autoComplete="off"/>
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <FormItem label="邮箱" {...formItemLayout}>
                                {getFieldDecorator('email', {
                                    rules: [
                                        {required: true, message: '请填写用户邮箱'},
                                        {type: 'email', message: '邮箱地址格式不正确'},
                                    ]
                                })(
                                    <Input placeholder="用户邮箱" autoComplete="off"/>
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <FormItem label="手机" {...formItemLayout}>
                                {getFieldDecorator('mobile', {
                                    rules: [
                                        {required: true, message: '请填写用户手机号码'},
                                        {validator: Validators.validateMobile},
                                    ]
                                })(
                                    <Input placeholder="手机号码" autoComplete="off"/>
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <FormItem label="密码" {...formItemLayout}>
                                {getFieldDecorator('password', {
                                    rules: [
                                        {required: true, message: '请设置用户登录密码'},
                                    ]
                                })(
                                    <Input placeholder="登录密码" autoComplete="off"/>
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item wrapperCol={{span:8, offset:2}}>
                                <Button type="primary" loading={this.state.saving} onClick={this.handleSubmit.bind(this)}>保存用户资料</Button>
                            </Form.Item>
                        </Col>
                    </Row>
                </Form>
            </Page>
        )
    }
}

export default Form.create()(PageUserNew);

