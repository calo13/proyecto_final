const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/login/index' : './src/js/login/index.js',
    'js/testepqa/index' : './src/js/testepqa/index.js',
    'js/testiac/index' : './src/js/testiac/index.js',
    'js/registro/index' : './src/js/registro/index.js',
    'js/candidato/index' : './src/js/candidato/index.js',
    'js/evaluacion/epqa' : './src/js/evaluacion/epqa.js',
    'js/evaluacion/iac' : './src/js/evaluacion/iac.js',
    'js/respuesta/epqa' : './src/js/respuesta/epqa.js',
    'js/respuesta/iac' : './src/js/respuesta/iac.js',
    'js/verrespuesta/epqa' : './src/js/verrespuesta/epqa.js',
    'js/verrespuesta/iac' : './src/js/verrespuesta/iac.js',    
    'js/verresultado/epqa' : './src/js/verresultado/epqa.js',
    'js/verresultado/iac' : './src/js/verresultado/iac.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        loader: 'file-loader',
        options: {
           name: 'img/[name].[hash:7].[ext]'
        }
      },
    ]
  }
};