'use strict';

import React from 'react';
import { Button, Form, Input, Alert } from 'antd';
const createForm = Form.create;
const FormItem = Form.Item;

import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

function noop() {
    return false;
}

class SigninForm extends React.Component {
    state = {
        signining: false,
        serverError: null,
    };

    constructor(props) {
        super(props);
    }

    handleSubmit(e) {
        e.preventDefault();
        this.props.form.validateFields((errors, values) => {
            if (!!errors) {
                return;
            }

            this.setState({
                signining: true,
                serverError: ''
            });

            User.signin(values).then(response => {
                sessionStorage.user = JSON.stringify(response.data);
                window.location = '/home#!/customers';
            }).catch(error => {
                this.setState({
                    signining: false,
                    serverError: ErrorMessageExtractor.extractResponseError(error),
                });
            });
        });
    }

    render() {
        const { getFieldProps } = this.props.form;
        const emailProps = getFieldProps('email', {
            validate: [{
                rules: [
                    { required: true, message: '请填写登录邮箱'},
                ],
                trigger: 'onBlur',
            }, {
                rules: [
                    { type: 'email', message: '请输入正确的邮箱地址' },
                ],
                trigger: ['onBlur', 'onChange'],
            }]
        });
        const passwordProps = getFieldProps('password', {
            rules: [
                { required: true, whitespace: true, message: '请填写登录密码' },
            ]
        });
        const formItemLayout = {
            labelCol: { span: 7 },
            wrapperCol: { span: 12 },
        };

        return (
            <div>
                <Form horizontal>
                    {this.state.serverError ? (
                        <FormItem wrapperCol={{span:12,offset:7}} style={{marginBottom:0}}>
                            <Alert message={this.state.serverError} type="error" showIcon />
                        </FormItem>
                    ) : ''}
                    <FormItem
                        {...formItemLayout}
                        label="邮箱"
                        hasFeedback
                    >
                        <Input {...emailProps} name="email" type="email" autoComplete="off" placeholder="登录邮箱" />

                    </FormItem>
                    <FormItem
                        {...formItemLayout}
                        label="密码"
                        hasFeedback
                    >
                        <Input {...passwordProps} name="password" type="password" autoComplete="off" placeholder="登录密码"
                               onContextMenu={noop} onPaste={noop} onCopy={noop} onCut={noop}
                        />
                    </FormItem>
                    <FormItem wrapperCol={{ span: 12, offset: 7 }}>
                        <Button type="primary"
                                loading={this.state.signining}
                                onClick={this.handleSubmit.bind(this)}
                                style={{width:'100%'}}
                        >登录</Button>
                    </FormItem>
                </Form>
            </div>
        );
    }
}

export default createForm()(SigninForm);
