const path = require("path");
module.exports = {
  entry: {
    "block-editor": "./assets/js/block-editor.js",
    "block-frontend": "./assets/js/block-frontend.js",
  },
  output: {
    path: path.resolve(__dirname, "build"),
    filename: "[name].min.js",
  },
  module: {
    rules: [{ test: /\.js$/, exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
        type: 'javascript/auto',}],
  },
  resolve: {
    fullySpecified: false, // fixes ESM resolution issues
  }
};
