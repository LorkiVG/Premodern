let project_folder = "public/frontend";

let fs = require('fs');

//!Подключение файловy
let path = {
  build: {
    css: project_folder + "/css/",
    js: project_folder + "/js/",
    fonts: project_folder + "/fonts/",
  },
  src: {
    css: project_folder + "/scss/**/**/*.scss",
    fonts: project_folder + "/fonts/*.ttf",
    js: project_folder + "/js_dev/**/**/*.js",

  },
  watch: {
    css: project_folder + "/scss/**/**/*.scss",
    js: project_folder + "/js_dev/**/**/*.js",
  },
  
};

let { src, dest } = require("gulp"),
  gulp = require("gulp"),
  del = require("del"),
  scss = require("gulp-sass"),
  autoprefixer = require("gulp-autoprefixer"),
  group_media = require("gulp-group-css-media-queries"),
  cleancss = require("gulp-clean-css"),
  rename = require("gulp-rename"),
  uglify = require("gulp-uglify-es").default,
  ttf2woff = require("gulp-ttf2woff"),
  ttf2woff2 = require("gulp-ttf2woff2"),
  livereload = require("gulp-livereload");
  
function clean(){
  return del(path.clean);
}

function css() {
  return src(path.src.css)
    .pipe(
      scss({
        outputStyle: "expanded",
      })
    )
    .pipe(group_media())
    .pipe(
      autoprefixer({
        overrideBrowserlist: ["last 3 versions"],
        cascade: false,
      })
    )
    .pipe(dest(path.build.css))
    .pipe(cleancss())
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(dest(path.build.css))
    .pipe(livereload());
}

function js() {
  return src(path.src.js)
    .pipe(uglify())
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(dest(path.build.js))
    .pipe(livereload());
}

function fonts() {
  src(path.src.fonts)
    .pipe(ttf2woff()).pipe(dest(path.build.fonts));
  return src(path.src.fonts)
    .pipe(ttf2woff2())
    .pipe(dest(path.build.fonts));
}




let build = gulp.series(
  gulp.parallel(js, css),
);
let watch = gulp.parallel(build, watchFiles);





function watchFiles(params) {
  livereload.listen();
  gulp.watch([path.watch.css], css);
  gulp.watch([path.watch.js], js);
}

//! Очищаем преведущую версию файла




exports.fonts = fonts;
exports.js = js;
exports.css = css;
exports.build = build;
exports.watch = watch;
exports.default = watch;
