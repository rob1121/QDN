var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');


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
        "public/vendor/js/wow.js"
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
        "resources/assets/vendor/jquery-validation/dist/additional-methods.js",
        "resources/assets/js/additional-methods.js"
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
.copy(
    "resources/assets/vendor/typed.js/dist/typed.min.js",
    "public/vendor/js/typed.min.js"
)
.styles([
        "bootstrap.css",
        "font-awesome.css",
        "animate.css",
        "amaran.css",
        "pace.css"
    ], 'public/css/all.css')
     .babel([
        'nav.js',
        'footer.js'
    ], 'public/js/app.js')
    .scripts([
        "jquery.js",
        "jquery-ui.js",
        "jquery.validate.js",
        "additional-methods.js",
        "bootstrap.js",
        "amaran.js",
        "jquery.waypoints.js",
        "sticky.min.js"
    ], 'public/js/all.js')
    .copy("resources/assets/vendor/highcharts/highcharts.js",
        "resources/assets/js/highcharts.js")
    .copy(
        "resources/assets/js/highcharts.js",
        "public/vendor/js/highcharts.js"
)
    .copy("resources/assets/vendor/highcharts/modules/exporting.js",
        "resources/assets/js/exporting.js")
    .copy("resources/assets/js/exporting.js",
        "public/vendor/js/exporting.js")
        .version(['public/css/app.css', 'public/js/app.js'])

//for dashboard
        .copy(
            "resources/assets/vendor/adminLTE/dist/css/AdminLTE.min.css",
            "resources/assets/css/AdminLTE.css"
        ).copy(
            "resources/assets/vendor/adminLTE/dist/css/skins/_all-skins.min.css",
            "resources/assets/css/skin.css"
        ).copy(
            "resources/assets/vendor/adminLTE/dist/js/app.min.js",
            "resources/assets/js/adminApp.js"
        )
            .styles([
                "bootstrap.css",
                "font-awesome.css",
                "animate.css",
                "amaran.css",
                "pace.css",
                "AdminLTE.css",
                "skin.css"
            ], 'public/css/adminAll.css')
            .scripts([
                "jquery.js",
                "jquery-ui.js",
                "jquery.validate.js",
                "additional-methods.js",
                "bootstrap.js",
                "amaran.js",
                "adminApp.js"
            ], 'public/js/adminAll.js')

        });

elixir(function(mix) {
    mix.browserify('vue-issue.js');
});

elixir(function(mix) {
    mix.phpUnit()
        .browserSync({
            proxy: "qdn.me"
        });
});