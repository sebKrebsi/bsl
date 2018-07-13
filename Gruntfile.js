var jsFiles = {
    'web/js/vendor.js': [
        //externals
        'node_modules/jquery/dist/jquery.js',

        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',

        'node_modules/moment/min/moment-with-locales.js',
        'node_modules/datatables.net/js/jquery.dataTables.js',
        'node_modules/datatables.net-bs/js/dataTables.bootstrap.js',
        'node_modules/datatables.net-buttons/js/dataTables.buttons.js',
        'node_modules/datatables.net-buttons-bs/js/buttons.bootstrap.js',


        'app/Resources/js/vendor/layout/retina-1.1.0.js',
        'app/Resources/js/vendor/layout/jquery.hoverdir.js',
        'app/Resources/js/vendor/layout/jquery.hoverex.min.js',
        'app/Resources/js/vendor/layout/jquery.prettyPhoto.js',
        'app/Resources/js/vendor/layout/jquery.isotope.min.js',
        'app/Resources/js/vendor/layout/custom.js'

    ],
    'web/js/overviewClubs.js': [
        'app/Resources/js/default/overviewClubs.js'
    ],
    'web/js/news.js': [
        'app/Resources/js/default/news.js'
    ],
    'web/js/adminNews.js': [
        'app/Resources/js/admin/news/wysiwyg.js'
    ]

};

module.exports = function (grunt)
{
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        copy: {
            common: {
                files: [
                    {
                        expand: true,
                        flatten: true,
                        src: ['node_modules/bootstrap-sass/assets/fonts/bootstrap/*'],
                        dest: 'web/fonts/bootstrap',
                        filter: 'isFile'
                    },

                    {
                        expand: true,
                        flatten: true,
                        src: ['node_modules/font-awesome/fonts/*'],
                        dest: 'web/fonts',
                        filter: 'isFile'
                    }
                ]
            }
        },
        //use concat for jsFiles in dev env -> much faster
        concat: {
            jsDev: {
                files: jsFiles
            }
        },
        uglify: {
            production: {
                files: jsFiles
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                    loadPath: ['web/scss', 'node_modules']
                },
                files: {
                    'web/css/main.css': 'web/scss/main.scss'
                }
            }
        },
        cssmin: {
            externals: {
                files: {
                    'web/css/externals.css': [
                        'node_modules/selectize/dist/css/selectize.bootstrap3.css',
                        'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
                        'node_modules/datatables.net-buttons-bs/css/buttons.bootstrap.css'
                    ]
                }
            }
        },
        watch: {
            configFiles: {
                files: ['Gruntfile.js'],
                options: {
                    reload: true
                }
            },
            js: {
                files: ['app/Resources/js/**/*.js'],
                tasks: ['concat:jsDev'],
                options: {
                    spawn: false
                }
            },
            sass: {
                files: ['web/scss/**/*.scss'],
                tasks: ['sass'],
                options: {
                    spawn: false
                }
            }
        },
        jshint: {
            options: {
                browser: true,
                force: true,
                laxbreak: true,
                globals: {
                    jQuery: true
                },
                ignores: [
                    'app/Resources/js/vendor/**/*.js'
                ]
            },
            src: [
                'Gruntfile.js',
                'app/Resources/js/**/*.js'
            ]
        },
        assets_versioning: {
            production: {
                options: {
                    tag: 'hash',
                    post: true,
                    versionsMapFile: 'var/assets_mapping.json',
                    versionsMapTrimPath: 'web/',
                    tasks: ['sass:dist', 'cssmin:externals', 'uglify:production']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-chokidar');
    grunt.loadNpmTasks('grunt-assets-versioning');

    grunt.renameTask('chokidar', 'watch');
    grunt.registerTask('assets', ['copy', 'sass', 'cssmin']);
    grunt.registerTask('prod', ['jshint', 'copy', 'assets_versioning:production']);
    grunt.registerTask('dev', ['assets', 'concat:jsDev']);
    grunt.registerTask('default', ['dev', 'watch']);
};
