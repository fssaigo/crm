'use strict';

import React from 'react';
import { Button, Form, Input, Alert, Icon } from 'antd';
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
                window.location = '/home#!/';
            }).catch(error => {
                this.setState({
                    signining: false,
                    serverError: ErrorMessageExtractor.extractResponseError(error),
                });
            });
        });
    }

    render() {
        const { getFieldDecorator } = this.props.form;
        // const emailProps = getFieldProps('email', {
        //     validate: [{
        //         rules: [
        //             { required: true, message: '请填写登录邮箱'},
        //         ],
        //         trigger: 'onBlur',
        //     }, {
        //         rules: [
        //             { type: 'email', message: '请输入正确的邮箱地址' },
        //         ],
        //         trigger: ['onBlur', 'onChange'],
        //     }]
        // });
        // const passwordProps = getFieldProps('password', {
        //     rules: [
        //         { required: true, whitespace: true, message: '请填写登录密码' },
        //     ]
        // });

        return (
            <div>
                <Form horizontal>
                    {this.state.serverError ? (
                        <FormItem style={{marginBottom:0}}>
                            <Alert message={this.state.serverError} type="error" showIcon />
                        </FormItem>
                    ) : ''}
                    <FormItem hasFeedback>
                        {getFieldDecorator('email', {
                            rules: [
                                {type: 'email', message: '邮箱地址格式不正确'}
                            ],
                            trigger: 'onBlur',
                        })(
                            <Input
                                addonBefore={<Icon type="user" />}
                                type="email"
                                autoComplete="off"
                                placeholder="登录邮箱"
                            />
                        )}
                    </FormItem>
                    <FormItem hasFeedback>
                        {getFieldDecorator('password', {
                            rules: [
                                { required: true, whitespace: true, message: '请填写登录密码' },
                                {
                                    len: true,
                                    min: 6,
                                    message: '密码必须大于6位'
                                }
                            ],
                            trigger: ['onBlur', 'onChange'],
                        })(
                            <Input
                                addonBefore={<Icon type="lock" />}
                                type="password"
                                autoComplete="off"
                                placeholder="登录密码"
                                onContextMenu={noop}
                                onPaste={noop}
                                onCopy={noop}
                                onCut={noop}
                            />
                        )}
                    </FormItem>
                    <FormItem>
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
