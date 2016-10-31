'use strict';

import Dashboard from '../../modules/dashboard/Index.jsx';

import PageCustomerList from '../../modules/customer/List.jsx';
import PageCustomerNew from '../../modules/customer/New.jsx';
import PageCustomerDetail from '../../modules/customer/Detail.jsx';

import PageGroupList from '../../modules/group/List.jsx';

import PagePondList from '../../modules/pond/List.jsx';

export default [
    // Dashboard
    {
        pattern: '/',
        exactly: true,
        page: Dashboard
    },

    // 客户管理
    {
        pattern: '/customers',
        exactly: true,
        page: PageCustomerList
    },

    {
        pattern: '/customers/:id',
        page: PageCustomerDetail,
        conflicts: [
            {
                pattern: '/customers/new',
                exactly: true,
                page: PageCustomerNew
            }
        ]
    },

    // 小组管理
    {
        pattern: '/groups',
        exactly: true,
        page: PageGroupList
    },

    // 数据池
    {
        pattern: '/ponds',
        exactly: true,
        page: PagePondList
    }
];