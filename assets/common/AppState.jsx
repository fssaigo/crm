'use strict';

import { observable } from "mobx";

function pathToCrumbs(path) {
    path = path.replace(/^\//, '');
    let segs = path.split('/');

    return segs.reduce((crumbs, seg, index) => {
        if (index === 0) {
            crumbs.push('/' + seg);
            return crumbs;
        }

        crumbs.push(crumbs[index - 1] + '/' + seg);

        return crumbs;
    }, []);
}

let path = location.hash.replace('#!', '');
let crumbs = pathToCrumbs(path);
let parent = -1;
let sub = -1;

if (path === '/') {
    sub = 'dashboard';
} else {
    parent = window.__Metadata.menu.find(menu => {
        return menu.url === crumbs[0];
    });

    if (parent) {
        sub = parent.sub.find(sub => {
            return sub.url === crumbs[1];
        });

        if (sub) {
            parent = sub.parent_id;
            sub = sub.id;
        } else {
            sub = parent.sub[0].id;
            parent = parent.id;
        }
    }
}

class AppState {
    Metadata = {
        ...window.__Metadata,
        groups: observable(window.__Metadata.groups),
    };
    User = JSON.parse(sessionStorage.getItem('user') || '{}');
    Menu = {
        parent: parent,
        sub: sub,
    };
}

let state = new AppState();

window.state = state;

export default state;