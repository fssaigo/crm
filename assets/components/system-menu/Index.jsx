'use strict';

import React from 'react';
import { Menu, Icon, notification } from 'antd';
const SubMenu = Menu.SubMenu;

import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

export default class SystemMenu extends React.Component {
    state = {
        menuIcon: 'user'
    };

    constructor(props) {
        super(props);
    }

    handleMenuClick(e) {
        switch (e.key) {
            case 'logout':
                this.logout(e);
                break;
            default: break;
        }
    }

    logout(e) {
        this.setState({
            menuIcon: 'loading'
        });

        User.signout().then(response => {
            sessionStorage.removeItem('user');
            location.href = '/login';
        }).catch(error => {
            this.setState({
                menuIcon: 'user'
            });

            notification.error({
                message: '操作失败',
                description: ErrorMessageExtractor.extractResponseError(error),
                duration: 5,
            });
        });
    }

    render() {
        const menuTitle = <span><Icon type={this.state.menuIcon} />chenying@liziba.com</span>;
        const menuStyle = { float: 'right' };

        return (
            <Menu onClick={this.handleMenuClick.bind(this)} mode="horizontal" theme="dark" style={menuStyle}>
                <SubMenu title={menuTitle}>
                    {/*<Menu.Item key="settings"><Icon type="setting" />个人设置</Menu.Item>*/}
                    <Menu.Item key="logout">
                        <Icon type='logout' />退出系统
                    </Menu.Item>
                </SubMenu>
            </Menu>
        );
    }
}
