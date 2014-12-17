
/**
 * Settings
 */

var path         = {
        app:    'content',
        dev:    'tmp',
        build:  'content/min'
    },
    app = {
        styles:     path.app + '/styles',
        scripts:    path.app + '/scripts',
        images:     path.app + '/images'
    },
    dev = {
        styles:     path.dev + '/styles',
        scripts:    path.dev + '/scripts',
        images:     path.dev + '/images'
    },
    build = {
        styles:     path.build + '/styles',
        scripts:    path.build + '/scripts',
        images:     path.build + '/images'
    };

/**
 * Gulp plugins
 */

var gulp        = require('gulp'),
    concat      = require('gulp-concat'),
    jshint      = require('gulp-jshint'),
    uglify      = require('gulp-uglify'),
    stylus      = require('gulp-stylus'),
    autoprefix  = require('gulp-autoprefixer'),
    jeet        = require('jeet'),
    nib         = require('nib'),
    browserSync = require('browser-sync');

/**
 * Tasks
 */

/** Clean **/

gulp.task('clean', function() {
    console.log('todo: clean task');
});

/** Scripts **/

gulp.task('scripts', function() {
    gulp.src(app.scripts + '/**/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(uglify())
        .pipe(concat('app.js'))
        .pipe(gulp.dest('build'));
});

/** Scripts minify **/

gulp.task('scripts-minify', function() {
    //
});

/** Styles **/

gulp.task('stylus', function () {
    gulp.src(app.styles + '/main.styl')
        .pipe(stylus({use: [jeet()]}))
        .pipe(gulp.dest(dev.styles));
});

/** Styles All **/

gulp.task('stylus-all', function () {
    gulp.src(app.styles + '/**/*.styl')
        .pipe(stylus())
        .pipe(gulp.dest(build.styles));
});

/** Styles Nib **/

gulp.task('stylus-nib', function () {
    gulp.src(app.styles + '/main.styl')
        .pipe(stylus({use: [nib()]}))
        .pipe(gulp.dest(build.styles));
});

/** Styles Compress **/

gulp.task('stylus-compress', function () {
    gulp.src(app.styles + '/main.styl')
        .pipe(stylus({
            use: [jeet(), nib()],
            compress: true
        }))
        .pipe(autoprefix({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(build.styles));
});

/** Browser sync **/

gulp.task('browser-sync', function() {
    var files = [
        'app/**/*.html',
        'app/styles/**/*.css',
        'app/images/**/*.png',
        'app/scripts/**/*.js'
    ];

    browserSync.init(files, {
        server: {
            baseDir: './app'
        }
    });
});

/**
 * Workflow
 **/

/** Serve **/

gulp.task('serve', function() {
    gulp.watch(app.styles+'/**/*.styl', ['stylus']);
});

/** Build **/

gulp.task('build', [
    'stylus-compress'
]);

/** Default **/

gulp.task('default', [
    'stylus',
    'serve'
]);

// Default gulp task to run
gulp.task('defaultdefault', ['nib']);
