var path = require('path');
var fs = require('fs');

var gulp = require('gulp');
// concat
var concat = require('gulp-concat')
// minify
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');
// file rename
var rename = require('gulp-rename');

// error handling
var plumber = require('gulp-plumber');

gulp.task('css.minify', function() {
  return gulp.src(['css/*.css', '!css/*.min.css'])
    .pipe(cleanCSS())
    .pipe(rename({extname: '.min.css'}))
    .pipe(gulp.dest('css/'));
});
gulp.task('js.minify', ['js.concat'], function() {
  gulp.src(['js/app.js'])
    .pipe(plumber())
    .pipe(uglify({
      output:{
        comments: /^!/
      }
    }))
    .pipe(rename({extname: '.min.js'}))
    .pipe(gulp.dest('js/'));
});
gulp.task('js.concat', function() {
  return gulp.src([
      'js/echo.min.js'
      , 'js/vtngq900000002r1.js'
      , 'js/vtngq900000002qw.js'
      , 'js/vtngq900000002qr.js'
      , 'js/vtngq900000002qm.js'
      , 'js/vtngq900000002rb.js'
      , 'js/vtngq900000002r6.js'
      , 'js/jquery-1.12.4.min.js'
      , 'js/vtngq900000002qw.js'
      , 'js/prospect.js'
    ])
    .pipe(plumber())
    .pipe(concat('app.js'))
    .pipe(gulp.dest('js/'));
});
gulp.task('js', ['js.concat', 'js.minify']);
gulp.task('css', ['css.minify']);
gulp.task('default', function() {
  gulp.watch(['js/*.js'], ['js']);
  gulp.watch(['css/*.css'], ['css']);
});

