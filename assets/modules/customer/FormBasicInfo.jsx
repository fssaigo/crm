'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import { Row, Col, Form, Input, Select, Button, Icon, Cascader, notification } from 'antd';
const Option = Select.Option;
import { Link } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import * as Validators from '../../util/Validators.jsx';
import Customer from '../../models/Customer.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
class FormBasicInfo extends React.Component {
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
                console.log('Errors in FormBasicInfo', errors);
                return;
            }

            this.setState({ isSaving: true });
            Customer.update(this.props.customer.id, values).then(response => {
                this.setState({
                    isSaving: false,
                });

                notification.success({
                    message: '操作成功',
                    description: '客户基本资料已保存',
                    duration: 5,
                });
            }, error => {
                this.setState({
                    isSaving: false,
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
        const { getFieldDecorator } = this.props.form;
        const levelOptions = Metadata.level.map(level => {
            return <Option key={level.id}>{level.name}</Option>;
        });
        const sexOptions = Metadata.sex.map(sex => {
            return <Option key={sex.id}>{sex.name}</Option>;
        });
        const channelOptions = Metadata.channel.map(channel => {
            return <Option key={channel.id}>{channel.name}</Option>;
        });
        const investOptions = Metadata.invest.map(invest => {
            return <Option key={invest.id}>{invest.name}</Option>;
        });
        const experienceOptions = Metadata.experience.map(experience => {
            return <Option key={experience.id}>{experience.name}</Option>;
        });

        return (
            <div>
                <Form horizontal>
                    <Row>
                        <Col span={8}>
                            <Form.Item label="客户评级" {...formItemLayout}>
                                {getFieldDecorator('level', {

                                })(
                                    <Select placeholder="选择客户评级">
                                        {levelOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <Form.Item label="姓名" {...formItemLayout}>
                                {getFieldDecorator('name', {
                                    rules: [
                                        {required: true, message: '客户姓名必填'}
                                    ]
                                })(
                                    <Input id="control-input" placeholder="输入客户姓名" autoComplete="off" />
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="性别" {...formItemLayout}>
                                {getFieldDecorator('sex', {

                                })(
                                    <Select placeholder="选择客户性别">
                                        {sexOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="手机" {...formItemLayout}>
                                {getFieldDecorator('mobile', {
                                    rules: [
                                        {validator: Validators.validateMobile}
                                    ]
                                })(
                                    <Input id="control-input" placeholder="手机号码" autoComplete="off" />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <Form.Item label="邮箱" {...formItemLayout}>
                                {getFieldDecorator('email', {

                                })(
                                    <Input id="control-input" placeholder="邮箱地址" autoComplete="off" />
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="QQ" {...formItemLayout}>
                                {getFieldDecorator('qq', {
                                    rules: [
                                        {validator: Validators.validateQQ}
                                    ]
                                })(
                                    <Input id="control-input" placeholder="QQ号码" autoComplete="off" />
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="微信" {...formItemLayout}>
                                {getFieldDecorator('wx', {

                                })(
                                    <Input id="control-input" placeholder="微信联系情况" autoComplete="off" />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <Form.Item label="意向区域" {...formItemLayout}>
                                {getFieldDecorator('area', {

                                })(
                                    <Cascader options={Metadata.area} placeholder="选择客户意向区域" />
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="来源渠道" {...formItemLayout}>
                                {getFieldDecorator('channel', {

                                })(
                                    <Select placeholder="请选择客户来源渠道">
                                        {channelOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                        <Col span={8}>
                            <Form.Item label="投资额度" {...formItemLayout}>
                                {getFieldDecorator('invest', {

                                })(
                                    <Select placeholder="选择投资额度">
                                        {investOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={8}>
                            <Form.Item label="餐饮经验" {...formItemLayout}>
                                {getFieldDecorator('enter', {

                                })(
                                    <Select placeholder="选择客户有无餐饮经验">
                                        {experienceOptions}
                                    </Select>
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item label="经营经验" labelCol={{span:2}} wrapperCol={{span:8}}>
                                {getFieldDecorator('experience', {

                                })(
                                    <Input type="textarea" placeholder="经营管理经验描述" autoComplete="off" autosize={{minRows:1,maxRows:6}} />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item wrapperCol={{span:8, offset:2}}>
                                <Button loading={this.state.isSaving} onClick={this.handleSubmit.bind(this)}>保存基本资料</Button>
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
    // 初始化时绑定数据
    mapPropsToFields({ customer }) {
        let fields = {};

        if (customer.level !== '0') {
            fields.level = { value: customer.level }
        }

        if (customer.sex) {
            fields.sex = { value: '' + customer.sex }
        }

        if (customer.channel_id) {
            fields.channel = { value: '' + customer.channel_id }
        }

        if (customer.invest) {
            fields.invest = { value: '' + customer.invest }
        }

        if (customer.is_entered) {
            fields.enter = { value: '' + customer.is_entered }
        }

        return {
            ...fields,
            name: { value: customer.name },
            mobile: { value: customer.mobile },
            phone: { value: customer.phone },
            email: { value: customer.email },
            qq: { value: customer.qq },
            wx: { value: customer.weixin },
            area: { value: [customer.province_id, customer.city_id, customer.area_id] },
            experience: { value: customer.experience },
        }
    }
})(FormBasicInfo)