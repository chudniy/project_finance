'use strict';
var gulp         = require('gulp'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    autoprefixer = require('gulp-autoprefixer'),
    sass         = require('gulp-sass'),
    minifyCss    = require('gulp-minify-css'),
    del          = require('del'),
    imagemin     = require('gulp-imagemin'),
    sourcemaps   = require('gulp-sourcemaps'),
    browserSync  = require('browser-sync').create(),
    util         = require('gulp-util');

gulp.task('default', ['clean'], function() {
    gulp.start('sass', 'js', 'scripts');
});

gulp.task('clean', function () {
    del(['sass', 'js', 'scripts']);
});