'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import { Row, Col, Form, Input, Select, DatePicker, Button, Icon, Cascader } from 'antd';
const RangePicker = DatePicker.RangePicker;
const Option = Select.Option;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;

const dateFormat = 'YYYY-MM-DD HH:mm:ss';

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
            channelId: filters.channelId,
            isAssigned: filters.isAssigned,
            groupId: filters.groupId,
        };

        if (filters.dateTime && filters.dateTime.length) {
            query.startDateTime = filters.dateTime[0].valueOf();
            query.endDateTime = filters.dateTime[1].valueOf();
        }

        this.props.onChange(query);
    }

    render() {
        const formItemLayout = {
            labelCol: { span: 6 },
            wrapperCol: { span: 14 }
        };
        const { getFieldDecorator } = this.props.form;
        const channelOptions = Metadata.channel.map(channel => {
            return <Option key={channel.id}>{channel.name}</Option>;
        });
        const groupOptions = Metadata.groups.map(group => {
            return <Option key={group.id}>{group.name}</Option>;
        });

        return (
            <Form horizontal>
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
                        <Form.Item label="是否分配" {...formItemLayout}>
                            {getFieldDecorator('isAssigned', {

                            })(
                                <Select placeholder="选择分配情况">
                                    <Option value={0}>已分配</Option>
                                    <Option value={1}>未分配</Option>
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                    <Col span={8}>
                        <Form.Item label="小组" {...formItemLayout}>
                            {getFieldDecorator('groupId', {

                            })(
                                <Select placeholder="请选择小组">
                                    {groupOptions}
                                </Select>
                            )}
                        </Form.Item>
                    </Col>
                </Row>
                <Row>
                    <Col span={24}>
                        <Form.Item label="时间" labelCol={{span:2}}  wrapperCol={{span:8}}>
                            {getFieldDecorator('dateTime', {

                            })(
                                <RangePicker showTime format={dateFormat} />
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
    }
}

export default Form.create()(FilterList);