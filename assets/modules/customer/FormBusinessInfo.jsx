'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import { Row, Col, Form, Select, Input, Checkbox, Button, Icon, notification } from 'antd';
const Option = Select.Option;
import { Link } from 'react-router';

import Customer from '../../models/Customer.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
class FormBusinessInfo extends React.Component {
    state = {
        isSaving: false,
    };

    constructor(props) {
        super(props);
    }

    handleSubmit(e) {
        e.preventDefault();

        this.props.form.validateFieldsAndScroll((errors, values) => {
            if (errors) {
                console.log('Errors in FormBusinessInfo', errors);
                return;
            }

            this.setState({ isSaving: true });
            Customer.update(this.props.customer.id, values).then(response => {
                this.setState({
                    isSaving: false,
                });

                notification.success({
                    message: '操作成功',
                    description: '客户业务资料已保存',
                    duration: 5,
                });
            }, error => {
                this.setState({
                    isSaving: false
                });
                notification.error({
                    message: '操作失败',
                    description: ErrorMessageExtractor.extractResponseError(error),
                    duration: 5,
                });
            });
        })
    }

    render() {
        const formItemLayout = {
            labelCol: { span: 6 },
            wrapperCol: { span: 14 }
        };
        const labelLessFormItemLayout = {
            span: 14,
            offset: 6
        };
        const { getFieldDecorator } = this.props.form;
        const receptionOptions = this.props.users.map(user => {
            return <Option key={user.id}>{user.name}</Option>;
        });
        const assistOptions = this.props.users.map(user => {
            return <Option key={user.id}>{user.name}</Option>;
        });

        return (
            <div>
                <Form horizontal>
                    <Row>
                        <Col span={8}>
                            <Form.Item wrapperCol={labelLessFormItemLayout}>
                                {getFieldDecorator('sent', {
                                    valuePropName: 'checked'
                                })(
                                    <Checkbox>发送加盟资料</Checkbox>
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item wrapperCol={labelLessFormItemLayout}>
                                {getFieldDecorator('visit', {
                                    valuePropName: 'checked',
                                })(
                                    <Checkbox>是否来访</Checkbox>
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item wrapperCol={labelLessFormItemLayout}>
                                {getFieldDecorator('intention', {
                                    valuePropName: 'checked'
                                })(
                                    <Checkbox>签订意向合同</Checkbox>
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <Form.Item wrapperCol={labelLessFormItemLayout}>
                                {getFieldDecorator('official', {
                                    valuePropName: 'checked',
                                })(
                                    <Checkbox>签订正式合同</Checkbox>
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item wrapperCol={labelLessFormItemLayout}>
                                {getFieldDecorator('pay', {
                                    valuePropName: 'checked',
                                })(
                                    <Checkbox>加盟费缴纳</Checkbox>
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <Form.Item label="来访接待" {...formItemLayout}>
                                {getFieldDecorator('reception', {

                                })(
                                    <Select placeholder="选择接待人员">
                                        {receptionOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="协助跟踪" {...formItemLayout}>
                                {getFieldDecorator('assist', {

                                })(
                                    <Select placeholder="选择协助人员">
                                        {assistOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item label="备注" labelCol={{span:2}} wrapperCol={{span:8}}>
                                {getFieldDecorator('mark', {

                                })(
                                    <Input type="textarea" placeholder="输入备注内容" autoComplete="off" autosize={{minRows:1,maxRows:6}} />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item wrapperCol={{span:8, offset:2}}>
                                <Button loading={this.state.isSaving} onClick={this.handleSubmit.bind(this)}>保存业务跟踪资料</Button>
                                <Link className="layout-secondary-button" to="/customers"><Icon type="double-left" />返回列表</Link>
                            </Form.Item>
                        </Col>
                    </Row>
                </Form>
            </div>
        )
    }
}

export default Form.create({
    mapPropsToFields({ customer }) {
        let fields = {};

        if (customer.reception_id) {
            fields.reception = { value: '' + customer.reception_id }
        }

        if (customer.assist_id) {
            fields.assist = { value: '' + customer.assist_id }
        }

        return {
            ...fields,
            sent: { value: !!customer.is_sent },
            visit: { value: !!customer.is_visited },
            intention: { value: !!customer.is_signed_intention },
            official: { value: !!customer.is_signed_official },
            pay: { value: !!customer.is_paid },
            mark: { value: customer.mark },
        }
    }
})(FormBusinessInfo);