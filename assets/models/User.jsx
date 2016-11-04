'use strict';

import * as request from '../util/Request.jsx';

function list(filters = {}, offset = 0, size = 10) {
    return request.get('/api/users', {
        offset,
        ...filters,
        size
    });
}

function get(id) {
    return request.get(`/api/users/${id}`);
}


function getUsersByName(name) {
    name = encodeURIComponent(name);

    return request.get('/api/users/names', {
        name
    });
}

function getUserByMerchantAndGroup(merchantId, groupId) {
    return request.get(`/api/users/merchant/${merchantId}/group/${groupId}`);
}

function save(user) {
    return request.post('/api/users', user);
}

function update(id, user) {
    return request.put(`/api/users/${id}`, user);
}

function signin(credentials) {
    return request.post('/api/users/login', {
        ...credentials
    });
}

function signout() {
    return request.post('/api/users/logout');
}

export default {
    get,
    getUsersByName,
    getUserByMerchantAndGroup,
    list,
    save,
    update,
    signin,
    signout
}