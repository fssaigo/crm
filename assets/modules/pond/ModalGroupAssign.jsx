'use strict';

import React from 'react';
import { Row, Col, Form, Select, Modal, notification } from 'antd';
const FormItem = Form.Item;
const Option = Select.Option;

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;
import Group from '../../models/Group.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

class GroupAssignModal extends React.Component {
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

            let ids = this.props.ponds.map(pond => {
                return pond.id;
            }).join(',');

            this.setState({
                saving: true,
            });

            Group.assign(values.group, ids).then(response => {
                this.setState({
                    saving: false,
                });

                let groups = Metadata.groups.filter(group => {
                    return group.id == values.group;
                });
                let group = groups.length && groups[0];

                notification.success({
                    message: '操作成功',
                    description: `客户已分配至小组：${group.name}`,
                    duration: 5,
                });

                this.props.onOk(group);
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
        const groupOptions = Metadata.groups.map(group => {
            return <Option key={group.id}>{group.name}</Option>
        });

        return (
            <Modal title="分配小组"
                   visible={this.props.visible}
                   confirmLoading={this.state.saving}
                   onCancel={this.props.onCancel}
                   onOk={this.handleOk.bind(this)}
            >
                <Form horizontal>
                    <Row>
                        <Col span={24}>
                            <FormItem label="小组" labelCol={{span:4}} wrapperCol={{span:12}}>
                                {getFieldDecorator('group', {
                                    rules: [
                                        {
                                            required: true,
                                            message: '请选择小组',
                                        }
                                    ]
                                })(
                                    <Select placeholder="请选择小组">
                                        {groupOptions}
                                    </Select>
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
})(GroupAssignModal);