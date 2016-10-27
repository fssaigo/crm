'use strict';

import React from 'react';
import { Row, Col, Form, Select, Modal, Spin, notification } from 'antd';
const FormItem = Form.Item;
const Option = Select.Option;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import Customer from '../../models/Customer.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

class UserAssignModal extends React.Component {
    state = {
        saving: false,
        loading: true,
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

            Customer.update(this.props.customers[0].id, {
                userId: values.userId
            }).then(response => {
                this.setState({
                    saving: false,
                });

                let users = this.props.groupUsers.filter(user => {
                    return user.id == values.userId;
                });
                let user = users.length && users[0];

                notification.success({
                    message: '操作成功',
                    description: `客户已分配至组员：${user.name}`,
                    duration: 5,
                });

                this.props.onOk(user);
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
        const userOptions = this.props.groupUsers.map(user => {
            return <Option key={user.id}>{user.name}</Option>
        });

        return (
            <Modal title="分配组员"
                   visible={this.props.visible}
                   confirmLoading={this.state.saving}
                   onCancel={this.props.onCancel}
                   onOk={this.handleOk.bind(this)}
            >
                <Spin spinning={this.props.loading}>
                    <Form horizontal>
                        <Row>
                            <Col span={24}>
                                <FormItem label="组员" labelCol={{span:4}} wrapperCol={{span:12}}>
                                    {getFieldDecorator('userId', {
                                        rules: [
                                            {
                                                required: true,
                                                message: '请选择组员',
                                            }
                                        ]
                                    })(
                                        <Select placeholder="请选择组员">
                                            {userOptions}
                                        </Select>
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
})(UserAssignModal);