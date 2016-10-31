'use strict';

import * as request from '../util/Request.jsx';

function list(filters = {}, offset = 0, size = 10) {
    return request.get('/api/customers', {
        offset,
        ...filters,
        size
    });
}

function get(id) {
    return request.get(`/api/customers/${id}`);
}

function save(customer) {
    return request.post('/api/customers', customer);
}

function update(id, customer) {
    return request.put(`/api/customers/${id}`, customer);
}

export default {
    list,
    get,
    save,
    update,
}