const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WebpackManifestPlugin = require('webpack-manifest-plugin');

module.exports = {
    mode: process.env.NODE_ENV || 'development',
    entry: {
        base: './assets/base.js',
        home: './assets/home.js',
    },
    output: {
        path: `${__dirname}/public/assets/`,
        filename: '[chunkhash].js',
        publicPath: '/assets/',
    },
    module: {
        strictExportPresence: true,
        rules: [
            {
                test: /\.(css|scss)$/,
                rules: [
                    {
                        use: {
                            loader: MiniCssExtractPlugin.loader,
                        },
                    },
                    {
                        use: {
                            loader: 'css-loader',
                        },
                    },
                    {
                        use: {
                            loader: 'postcss-loader',
                        },
                    },
                    {
                        test: /\.scss$/,
                        use: {
                            loader: 'sass-loader',
                        },
                    },
                ],
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                },
            },
            {
                test: /\.(jpg|woff|woff2|ttf|eot|otf|svg)$/,
                use: {
                    loader: 'file-loader',
                },
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[chunkhash].css',
        }),
        new WebpackManifestPlugin({
            fileName: `${__dirname}/var/manifest.json`,
            writeToFileEmit: true,
        }),
    ],
    devServer: {
        contentBase: false,
        proxy: {
            '/': 'http://nginx',
        },
    },
};
