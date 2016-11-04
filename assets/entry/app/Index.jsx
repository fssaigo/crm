'use strict';

import '../../common/common.less';
import './style.less';

import React from 'react';
import ReactDom from 'react-dom';
import { Icon, Breadcrumb, Affix } from 'antd';
import { HashRouter, Match, Miss } from 'react-router';

import Header from '../../components/header/Index.jsx';
import SystemMenu from '../../components/system-menu/Index.jsx';
import NavMenu from '../../components/nav-menu/Index.jsx';
import Page404 from '../../components/page-404/Index.jsx';

import Routes from './Routes.jsx';

class App extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <HashRouter hashType="hashbang">
                <div>
                    <Header className="dark">
                        <SystemMenu/>
                    </Header>
                    <div className="layout-page-container">
                        <div className="layout-page-wrapper">
                            <aside className="layout-page-aside">
                                <Affix>
                                    <NavMenu/>
                                </Affix>
                            </aside>
                            <div className="layout-page-content">
                                {Routes.map((route, index) => {
                                    if (route.conflicts) {
                                        return (
                                            <Match key={index} pattern={route.pattern} render={(matchProps) => (
                                                <div>
                                                    {route.conflicts.map((similarRoute, similarIndex) => (
                                                        <Match
                                                            key={similarIndex}
                                                            pattern={similarRoute.pattern}
                                                            component={similarRoute.page}
                                                        />
                                                    ))}
                                                    <Miss render={() => <route.page {...matchProps} />} />
                                                </div>
                                            )} />
                                        )
                                    } else {
                                        return (
                                            <Match
                                                key={index}
                                                pattern={route.pattern}
                                                exactly={route.exactly}
                                                component={route.page}
                                            />
                                        )
                                    }
                                })}
                                <Miss component={Page404} />
                            </div>
                        </div>
                    </div>
                </div>
            </HashRouter>
        )
    }
}

ReactDom.render(<App />, document.querySelector('.layout'));
