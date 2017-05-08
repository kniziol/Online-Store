'use strict';

var gulp = require('gulp');
var livereload = require('gulp-livereload');

gulp.task('watch', function() {
    /*
     * A timeout variable
     */
    var timer = null;

    /*
     * Actual reload function
     */
    var letsReload = function(event) {
        var reload_args = arguments;

        /*
         * Stop timeout function to run livereload if this function is ran within the last 250ms
         */
        if (timer) {
            clearTimeout(timer);
        }

        /*
         * Check if any gulp task is still running
         */
        if (!gulp.isRunning) {
            timer = setTimeout(function() {
                livereload.changed.apply(null, reload_args);
            }, 250);
        }

        console.log('File ' + event.path + ' has been ' + event.type);
    };

    /*
     * Starts the server
     */
    livereload.listen();

    gulp
        .watch(
            [
                './src/**/*.scss',
                './vendor/meritoo/**/*.scss'
            ],
            {
                interval: 500,
                debounceDelay: 1000
            },
            ['sass']
        )
        .on('add', letsReload)
        .on('change', letsReload)
        .on('unlink', letsReload);

    gulp
        .watch(
            [
                './src/**/*.js',
                './vendor/meritoo/**/*.js'
            ],
            {
                interval: 500,
                debounceDelay: 1000
            },
            ['js']
        )
        .on('add', letsReload)
        .on('change', letsReload)
        .on('unlink', letsReload);
});
