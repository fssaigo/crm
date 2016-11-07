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

            User.resetPassword({ ...values }).then(response => {
                console.log(response.data);
                notification.success({
                    message: '操作成功',
                    description: `密码已修改，请重新登录`,
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
                                        {required: true, message: '请输入当前密码'}
                                    ]
                                })(
                                    <Input placeholder="当前密码" />
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <FormItem label="新密码" {...formItemLayout}>
                                {getFieldDecorator('newPassword', {
                                    rules: [
                                        {required: true, message: '请输入新密码'}
                                    ]
                                })(
                                    <Input placeholder="新密码" />
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <FormItem label="重复新密码" {...formItemLayout}>
                                {getFieldDecorator('repeatPassword', {
                                    rules: [
                                        {required: true, message: '重复新密码'}
                                    ]
                                })(
                                    <Input placeholder="当前密码" />
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
