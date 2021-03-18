const mix = require("laravel-mix");
const config = require("./webpack.config");

mix.webpackConfig(config)
    .js("resources/app/app.js", "public/js")
    .vue()
    // .postCss("resources/app/theme/app.scss", "public/css", [
    // ])
    .sass("resources/app/theme/app.scss", "public/css")
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
