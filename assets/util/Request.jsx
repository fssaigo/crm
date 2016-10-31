'use strict';

import axios from 'axios';

const io = axios.create({
    timeout: 1000 * 30,
    headers: {},
});

io.interceptors.response.use(response => {
    // console.log('log by res data interceptor', response);
    console.log(response)
    return response;
}, error => {
    // console.log('log by res error interceptor', error);
    if (error.response && error.response.data && error.response.data.code === '100003') {
        location.href = '/login';
    }

    return Promise.reject(error);
});

export const all = axios.all;
export const spread = axios.spread;

export function get(url, params) {
    return io.get(url, {
        params,
    });
}

export function post(url, data) {
    return io.post(url, data);
}

export function put(url, data) {
    return io.put(url, data);
}

export function del(url) {
    return io.delete(url);
}