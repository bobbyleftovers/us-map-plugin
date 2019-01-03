const autoprefixer = require('autoprefixer');
const WebpackNotifierPlugin = require('webpack-notifier');
const VueLoader = require('vue-loader');
const path = require('path');

module.exports = {
    entry: ['./assets/sass/app.scss', './assets/js/app.js'],
    output: {
        filename: 'bundle.js',
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        },
        extensions: ['*', '.js', '.vue', '.json']
    },
    module: {
        rules: [
        {
            test: /\.scss$/,
            use: [
                {
                    loader: 'file-loader',
                    options: {
                        name: 'bundle.css',
                    },
                },
                {loader: 'extract-loader'},
                {loader: 'css-loader'},
                {loader: 'postcss-loader',
                    options: {
                        plugins: () => [autoprefixer()],
                    },
                },
                {
                    loader: 'sass-loader',
                    options: {
                        includePaths: ['./node_modules'],
                    },
                }
            ],
        },
        {
            test: /\.css$/,
            use: [
                {loader: 'style-loader'},
                {loader: 'css-loader'},
            ]
        },
        {
            test: /\.js$/,
            loader: 'babel-loader',
            query: {
                presets: ['es2015','vue'],
                plugins: ['transform-object-assign']
            },
        },
        {
            test: /\.vue$/,
            loader: 'vue-loader',
        },
        {
            test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
            use: [{
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]',
                    outputPath: 'fonts/'
                }
            }]
        },
        {
            test: /\.(gif|png|jpe?g|svg)$/i,
            use: [{
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]',
                    outputPath: 'images/'
                }
            }]
          }
        ],
    },
    plugins: [
        new VueLoader.VueLoaderPlugin(),
        new WebpackNotifierPlugin({
            contentImage: path.join(__dirname, 'webpack-logo.png'),
            title: 'Fen Says',
            alwaysNotify: true
        }),
    ]
};