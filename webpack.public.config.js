const path = require('path');

module.exports = {
    mode: 'development',
    watch: true,
    entry: './src/js/public/index.js',
    output: {
        filename: 'swi-petition-public.min.js',
        path: path.resolve(__dirname, 'build'),
    },
};
