const gulp = require('gulp');
const uglify = require('gulp-uglify');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');

// Aufgabe: JavaScript minimieren
gulp.task('scripts', function () {
    return gulp.src('assets/js/**/*.js') // Pfad zu deinen JS-Dateien
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

// Aufgabe: SCSS zu CSS kompilieren
gulp.task('styles', function () {
    return gulp.src('assets/scss/**/*.scss') // Pfad zu deinen SCSS-Dateien
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(gulp.dest('dist/css'));
});

// Standardaufgabe
gulp.task('default', gulp.parallel('scripts', 'styles'));