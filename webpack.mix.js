const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/main.js', 'public/js')
    .less('resources/css/app.less', '/css')
    .setPublicPath('./public')     // 设置public资源的存放目录，设置打包中资源的相对读取路径
    .setResourceRoot('./')
    .vue();

