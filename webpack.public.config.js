const path = require('path');

module.exports = {
    entry: './src/js/public/index.js',
    output: {
        filename: 'swi-petition-public.min.js',
        path: path.resolve(__dirname, 'build'),
        environment: {
            arrowFunction: false,
            bigIntLiteral: false,
            const: false,
            destructuring: false,
            dynamicImport: false,
            forOf: false,
            module: false,
        },
    },
    module: {
        rules: [{
            test: /\.js$/,
            exclude: /(node_modules)/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: ['@babel/preset-env']
                }
            }
        }]
    },
};
