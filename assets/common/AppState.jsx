'use strict';

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
var parent = window.__Metadata.menu.find(menu => {
   return menu.url === crumbs[0];
});
var sub = -1;

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

const AppState = {
    Metadata: window.__Metadata,
    User: JSON.parse(sessionStorage.getItem('user') || '{}'),
    openMenu: parent,
    selectedMenuItem: sub,
};

export default AppState;