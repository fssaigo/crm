'use strict';

const path = require('path');

const CONTEXT = path.resolve(__dirname, './assets');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    context: CONTEXT,

    entry: {
        'singin': './entry/signin/Index.jsx',
        'app': './entry/app/Index.jsx'
    },

    output: {
        path: 'public/assets',
        filename: '[name].js',
        publicPath: 'assets'
    },

    module: {
        loaders: [{
            test: /\.jsx$/,
            exclude: /node_modules/,
            loader: 'babel'
        }, {
            test: /\.less$/,
            exclude: /node_modules/,
            loader: ExtractTextPlugin.extract('css!less')
        }]
    },

    externals: {
        'react': 'window.React',
        'react-dom': 'window.ReactDOM',
        'react-router': 'window.ReactRouter',
        'antd': 'window.antd',
        'mobx': 'window.mobx',
        'mobx-react': 'window.mobxReact',
        'axios': 'window.axios'
    },

    plugins: [
        new ExtractTextPlugin('[name].css')
    ]
};
