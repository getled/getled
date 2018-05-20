var
	gulp = require( 'gulp' ),
	sass = require( 'gulp-sass' ),
	autoprefixer = require( 'gulp-autoprefixer' );

gulp.task( 'styles', function () {
	return gulp
		.src( 'style.scss' )
		.pipe( sass( { outputStyle: 'compressed' } ) )
		.pipe( autoprefixer( 'last 5 version' ) )
		.pipe( gulp.dest( '.' ) );
} );

gulp.task( 'watch', function () {
	gulp.watch( '**/*.scss', [ 'styles', ] );
} );

gulp.task( 'default', function () {
	gulp.start(
		'styles',
		'watch'
	);
} );