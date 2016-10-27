'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import { Row, Col, Form, Input, Select, Button, Icon, Cascader } from 'antd';
const Option = Select.Option;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;

class FilterList extends React.Component {
    constructor(props) {
        super(props);
    }

    handleReset(e) {
        e.preventDefault();
        this.props.form.resetFields();
        // this.props.onChange({});
    }

    handleSubmit(e) {
        e.preventDefault();

        let filters = this.props.form.getFieldsValue();
        let query = {
            name: filters.name,
            mobile: filters.mobile,
            qq: filters.qq,
            weixin: filters.weixin,
            provinceId: filters.area && filters.area[0],
            cityId: filters.area && filters.area[1],
            areaId: filters.area && filters.area[2],
            level: filters.level,
            channelId: filters.channelId,
            isVisited: filters.isVisited,
            isAssigned: filters.isAssigned,
        };

        this.props.onChange(query);
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
        return (
            <Form horizontal>
                <Row>
                    <Col span={8}>
                        <Form.Item label="姓名" {...formItemLayout}>
                            {getFieldDecorator('name', {

                            })(
                                <Input placeholder="输入客户姓名" autoComplete="off" />
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="手机" {...formItemLayout}>
                            {getFieldDecorator('mobile', {

                            })(
                                <Input placeholder="手机号码" autoComplete="off" />
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="QQ" {...formItemLayout}>
                            {getFieldDecorator('qq', {

                            })(
                                <Input placeholder="QQ号码" autoComplete="off" />
                            )}
                        </Form.Item>
                    </Col>
                </Row>
                <Row>
                    <Col span={8}>
                        <Form.Item label="微信" {...formItemLayout}>
                            {getFieldDecorator('weixin', {

                            })(
                                <Input placeholder="微信号码" autoComplete="off" />
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="意向区域" {...formItemLayout}>
                            {getFieldDecorator('area', {

                            })(
                                <Cascader options={Metadata.area} placeholder="选择客户意向区域" />
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="评级" {...formItemLayout}>
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
                        <Form.Item label="来源" {...formItemLayout}>
                            {getFieldDecorator('channelId', {

                            })(
                                <Select placeholder="选择来源渠道">
                                    {channelOptions}
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="是否到访" {...formItemLayout}>
                            {getFieldDecorator('isVisited', {

                            })(
                                <Select placeholder="选择到访情况">
                                    <Option value={0}>未到访</Option>
                                    <Option value={1}>已到访</Option>
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="是否分配" {...formItemLayout}>
                            {getFieldDecorator('isAssigned', {

                            })(
                                <Select placeholder="选择分配情况">
                                    <Option value={0}>未分配</Option>
                                    <Option value={1}>已分配</Option>
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                </Row>
                <Row>
                    <Col span={24}>
                        <Form.Item style={{textAlign:'center'}}>
                            <Button type="primary" loading={false} onClick={this.handleSubmit.bind(this)}>查询</Button>
                            <Button className="layout-secondary-button" onClick={this.handleReset.bind(this)}>重置</Button>
                        </Form.Item>
                    </Col>
                </Row>
            </Form>
        )

        const channelOptions = Metadata.channel.map(channel => {
            return <Option key={channel.id}>{channel.name}</Option>;
        });
    }
}

export default Form.create()(FilterList);