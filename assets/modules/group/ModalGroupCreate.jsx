'use strict';

import React from 'react';
import { Row, Col, Form, Input, Modal, notification } from 'antd';
const FormItem = Form.Item;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import Group from '../../models/Group.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

class GroupCreateModal extends React.Component {
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

            Group.save({
                ...values
            }).then(response => {
                this.setState({
                    saving: false,
                });

                notification.success({
                    message: '操作成功',
                    description: `小组：${values.name} 已创建`,
                    duration: 5,
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

    render() {
        const { getFieldDecorator } = this.props.form;

        return (
            <Modal title="新建小组"
                   visible={this.props.visible}
                   confirmLoading={this.state.saving}
                   onCancel={this.props.onCancel}
                   onOk={this.handleOk.bind(this)}
            >
                <Form horizontal>
                    <Row>
                        <Col span={24}>
                            <FormItem label="名称" labelCol={{span:4}} wrapperCol={{span:12}}>
                                {getFieldDecorator('name', {
                                    rules: [
                                        {
                                            required: true,
                                            message: '请填写小组名称',
                                        }
                                    ]
                                })(
                                    <Input placeholder="小组名称"/>
                                )}
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </Modal>
        )
    }
}

export default Form.create({
    mapPropsToFields() {
        return {}
    }
})(GroupCreateModal);