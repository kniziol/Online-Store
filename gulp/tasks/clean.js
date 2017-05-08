'use strict';

var config = require('../config');
var gulp = require('gulp');
var del = require('del');

gulp.task('clean', [
    'clean-fonts',
    'clean-images',
    'clean-videos',
    'clean-sass',
    'clean-js'
]);

gulp.task('clean-fonts', function() {
    return del(config.path.fonts);
});

gulp.task('clean-images', function() {
    return del(config.path.images);
});

gulp.task('clean-videos', function() {
    return del(config.path.videos);
});

gulp.task('clean-sass', function() {
    return del(config.path.css);
});

gulp.task('clean-js', function() {
    return del(config.path.js);
});
