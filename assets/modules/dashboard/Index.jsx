'use strict';

import React from 'react';
import Page from '../../common/Page.jsx';
import { observer } from 'mobx-react';
import { Icon} from 'antd';

export default class Dashboard extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <h2><Icon type="area-chart" /></h2>
                <h2><Icon type="pie-chart" /></h2>
                <h2><Icon type="bar-chart" /></h2>
                <h2><Icon type="dot-chart" /></h2>
                <h2><Icon type="line-chart" /></h2>
            </div>
        )
    }
}