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
            groupId: filters.groupId,
        };

        this.props.onChange(query);
    }

    render() {
        const formItemLayout = {
            labelCol: { span: 6 },
            wrapperCol: { span: 14 }
        };
        const { getFieldDecorator } = this.props.form;
        const groupOptions = Metadata.groups.map(group => {
            return <Option key={group.id}>{group.name}</Option>;
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
                        <Form.Item label="小组" {...formItemLayout}>
                            {getFieldDecorator('groupId', {

                            })(
                                <Select placeholder="选择用户小组">
                                    {groupOptions}
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
    }
}

export default Form.create()(FilterList);