'use strict';

import React from 'react';
import { Row, Col, Form, Select, Input, Modal, Spin, notification } from 'antd';
const FormItem = Form.Item;
const Option = Select.Option;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import Group from '../../models/Group.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

class ModalGroupCreate extends React.Component {
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

                this.props.onOk(response.data);
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
        const userOptions = this.props.users.map(user => {
            return <Option key={user.id}>{user.name}</Option>
        });

        return (
            <Modal title="新建小组"
                   visible={this.props.visible}
                   confirmLoading={this.state.saving}
                   onCancel={this.props.onCancel}
                   onOk={this.handleOk.bind(this)}
            >
                <Spin spinning={this.props.loading}>
                    <Form horizontal>
                        <Row>
                            <Col span={24}>
                                <FormItem label="组长" labelCol={{span:4}} wrapperCol={{span:12}}>
                                    {getFieldDecorator('userId', {
                                        rules: [
                                            {
                                                required: true,
                                                message: '请选择小组组长',
                                            }
                                        ]
                                    })(
                                        <Select placeholder="组长名称">
                                            {userOptions}
                                        </Select>
                                    )}
                                </FormItem>
                            </Col>
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
                </Spin>
            </Modal>
        )
    }
}

export default Form.create({
    mapPropsToFields() {
        return {}
    }
})(ModalGroupCreate);