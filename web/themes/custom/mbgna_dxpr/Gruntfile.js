module.exports = function(grunt) {
  const sass = require('node-sass');

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    babel: {
      options: {
        sourceMap: false
      },
      dist: {
        files: {
          'js/minified/autoplay.min.js': 'js/dist/autoplay.js',
          'js/minified/colorbox.min.js': 'js/dist/colorbox.js',
          'js/minified/nav.min.js': 'js/dist/nav.js'
        }
      }
    },
    terser: {
      options: {
        ecma: 2015
      },
      main: {
        files: {
          'js/minified/autoplay.min.js': 'js/dist/autoplay.js',
          'js/minified/colorbox.min.js': 'js/dist/colorbox.js',
          'js/minified/nav.min.js': 'js/dist/nav.js'
        },
      }
    },
    sass: {
      options: {
        implementation: sass,
        sourceMap: false,
        outputStyle:'compressed'
      },
      dist: {
        files: [{
          expand: true,
          cwd: 'scss/',
          src: '**/*.scss',
          dest: 'css/',
          ext: '.css',
          extDot: 'last'
        }]
      }
    },
    postcss: {
        options: {
            processors: require('autoprefixer'),
        },
        dist: {
            src: 'css/*.css',
        },
    },
    watch: {
      css: {
        files: ['scss/*.scss', 'scss/**/*.scss'],
        tasks: ['sass', 'postcss']
      },
      js: {
        files: ['js/dist/*.js'],
        tasks: ['babel', 'terser']
      }
    }
  });

  grunt.loadNpmTasks('grunt-babel');
  grunt.loadNpmTasks('grunt-terser');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.registerTask('default',['watch']);
}
