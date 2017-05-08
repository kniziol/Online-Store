'use strict';

var config = require('../config');
var helper = require('../helper');
var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourceMaps = require('gulp-sourcemaps');
var flatten = require('gulp-flatten');
//var debug = require('gulp-debug');

gulp.task('js', ['clean-js'], function() {
    var task = null;

    for (var contextName in config.application.contexts) {
        /*
         * Call of function hasOwnProperty() is required to avoid warning:
         * Possible iteration over unexpected (custom / inherited) members, probably missing hasOwnProperty check
         */
        if (config.application.contexts.hasOwnProperty(contextName)) {
            var assetsPaths = helper.getAssetsPaths(config, helper.assetType.javaScripts, contextName);

            task = gulp.src(assetsPaths)
                .pipe(sourceMaps.init())
                .pipe(concat(contextName + '.js'))
                .pipe(uglify())
                .pipe(sourceMaps.write('.'))
                .pipe(gulp.dest(config.path.js));
        }
    }

    return task;
});
