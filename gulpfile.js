var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as copying vendor resources.
 |
 */

elixir(function(mix) {
mix.sass('app.scss')
    .babel([
        'nav.js',
        'footer.js'
    ], 'public/js/app.js')
    .scripts([
        "jquery.js",
        "jquery-ui.js",
        "jquery.validate.js",
        "bootstrap.js",
        "wow.js",
        "amaran.js",
        "jquery.waypoints.js",
        "sticky.min.js"
    ], 'public/js/all.js')
    .version('public/css/app.css','public/js/app.js');
});
/*
elixir(function(mix) {
mix.copy(
    "resources/assets/vendor/bootstrap/dist/css/bootstrap.min.css",
    "resources/assets/css/bootstrap.css"
)
    .copy(
        "resources/assets/vendor/font-awesome/css/font-awesome.min.css",
        "resources/assets/css/font-awesome.css"
)
    .copy(
        "resources/assets/vendor/font-awesome/fonts",
        "public/css/fonts"
)
    .copy(
        "resources/assets/vendor/AmaranJS/dist/css/amaran.min.css",
        "resources/assets/css/amaran.css"
)
    .copy(
        "resources/assets/vendor/AmaranJS/dist/css/animate.min.css",
        "resources/assets/css/animate.css"
)
    .copy(
        "resources/assets/vendor/select2/select2.css",
        "public/vendor/css/select2.css"
)
    .copy(
        "resources/assets/vendor/select2-bootstrap-css/select2-bootstrap.css",
        "public/vendor/css/select2-bootstrap.css"
)
    .copy(
        "resources/assets/vendor/jquery/dist/jquery.min.js",
        "resources/assets/js/jquery.js"
)
    .copy(
        "resources/assets/vendor/bootstrap/dist/js/bootstrap.min.js",
        "resources/assets/js/bootstrap.js"
)
    .copy(
        "resources/assets/vendor/select2/select2.min.js",
        "public/vendor/js/select2.min.js"
)
    .copy(
        "resources/assets/vendor/AmaranJS/dist/js/jquery.amaran.min.js",
        "resources/assets/js/amaran.js"
)
    .copy(
        "resources/assets/vendor/wow/dist/wow.min.js",
        "resources/assets/js/wow.js"
)
    .copy(
        "resources/assets/vendor/waypoints/lib/jquery.waypoints.js",
        "resources/assets/js/jquery.waypoints.js"
)
    .copy(
        "resources/assets/vendor/jquery-validation/dist/jquery.validate.js",
        "resources/assets/js/jquery.validate.js"
)
    .copy(
        "resources/assets/vendor/waypoints/lib/shortcuts/sticky.min.js",
        "resources/assets/js/sticky.min.js"
)
    .copy(
        "resources/assets/vendor/jquery-ui/jquery-ui.js",
        "resources/assets/js/jquery-ui.js"
).copy(
    "resources/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.css",
    "public/vendor/css/bootstrap-datepicker.css"
)
.copy(
    "resources/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js",
    "public/vendor/js/bootstrap-datepicker.js"
).copy(
    "resources/assets/vendor/PACE/themes/red/pace-theme-flat-top.css",
    "resources/assets/css/pace.css"
)
.copy(
    "resources/assets/vendor/PACE/pace.js",
    "resources/assets/js/pace.js"
)
.copy(
    "resources/assets/js/pace.js",
    "public/vendor/js/pace.js"
)
.styles([
        "bootstrap.css",
        "font-awesome.css",
        "animate.css",
        "amaran.css",
        "pace.css"
    ], 'public/css/all.css')
     .scripts([
        "jquery.js",
        "jquery-ui.js",
        "jquery.validate.js",
        "bootstrap.js",
        "wow.js",
        "amaran.js",
        "jquery.waypoints.js",
        "sticky.min.js",
        "pace.js"
    ], 'public/js/all.js');
});
*/