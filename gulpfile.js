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
    gulp.start('sass', 'js', 'scripts', 'css');
});

gulp.task('clean', function () {
    del(['sass', 'js', 'scripts', 'css']);
});

gulp.task('sass', function () {
    return gulp.src([
        'assets/scss/main.scss'
    ])
        .pipe(sourcemaps.init(''))
        .pipe(sass().on('error', sass.logError))
        .on('error', browserifyHandler)
        .pipe(minifyCss({
            keepSpecialComments: 0
        }))
        .pipe(sourcemaps.write(''))
        .pipe(gulp.dest('web/css'))
        .pipe(browserSync.stream());
});

gulp.task('css', function () {
    return gulp.src([
        'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css'
    ])
        // .pipe(sourcemaps.init(''))
        .pipe(minifyCss({
            keepSpecialComments: 0
        }))
        // .pipe(sourcemaps.write(''))
        .pipe(concat('vendor.css'))
        .pipe(gulp.dest('web/css'))
        .pipe(browserSync.stream());
});

gulp.task('js', function () {
    return gulp.src([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.js'
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('web/js/'));
});

gulp.task('scripts', function() {
    return gulp.src([
        'assets/js/**/*.js'
    ])
        .pipe(sourcemaps.init())
        .on('error', browserifyHandler)
        .pipe(uglify())
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest('web/js'))
        .pipe(browserSync.stream());
});

function browserifyHandler(err) {
    util.log(util.colors.red('Error: ' + err.message));
    this.end();
}