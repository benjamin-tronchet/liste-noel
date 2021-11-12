var localhostPath = '/liste-noel/app/index.php';
var localhostProxy = 'localhost';

// BASE
var gulp = require('gulp');
var watch = require('gulp-watch');
// SYNC
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;
// COMPRESSOR
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');
var imagemin = require('gulp-imagemin');
var gcmq     = require('gulp-group-css-media-queries');
// SASS
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
// TOOLS
var rename = require("gulp-rename");
var gulpif = require('gulp-if');
var useref = require('gulp-useref');
var del = require('delete');
var fs = require('fs');
// PATH
var appPath = './app/';
var sassPath = appPath + 'sass/';
var prodPath = './prod/';
// VARIABLES
var sassOptions = {
    errLogToConsole: true,
    outputStyle: 'expanded'
};
var autoprefixerOptions = {
    browsers: [
  "Android 2.3",
  "Android >= 4",
  "Chrome >= 20",
  "Firefox >= 24",
  "Explorer >= 8",
  "iOS >= 6",
  "Opera >= 12",
  "Safari >= 6"
  ]
};

//-----------------------------------------------------------------------
// SASS CONVERSION     
//-----------------------------------------------------------------------


gulp.task('sass', function () {
    return gulp
        .src(sassPath + 'app.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(appPath + 'css'))
        .pipe(browserSync.stream());
});


//-----------------------------------------------------------------------
// GULP SERVE
//-----------------------------------------------------------------------

gulp.task('serve', ['sass'], function () {
    browserSync.init({
        proxy: localhostProxy,
        startPath: localhostPath
    });
    gulp.watch("./app/sass/**/*.scss", ['sass']);
    gulp.watch("./app/js/*.js").on('change', browserSync.reload);
    gulp.watch("./app/**/*.{html,php}").on('change', browserSync.reload);
    watch('app/img/**/*').on('change', browserSync.reload);
    watch('app/fonts/**/*').on('change', browserSync.reload);
});

//-----------------------------------------------------------------------
// GULP BUILD
//-----------------------------------------------------------------------


// On efface le dossier prod
// si le dossier est effacé on effectue les autres opérations
gulp.task('build', function () {

    del(['prodPath'], function (err) {
        if (err) throw err;
        // On copie tous les fichiers et dossiers dans prod (sauf ceux indiqués)
        gulp
            .src([
                appPath + '**/*.*',
                appPath+'.htaccess',
                '!' + appPath + '**/*.{html,php}',
                '!' + appPath + 'img/**/*',
                '!' + appPath + 'css/**/*',
                '!' + appPath + 'js/**/*',
                '!' + appPath + 'sass/**/*'
            ])
            .pipe(gulp.dest('./prod/'));
        // On minifie toutes les images dans le dossier prod/image
        fs.stat(appPath + 'img/**/*', function (err, stat) {
            if (err != null) {
                gulp
                    .src(appPath + 'img/**/*')
                    .pipe(imagemin([
                        imagemin.gifsicle({
                            interlaced: true
                        }),
                        imagemin.jpegtran({
                            progressive: true
                        }),
                        imagemin.optipng({
                            optimizationLevel: 5
                        }),
                        imagemin.svgo({
                            plugins: [
                                {
                                    removeViewBox: true
                                },
                                {
                                    cleanupIDs: false
                                }
                            ]
                        })
                    ]))
                    .pipe(gulp.dest('./prod/img/'));
            }
        });
        // Useref compresse tous les fichiers (present dans build tag) css et js dans le dossier prod
        gulp
            .src([
                appPath + '**/*.{html,php}'
            ])
            .pipe(useref())
            .pipe(gulpif('*.js'))
            .pipe(gulpif('*.css', gcmq()))
            .pipe(gulpif('*.css', cleanCSS()))
            .pipe(gulp.dest('prod'));
    });
});