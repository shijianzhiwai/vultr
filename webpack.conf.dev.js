const resolve = require('path').resolve;
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const url = require('url');

module.exports = (options = {}) => ({
    context: resolve(__dirname, 'resources/assets'),
    entry: {
        lib: "babel-polyfill", //ES8语法支持 async await
        vultr: resolve(__dirname, 'resources/assets/js/vultr.js'),
        vendor: resolve(__dirname, 'resources/assets/js/vendor')
    },
    output: {
        path: resolve(__dirname, 'public'),
        filename: 'js/[name].js?[hash]',
        chunkFilename: 'js/[name].chunk.js?[hash]',
        publicPath: "/",
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: ['vue-loader']
            },
            {
                test: /\.js$/,
                use: ['babel-loader'],
                exclude: /node_modules/
            },
            {
                test: /\.css$/,
                // use: ['style-loader', 'css-loader', 'postcss-loader']
                // css-loader使你能够使用类似@import和url（...）的方法实现require的功能，
                // style-loader将所有的计算后的样式加入页面中，二者组合在一起使你能够把样式表嵌入webpack打包后的js文件中
                // postcss 浏览器兼容 增加css样式前缀
                use: ExtractTextPlugin.extract({
                    use: ['css-loader', 'postcss-loader'],
                    fallback: 'style-loader'
                }),
            },
            {
                test: /\.(png|jpg|jpeg|gif|eot|ttf|woff|woff2|svg|svgz)(\?.+)?$/,
                use: [{
                    loader: 'url-loader',
                    options: {
                        limit: 1024,
                        name : 'static/[name].[ext]?[hash]',
                    }
                }]
            }
        ]
    },

    resolve: {
        extensions: ['*', '.js', '.jsx', '.vue'],
        alias: {'vue$': 'vue/dist/vue.common.js'}
    },

    plugins: [
        new ExtractTextPlugin({
            filename: 'css/vultr/[name].css?[hash]',
            allChunks: true
        }),
        new webpack.optimize.CommonsChunkPlugin({
            names: ['vendor'],
        }),
        new HtmlWebpackPlugin({
            filename: '../resources/views/vultr/index.blade.php',
            template: resolve(__dirname, 'resources/assets/html/vultr.html')
        })
    ]
});