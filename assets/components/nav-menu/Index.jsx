'use strict';

import React from 'react';
import { Menu, Icon } from 'antd';
const SubMenu = Menu.SubMenu;
import { Link } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;

export default class NavMenu extends React.Component {
    state = {
        openMenu: `${AppState.openMenu}`,
        selectedMenuItem: `${AppState.selectedMenuItem}`,
    };

    constructor(props) {
        super(props);
    }

    handleSelect({ item, key, selectedKeys }) {
        // console.log(item);
        // console.log(key);
        // console.log(selectedKeys);
        this.setState({
            selectedMenuItem: key,
        });
    }

    render() {
        const defaultOpenMenu = [this.state.openMenu];
        const defaultSelectedMenuItem = [this.state.selectedMenuItem];

        const menus = Metadata.menu.map(group => {
            return (
                <SubMenu key={group.id} title={group.title}>
                    {group.sub.map(sub => {
                        return (
                            <Menu.Item key={sub.id}><Link to={sub.url}><Icon type={sub.icon} />{sub.title}</Link></Menu.Item>
                        )
                    })}
                </SubMenu>
            )
        });

        return (
            <Menu onSelect={this.handleSelect.bind(this)}
                  defaultOpenKeys={defaultOpenMenu}
                  selectedKeys={defaultSelectedMenuItem}
                  mode="inline"
            >
                <Menu.Item key="dashboard"><Link to="/"><Icon type="file-text" />概况</Link></Menu.Item>
                {menus}
            </Menu>
        );
    }
}