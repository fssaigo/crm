'use strict';

import '../../common/common.less';
import './style.less';

import React from 'react';
import ReactDom from 'react-dom';

import Header from '../../components/header/Index.jsx';
import SigninForm from './Form.jsx';

class Login extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <Header />
                <div className="layout-page-container">
                    <s></s><s></s><s></s><s></s>
                    <h2 className="page-signin-title">登录「开店易」账号</h2>
                    <div className="page-signin-form">
                        <SigninForm />
                    </div>
                </div>
            </div>
        )
    }
}

ReactDom.render(<Login />, document.querySelector('.layout'));
