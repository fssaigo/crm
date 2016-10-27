'use strict';

import React from 'react';
import { observer } from 'mobx-react';
import Page from '../../common/Page.jsx';
import { Row, Col, Form, Table, Spin, notification} from 'antd';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;

@observer
export default class PageGroupList extends React.Component {
    state = {
        groups: Metadata.groups.slice(),
    };

    constructor(props) {
        super(props);
    }

    render() {
        const columns = [
            {
                title: 'ID',
                key: 'id',
                dataIndex: 'id',
            },
            {
                title: '小组名称',
                key: 'name',
                dataIndex: 'name'
            }
        ];

        return (
            <Page>
                <Table
                    columns={columns}
                    dataSource={this.state.groups}
                    bordered
                />
            </Page>
        )
    }
}