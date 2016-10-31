'use strict';

import React from 'react';

export default class Page extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                {/*<h1 className="layout-page-title">{this.props.title}</h1>*/}
                {this.props.children}
            </div>
        );
    }
}