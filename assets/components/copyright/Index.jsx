'use strict';

import './style.less';
import React from 'react';

export default class Copyright extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const year = new Date().getFullYear();
        const copyrightYears = '2016' + (year > 2016 ? ` - ${year}` : '');
        const location = document.location;

        return (
            <p className="layout-copyright">Copyright (c) {copyrightYears} <a href={`${location.protocol}//${location.host}`}>{document.domain}</a> 版权所有</p>
        );
    }
}
