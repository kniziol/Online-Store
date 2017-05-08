'use strict';

var config = require('../config');
var helper = require('../helper');
var gulp = require('gulp');
var flatten = require('gulp-flatten');

gulp.task('images', ['clean-images'], function() {
    var task = null;

    for (var contextName in config.application.contexts) {
        /*
         * Call of function hasOwnProperty() is required to avoid warning:
         * Possible iteration over unexpected (custom / inherited) members, probably missing hasOwnProperty check
         */
        if (config.application.contexts.hasOwnProperty(contextName)) {
            var assetsPaths = helper.getAssetsPaths(config, helper.assetType.images, contextName);

            task = gulp.src(assetsPaths)
                .pipe(flatten({
                    includeParents: -1
                }))
                .pipe(gulp.dest(config.path.images + '/' + contextName));
        }
    }

    return task;
});
