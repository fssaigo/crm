'use strict';

import React from 'react';
import { Link } from 'react-router';
import { Row, Col, Form, Input, Modal, notification } from 'antd';
const FormItem = Form.Item;

import AppState from '../../common/AppState.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

class ModalPasswordReset extends React.Component {
    state = {
        saving: false,
        passwordDirty: false,
    };

    constructor(props) {
        super(props);
    }

    handleOk() {
        this.props.form.validateFields((errors, values) => {
            if (errors) {
                return;
            }

            this.setState({
                saving: true,
            });

            User.resetPassword(values.password, values.newPassword).then(response => {
                notification.success({
                    message: '操作成功',
                    description: `密码已修改，请重新登录`,
                    duration: 2,
                });
                this.props.onOk();
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

    handlePasswordBlur(e) {
        const value = e.target.value;
        this.setState({
            passwordDirty: this.state.passwordDirty || !!value
        });
    }

    checkConfirm(rule, value, callback) {
        if (value && this.state.passwordDirty) {
            this.props.form.validateFields(['repeatPassword'], { force: true });
        }

        callback();
    }

    checkPassword(rule, value, callback) {
        const form = this.props.form;
        if (value && value !== form.getFieldValue('newPassword')) {
            callback('确认密码不一致');
        } else {
            callback();
        }
    }

    render() {
        const { getFieldDecorator } = this.props.form;
        const formItemLayout = {
            labelCol: {
                span: 6,
                offset: 2,
            },
            wrapperCol: {
                span: 12,
            },
        };
        const lengthRule = {
            len: true,
            min: 6,
            message: '密码必须大于6位'
        };

        return (
            <Modal title="修改密码"
                   visible={this.props.visible}
                   onOk={this.handleOk.bind(this)}
                   onCancel={this.props.onCancel}
                   confirmLoading={this.state.saving}
            >
                <Form horizontal>
                    <Row>
                        <Col span={24}>
                            <FormItem label="当前密码" {...formItemLayout}>
                                {getFieldDecorator('password', {
                                    rules: [
                                        {required: true, message: '请输入当前密码'},
                                        {...lengthRule}
                                    ]
                                })(
                                    <Input type="password"
                                           placeholder="当前密码"
                                           autoComplete="off"
                                    />
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <FormItem label="新密码" {...formItemLayout}>
                                {getFieldDecorator('newPassword', {
                                    rules: [
                                        {required: true, message: '请输入新密码'},
                                        {...lengthRule},
                                        {validator: this.checkConfirm.bind(this),},
                                    ]
                                })(
                                    <Input type="password"
                                           placeholder="新密码"
                                           autoComplete="off"
                                           onBlur={this.handlePasswordBlur.bind(this)}
                                    />
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <FormItem label="重复新密码" {...formItemLayout}>
                                {getFieldDecorator('repeatPassword', {
                                    rules: [
                                        {required: true, message: '重复新密码'},
                                        {...lengthRule},
                                        {validator: this.checkPassword.bind(this),},
                                    ]
                                })(
                                    <Input type="password"
                                           placeholder="当前密码"
                                           autoComplete="off"
                                    />
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </Modal>
        );
    }
}

export default Form.create({
    mapPropsToFields() {
        return {}
    }
})(ModalPasswordReset);
