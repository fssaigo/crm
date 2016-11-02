'use strict';

import React from 'react';
import { Menu, Icon } from 'antd';
const SubMenu = Menu.SubMenu;
import { Link } from 'react-router';

import AppState from '../../common/AppState.jsx';
const Metadata = AppState.Metadata;

export default class NavMenu extends React.Component {
    state = {
        parent: `${AppState.Menu.parent}`,
        sub: `${AppState.Menu.sub}`,
    };

    constructor(props) {
        super(props);
    }

    handleSelect({ item, key, selectedKeys }) {
        // console.log(item);
        // console.log(key);
        // console.log(selectedKeys);
        this.setState({
            sub: key,
        });
    }

    render() {
        const defaultOpenMenu = [this.state.parent];
        const defaultSelectedMenuItem = [this.state.sub];

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