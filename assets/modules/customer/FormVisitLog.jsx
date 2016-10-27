'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import { Row, Col, Form, Input, Button, DatePicker, TimePicker, Icon, Timeline, notification } from 'antd';


import Visit from '../../models/Visit.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

const dateFormat = 'YYYY年MM月DD日';
const timeFormat = 'HH:mm:00';

@observer
class FormVisitLog extends React.Component {
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
                console.log('Errors in FormVisitLog', errors);
                return;
            }

            this.setState({ isSaving: true });

            let visitLog = {
                customerId: this.props.customer.id,
                nextVisitTime: `${values.date.format('YYYY-MM-DD')} ${values.time.format('HH:mm:00')}`,
                mark: values.mark,
            };

            Visit.save(visitLog).then(response => {
                this.props.visits.unshift(response.data);

                this.setState({
                    isSaving: false,
                });
                this.props.form.setFieldsValue({
                    mark: ''
                });

                notification.success({
                    message: '操作成功',
                    description: '回访记录已保存',
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
        const { getFieldDecorator } = this.props.form;
        const visits = this.props.visits.map((visit, index) => (
            <Timeline.Item>
                <p>{visit.created_at} {visit.user_name}</p>
                <p>{visit.mark}</p>
            </Timeline.Item>
        ))

        return (
            <div>
                <Form horizontal>
                    <Row>
                        <Col span={24}>
                            <Form.Item label="沟通记录" labelCol={{span:2}} wrapperCol={{span:8}}>
                                {getFieldDecorator('mark', {
                                    rules: [
                                        {
                                            required: true,
                                            message: '请输入回访沟通记录',
                                        }
                                    ]
                                })(
                                    <Input type="textarea" placeholder="输入回访沟通记录" autoComplete="off" autosize={{minRows:1,maxRows:6}} />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item label="回访日期" labelCol={{span:2}} wrapperCol={{span:8}}>
                                {getFieldDecorator('date', {
                                    rules: [
                                        {
                                            required: true,
                                            type: 'object',
                                            message: '请选择回访日期',
                                        }
                                    ]
                                })(
                                    <DatePicker format={dateFormat} />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item label="回访时间" labelCol={{span:2}} wrapperCol={{span:8}}>
                                {getFieldDecorator('time', {
                                    rules: [
                                        {
                                            required: true,
                                            type: 'object',
                                            message: '请选择回访时间',
                                        }
                                    ]
                                })(
                                    <TimePicker format={timeFormat} />
                                )}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={24}>
                            <Form.Item wrapperCol={{span:8, offset:2}}>
                                <Button loading={this.state.isSaving} onClick={this.handleSubmit.bind(this)}>保存沟通记录</Button>
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={22} offset={2}>
                            {/*<Timeline pending={<a>查看更多<Icon type="ellipsis" /></a>}>*/}
                            <Timeline>
                                {visits}
                            </Timeline>
                        </Col>
                    </Row>
                </Form>
            </div>
        )
    }
}

export default Form.create({
    mapPropsToFields() {
        let date = moment(new Date(), dateFormat).add(3, 'd');

        return {
            date: {
                value: date
            },

            time: {
                value: date
            }
        }
    }
})(FormVisitLog);