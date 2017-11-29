'use strict';

var gulp = require('gulp'),
    watch = require('gulp-watch'),
    prefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    rigger = require('gulp-rigger'),
    cssmin = require('gulp-minify-css'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    rimraf = require('rimraf'),
    browserSync = require("browser-sync"),
    reload = browserSync.reload;

var path = {
    build: { //куда складывать готовые после сборки файлы
        html: 'wp-content/themes/sunsettheme/',
        js: 'wp-content/themes/sunsettheme/public/js/',
        style: 'wp-content/themes/sunsettheme/public/css/',
        img: 'wp-content/themes/sunsettheme/public/img/',
        fonts: 'wp-content/themes/sunsettheme/public/fonts/'
    },
    src: { //Пути откуда брать исходники
        html: 'wp-content/themes/sunsettheme/src/*.html',
        js: 'wp-content/themes/sunsettheme/src/js/**/*.js',
        style: 'wp-content/themes/sunsettheme/src/style/*.sass',
        img: 'wp-content/themes/sunsettheme/src/img/**/*.*',
        fonts: 'wp-content/themes/sunsettheme/src/fonts/**/*.*'
    },
    watch: { //за изменением каких файлов мы хотим наблюдать
        html: 'wp-content/themes/sunsettheme/src/**/*.html',
        js: 'wp-content/themes/sunsettheme/src/js/**/*.js',
        style: 'wp-content/themes/sunsettheme/src/style/**/*.sass',
        img: 'wp-content/themes/sunsettheme/src/img/**/*.*',
        fonts: 'wp-content/themes/sunsettheme/src/fonts/**/*.*'
    },
    clean: './wp-content/themes/sunsettheme/public'
};

var config = {
    server: {
        baseDir: "wp-content/themes/sunsettheme"
    },
    tunnel: true,
    host: 'localhost',
    port: 3000,
    logPrefix: "Local Server"
};

/*Таск сборки html*/
gulp.task('html:build', function () {
    gulp.src(path.src.html) //Выберем файлы по нужному пути
        .pipe(rigger()) //Прогоним через rigger
        .pipe(gulp.dest(path.build.html)) //Выплюнем их в папку wp-content/themes/sunsettheme/public
        .pipe(reload({stream: true})); //И перезагрузим наш сервер для обновлений
});
/*rigger, позволяет использовать такую конструкцию для импорта файлов:
//= template/footer.html
*/

/*Таск сборки js*/
gulp.task('js:build', function () {
    gulp.src(path.src.js) //Найдем наш main файл
        .pipe(rigger()) //Прогоним через rigger
        // .pipe(sourcemaps.init()) //Инициализируем sourcemap
        //.pipe(uglify()) //Сожмем наш js
        // .pipe(sourcemaps.write()) //Пропишем карты
        .pipe(gulp.dest(path.build.js)) //Выплюнем готовый файл в wp-content/themes/sunsettheme/public
        // .pipe(reload({stream: true})); //И перезагрузим сервер
});

/*Таск сборки SASS*/
gulp.task('style:build', function () {
    gulp.src(path.src.style) //Выберем наш style.sass
        .pipe(sass().on('error', sass.logError)) //Скомпилируем
        .pipe(prefixer()) //Добавим вендорные префиксы
        .pipe(gulp.dest(path.build.style)) //И в wp-content/themes/sunsettheme
        // .pipe(reload({stream: true}));
});

/*Таск сборки картинок*/
gulp.task('image:build', function () {
    gulp.src(path.src.img) //Выберем наши картинки
        .pipe(imagemin({ //Сожмем их
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest(path.build.img)) //И бросим в wp-content/themes/sunsettheme/public
        .pipe(reload({stream: true}));
});

/*Таск для шрифтов*/
gulp.task('fonts:build', function() {
    gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.build.fonts))
});

/*Таск сборки всего*/
gulp.task('build', [
    'html:build',
    'js:build',
    'style:build',
    'fonts:build'
]);

/*Watcher таск*/
gulp.task('watch', function(){
    watch([path.watch.html], function(event, cb) {
        gulp.start('html:build');
    });
    watch([path.watch.style], function(event, cb) {
        gulp.start('style:build');
    });
    watch([path.watch.js], function(event, cb) {
        gulp.start('js:build');
    });
    watch([path.watch.fonts], function(event, cb) {
        gulp.start('fonts:build');
    });
});

/*Таск запуска вебсервера*/
gulp.task('webserver', function () {
    browserSync(config);
});

/*Cleaner таск (очищаем папку продакшна*/
gulp.task('clean', function (cb) {
    rimraf(path.clean, cb);
});

//gulp.task('default', ['build', 'webserver', 'watch']);
gulp.task('default', ['build', 'webserver' , 'watch']);