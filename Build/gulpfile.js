'use strict';

/**
 * Dependencies
 */
let gulp = require('gulp'),
  sass = require('gulp-sass'),
  prefix = require('gulp-autoprefixer');

/**
 * Paths
 */
let scssPath = '../Resources/Private/Scss/',
  cssPath = '../Resources/Public/Css/';

let prefixerOptions = {
  overrideBrowserslist: ['last 2 versions']
};

/**
 * Task - Scss
 */
gulp.task('sass', () => {
  return gulp.src(scssPath + '*.scss')
    .pipe(sass({precision: 8}).on('error', sass.logError))
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(prefix(prefixerOptions))
    .pipe(gulp.dest(cssPath))
});

/**
 * Task - Watch
 */
gulp.task('watch', () => {
  gulp.watch(scssPath + '**/*.scss', gulp.series('sass'));
});

/**
 * Task - Combine
 */
gulp.task('default',
  gulp.series(['sass', 'watch'])
);
