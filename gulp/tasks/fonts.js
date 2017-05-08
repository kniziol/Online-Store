'use strict';

var config = require('../config');
var helper = require('../helper');
var gulp = require('gulp');
var flatten = require('gulp-flatten');

gulp.task('fonts', ['clean-fonts'], function() {
    for (var contextName in config.application.contexts) {
        /*
         * Call of function hasOwnProperty() is required to avoid warning:
         * Possible iteration over unexpected (custom / inherited) members, probably missing hasOwnProperty check
         */
        if (config.application.contexts.hasOwnProperty(contextName)) {
            var assetsPaths = helper.getAssetsPaths(config, helper.assetType.fonts, contextName);

            gulp.src(assetsPaths)
                .pipe(flatten({
                    includeParents: -1
                }))
                .pipe(gulp.dest(config.path.fonts + '/' + contextName));
        }
    }

    gulp.src(config.path.bowerComponents + '/bootstrap-sass/assets/fonts/bootstrap/glyphicons*')
        .pipe(gulp.dest(config.path.fonts + '/bootstrap-glyphicons'));

    return gulp.src(config.path.bowerComponents + '/font-awesome/fonts/*')
        .pipe(gulp.dest(config.path.fonts + '/font-awesome'));
});
