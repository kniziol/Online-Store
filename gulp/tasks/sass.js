'use strict';

var config = require('../config');
var helper = require('../helper');
var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCss = require('gulp-clean-css');
var concatCss = require('gulp-concat-css');
var replace = require('gulp-replace');
var insert = require('gulp-insert');
var autoPrefixer = require('gulp-autoprefixer');
var sourceMaps = require('gulp-sourcemaps');
// var debug = require('gulp-debug');

gulp.task('sass', ['clean-sass'], function() {
    var task = null;

    for (var contextName in config.application.contexts) {
        /*
         * Call of function hasOwnProperty() is required to avoid warning:
         * Possible iteration over unexpected (custom / inherited) members, probably missing hasOwnProperty check
         */

        /*
         * For debug purposes only
         */
        // console.log('......................................................');
        // console.log(contextName);

        if (config.application.contexts.hasOwnProperty(contextName)) {
            var assetsPaths = helper.getAssetsPaths(config, helper.assetType.stylesheets, contextName);

            /*
             * For debug purposes only
             */
            // console.log('......................................................');
            // console.log(assetsPaths);

            task = gulp.src(assetsPaths)
                /*
                 * Initialize sourcemaps prior to compiling SASS
                 */
                .pipe(sourceMaps.init())
                // .pipe(debug())
                /*
                 * Compile SASS
                 */
                .pipe(sass({
                        /*
                         * For debug purposes only
                         */
                        // outputStyle: 'expanded',    // Possible values: nested (default), expanded, compact, compressed
                        // sourceComments: true        // Possible values: false (default), true
                    })
                    .on('error', sass.logError))
                /*
                 * Prepare CSS styles
                 */
                .pipe(concatCss(contextName + '.css'))
                .pipe(replace(/(url\("\/fonts\/(?!font-awesome)(?!bootstrap-glyphicons))/g, '$1' + contextName + '/'))  // /fonts/  => /fonts/<context-name>, e.g. /fonts/frontend (Attention. Paths with "font-awesome" or "bootstrap-glyphicons" are skipped)
                .pipe(replace(/(\/images\/)/g, '$1' + contextName + '/'))                                               // /images/ => /images/<context-name>, e.g. /images/frontend
                .pipe(cleanCss({
                    /*
                     * For debug purposes only
                     */
                    // keepBreaks: true,           // Possible values: false (default), true
                    processImportFrom: [
                        '!fonts.googleapis.com'
                    ]
                }))
                /*
                 * Write sourcemap inline
                 */
                .pipe(sourceMaps.write())
                /*
                 * Reinitialise sourcemaps, loading inline sourcemap
                 */
                .pipe(sourceMaps.init({
                    loadMaps: true
                }))
                /*
                 * Run compiled CSS through autoprefixer
                 */
                .pipe(autoPrefixer({
                    browsers: ['last 2 versions']
                }))
                /*
                 * Write sourcemap to a separate file
                 */
                .pipe(sourceMaps.write('.'))
                /*
                 * Write CSS file to desitination path
                 */
                .pipe(gulp.dest(config.path.css));
        }
    }

    return task;
});
