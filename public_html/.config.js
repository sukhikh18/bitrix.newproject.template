"use strict";

var main = module.exports = {
    /** {String} Path to the source directory. Target is root + src + ${*.*} */
    src: 'local/templates/new.project/',
    /** {String} Path to the destination directory. Target is root + dest + ${*.*} */
    dest: 'local/templates/new.project/',
};

const assets = 'assets/';

var paths = module.exports.paths = {
    assets: assets,
    module: assets + 'module/',

    markup: '**/*.html',

    styles: {
        settings: assets + 'scss/_site-settings.scss',
        src:  assets + 'scss/',
        dest: assets,
    },

    scripts: {
        src: assets + 'js/',
        dest: assets,
    },

    images: {
        src:  'img/high/',
        pages: 'page/**/img/high/',
        dest: 'img/',
    },

    pages: {
        src: assets + 'page/',
        dest: 'page/',
    },

    vendor: {
        src:  assets + 'vendor/_source/',
        dest: assets + 'vendor/',
    },
};

var webpack = module.exports.webpack = {
    entry: {
        main: paths.scripts.src + 'main',
        bootstrap: paths.vendor.src + 'bootstrap'
    },
    output: {
        filename: "[name].js",
    },
    module: {
        rules: [
        {
            test: /\.(js|jsx)$/,
            exclude: /(node_modules)/,
            loader: 'babel-loader',
            query: {
                presets: ["@babel/preset-env"],
            },
        },
        ],
    },
};

var vendor = module.exports.vendor = [
    {
        name: 'Jquery',
        src: './node_modules/jquery/dist/**/*',
        dest: paths.vendor.dest + 'jquery/'
    },
    {
        name: 'Cleave',
        src: './node_modules/cleave.js/dist/**/*',
        dest: paths.vendor.dest + 'cleave/'
    },
    {
        name: 'Slick',
        src: './node_modules/slick-carousel/slick/**/*',
        dest: paths.vendor.dest + 'slick/',
    },
    {
        name: 'Fancybox',
        src: './node_modules/@fancyapps/fancybox/dist/**/*',
        dest: paths.vendor.dest + 'fancybox/'
    },
    {
        name: 'Waypoints',
        src: './node_modules/waypoints/lib/**/*',
        dest: paths.vendor.dest + 'waypoints/'
    },
];
