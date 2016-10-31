'use strict';

import * as request from '../util/Request.jsx';

function list(customerId, offset = 0, size = 10) {
    return request.get('/api/customers/visits', {
        customerId,
        offset,
        size
    });
}

function save(visit) {
    return request.post('/api/customers/visit', visit);
}

export default {
    list,
    save,
}