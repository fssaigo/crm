'use strict';

import React from 'react';
import { Link } from 'react-router';
import { Menu, Icon, notification } from 'antd';
const SubMenu = Menu.SubMenu;

import AppState from '../../common/AppState.jsx';
import ModalPasswordReset from './ModalPasswordReset.jsx';
import User from '../../models/User.jsx';
import * as ErrorMessageExtractor from '../../util/ErrorMessageExtractor.jsx';

export default class SystemMenu extends React.Component {
    state = {
        menuIcon: 'user',
        modalSettingsVisible: false,
    };

    constructor(props) {
        super(props);
    }

    handleMenuClick(item) {
        switch (item.key) {
            case 'settings':
                this.handleRequestModalSettings();
                break;
            case 'logout':
                this.logout();
                break;
            default: break;
        }
    }

    logout() {
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

    handleRequestModalSettings() {
        this.setState({
            modalSettingsVisible: true,
        }, () => {

        });
    }

    handleCancelModalSettings() {
        this.setState({
            modalSettingsVisible: false,
        });
    }

    render() {
        const menuTitle = <span><Icon type={this.state.menuIcon} />{AppState.User.email}</span>;
        const selectedKeys = [];

        return (
            <div className="layout-system-menu-wrapper">
                <Menu
                    mode="horizontal"
                    theme="dark"
                    selectedKeys={selectedKeys}
                    onClick={this.handleMenuClick.bind(this)}
                >
                    <SubMenu title={menuTitle}>
                        <Menu.Item key="settings"><Icon type="setting" />修改密码</Menu.Item>
                        <Menu.Item key="logout">
                            <Icon type='logout' />退出系统
                        </Menu.Item>
                    </SubMenu>
                </Menu>
                <ModalPasswordReset
                    visible={this.state.modalSettingsVisible}
                    onCancel={this.handleCancelModalSettings.bind(this)}
                ></ModalPasswordReset>
            </div>
        );
    }
}
