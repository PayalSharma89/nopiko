const path = require("path");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
    entry: "../resources/js/app.js",
    output: {
        path: path.resolve(__dirname, "public/js"),
        filename: "bundle.js",
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader",
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader",
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
            },
        ],
    },
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
        },
        extensions: [".js", ".vue"],
    },
    plugins: [new VueLoaderPlugin()],
};
