'use strict';

import * as request from '../util/Request.jsx';

function list(offset = 0, size = 10) {
    return request.get('/api/users', {
        offset,
        size
    });
}

function getUsersByName(name) {
    name = encodeURIComponent(name);

    return request.get('/api/users/names', {
        name
    });
}

function save(group) {
    return request.post('/api/groups', group);
}

function update(id, user) {
    console.log(user)
}

function assign(id, users) {
    return request.get('/api/ponds/assign', {
        ids: users,
        groupId: id,
    });
}

export default {
    getUsersByName,
    list,
    save,
    update,
    assign,
}