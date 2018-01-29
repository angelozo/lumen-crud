const gulp = require('gulp');
const browserSync = require('browser-sync');
const gulpWatch = require('gulp-watch');
const sass = require('gulp-sass');

gulp.task('watch', function() {
	browserSync.init({
		server: {
			baseDir: "./dist/"
		}
	});

	gulp.watch('src/*.html').on('change', function() {
		gulp.src('src/*.html')
			.pipe(gulp.dest('dist'));
	});

	gulp.watch('src/sass/*.scss').on('change', function() {
		gulp.src('src/sass/*.scss')
			.pipe(sass())
			.pipe(gulp.dest('dist/css'));
	});

	gulp.watch('src/js/*.js').on('change', function() {
		gulp.src('src/js/*.js')
			.pipe(gulp.dest('dist/js'));
	});

	gulp.watch('dist/*.html').on('change', browserSync.reload);
	gulp.watch('dist/js/*.js').on('change', browserSync.reload);
	gulp.watch('dist/css/*.css').on('change', browserSync.reload);
});

gulp.task('default', ['watch']);
