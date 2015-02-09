var gulp = require('gulp');

gulp.task('scripts', function() {
  var uglify = require('gulp-uglify');
  var rename = require('gulp-rename');
  gulp
    .src('Resources/public/src/**/*.js')
    .pipe(gulp.dest('Resources/public/dist'))
    .pipe(uglify())
    .pipe(rename(function (path) {
      path.basename += ".min";
    }))
    .pipe(gulp.dest('Resources/public/dist'))
  ;
});

gulp.task('clean', function() {
  var clean = require('gulp-clean');
  return gulp
    .src(['dist'], { read: false })
    .pipe(clean());
});

gulp.task('default', ['clean'], function() {
  gulp.start('scripts');

});

gulp.task('watch', ['default'], function() {
  gulp.watch(['src/**/*.js'], ['scripts']);
});
