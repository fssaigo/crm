'use strict';

export function extractResponseError(error) {
    console.log(error);
    return error.response && error.response.data && error.response.data.message || '请稍候再试，或者联系系统管理员';
}