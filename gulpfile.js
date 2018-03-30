const gulp = require('gulp');
const uglify = require('gulp-uglify-es').default;
const pump = require('pump');
const shell = require('gulp-shell');
const del = require('del');

//cb callback
gulp.task('default', ['build'], function (cb) {
    return uglifyHandle(cb)
});

gulp.task('build', function () {
    return gulp.src('', {read: false})
        .pipe(shell([
            'npm run build'
        ]))
});

function uglifyHandle(cb) {
    return pump([
            gulp.src('public/js/vultr.js'),
            uglify(),
            gulp.dest('public/js/min'),
            gulp.src('public/js/vendor.js'),
            uglify(),
            gulp.dest('public/js/min'),
            // gulp.src('public/js/min/*'),
            // gulp.dest('public/js'),
        ], cb
    );
}