'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import { Row, Col, Form, Input, Select, AutoComplete, Checkbox, Button, Icon, Cascader, Spin, notification } from 'antd';
const Option = Select.Option;
import { Redirect } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import * as Validators from '../../util/Validators.jsx';
import Customer from '../../models/Customer.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

@observer
class FormNew extends React.Component {
    state = {
        isSaving: false,
        saved: false,
        savedCustomerId: -1,
    }

    constructor(props) {
        super(props);
    }

    getRedirectPath() {
        return `/customers/${this.state.savedCustomerId}`;
    }

    handleSubmit(e) {
        e.preventDefault();

        this.props.form.validateFieldsAndScroll((errors, values) => {
            if (errors) {
                console.log('Errors in FormNew', errors);
                return;
            }

            this.setState({ isSaving: true });
            Customer.save(values).then(response => {
                this.setState({
                    isSaving: false,
                    saved: true,
                    savedCustomerId: response.data.id,
                });

                notification.success({
                    message: '操作成功',
                    description: '页面将跳转到该用户详情页面',
                    duration: 2,
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
        });
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
        const groupOptions = Metadata.groups.map(group => {
            return <Option key={group.id}>{group.name}</Option>;
        });
        const userOptions = this.props.users.map(user => {
            return <Option key={user.id}>{user.name}</Option>;
        });
        const receptionOptions = this.props.users.map(user => {
            return <Option key={user.id}>{user.name}</Option>;
        });
        const assistOptions = this.props.users.map(user => {
            return <Option key={user.id}>{user.name}</Option>;
        });

        return (
            <Form horizontal onSubmit={this.handleSubmit}>
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
                                rules: [
                                    {type: 'email', message: '邮箱地址格式不正确'}
                                ]
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
                <hr className="layout-page-split"/>
                <Row>
                    <Col span={8}>
                        <Form.Item wrapperCol={labelLessFormItemLayout}>
                            {getFieldDecorator('sent', {

                            })(
                                <Checkbox>发送加盟资料</Checkbox>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item wrapperCol={labelLessFormItemLayout}>
                            {getFieldDecorator('visit', {

                            })(
                                <Checkbox>是否来访</Checkbox>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item wrapperCol={labelLessFormItemLayout}>
                            {getFieldDecorator('intention', {

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

                            })(
                                <Checkbox>签订正式合同</Checkbox>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item wrapperCol={labelLessFormItemLayout}>
                            {getFieldDecorator('pay', {

                            })(
                                <Checkbox>加盟费缴纳</Checkbox>
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
                <hr className="layout-page-split"/>
                <Row>
                    <Col span={8}>
                        <Form.Item label="所属小组" {...formItemLayout}>
                            {getFieldDecorator('groupId', {

                            })(
                                <Select placeholder="选择所属小组">
                                    {groupOptions}
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="跟踪人员" {...formItemLayout}>
                            {getFieldDecorator('userId', {

                            })(
                                <Select placeholder="选择跟踪人员">
                                    {userOptions}
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
                    <Col span={8}>
                        <Form.Item label="接待人员" {...formItemLayout}>
                            {getFieldDecorator('reception', {

                            })(
                                <Select placeholder="选择接待人员">
                                    {receptionOptions}
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                </Row>
                <Row>
                    <Col span={24}>
                        <Form.Item wrapperCol={{span:8, offset:2}}>
                            <Button type="primary"
                                    loading={this.state.isSaving}
                                    disabled={this.state.saved}
                                    onClick={this.handleSubmit.bind(this)}
                            >保存新客户资料</Button>
                        </Form.Item>
                    </Col>
                </Row>
                {this.state.saved && (this.state.savedCustomerId > -1) && <Redirect to={this.getRedirectPath()} push />}
            </Form>
        )
    }
}

export default Form.create()(FormNew);