'use strict';

const reQQ = /^\d{5,}$/;

export function validateQQ(rule, value, callback) {
    if (!value) {
        return callback();
    }

    if (reQQ.test(value)) {
        callback();
    } else {
        callback('QQ号码不正确');
    }
}

const reMobile = /^1[35789]\d{9}$/;

export function validateMobile(rule, value, callback) {
    if (!value) {
        return callback();
    }

    if (reMobile.test(value)) {
        callback();
    } else {
        callback('手机号码不正确');
    }
}