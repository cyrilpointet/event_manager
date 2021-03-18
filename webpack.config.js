const path = require("path");
const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");

module.exports = {
    module: {
        rules: [
            // {
            //     test: /\.tsx?$/,
            //     loader: "ts-loader",
            //     options: { appendTsSuffixTo: [/\.vue$/] },
            //     exclude: /node_modules/,
            // },
            {
                enforce: "pre",
                exclude: /node_modules/,
                loader: "eslint-loader",
                test: /\.(js|vue)?$/,
            },
        ],
    },
    plugins: [new VuetifyLoaderPlugin()],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/app/"),
        },
    },
};
