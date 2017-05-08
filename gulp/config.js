'use strict';

/*
 * Tips:
 * 1. Assets related to the "common" context should be included first, because may contain assets required by the
 * concrete context. Specially JavaScripts' functions / libraries.
 */

/*
 * The "application" part of configuration.
 * Contains some global parameters, related to whole application.
 */
var application = {
    commonContext: 'common',
    contexts: {
        frontend: {}
    }
};

/*
 * The "path" part of configuration.
 * Contains paths of important directories.
 */
var path = {
    bowerComponents: './bower_components',
    css: './web/css',
    js: './web/js',
    fonts: './web/fonts',
    images: './web/images'
};

/*
 * The "assetCollection" part of configuration.
 * Contains collections of assets.
 */
var assetCollection = {
    js: {
        common: [
            path.bowerComponents + '/jquery/dist/jquery.js',
            path.bowerComponents + '/moment/min/moment-with-locales.js',
            path.bowerComponents + '/bootstrap-sass/assets/javascripts/bootstrap.js',
            path.bowerComponents + '/js-cookie/src/js.cookie.js',
            './src/**/' + application.commonContext + '/**/*.js',
            './src/**/{contextName}/**/*.js'
        ]
    },
    sass: {
        common: [
            './src/**/' + application.commonContext + '/**/[^_]*.scss',
            './src/**/{contextName}/**/[^_]*.scss'
        ]
    },
    images: {
        common: [
            './src/**/' + application.commonContext + '/**/*.{svg,png,jpg,gif}',
            './src/**/{contextName}/**/*.{svg,png,jpg,gif}'
        ]
    },
    fonts: {
        common: [
            './src/**/' + application.commonContext + '/**/*.{eot,svg,ttf,woff}',
            './src/**/{contextName}/**/*.{eot,svg,ttf,woff}'
        ]
    }
};

/*
 * Finally, all parameters of configuration
 */
module.exports = {
    application: application,
    path: path,
    assetCollection: assetCollection
};
