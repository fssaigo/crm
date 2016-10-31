'use strict';

import './style.less';
import React from 'react';
import classNames from 'classnames';

export default class Header extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const headerClassNames = classNames({
            'layout-header': true,
            [this.props.className]: true
        });

        return (
            <header className={headerClassNames}>
                <div className="layout-header-container">
                    <a href="/home" className="layout-header-logo">开店易CRM</a>
                    {this.props.children}
                </div>
            </header>
        );
    }
}
