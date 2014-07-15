#!/usr/bin/python
# -*- coding: utf-8 -*-

import os

from fabric.api import *
from fabric.contrib.files import exists

env.user = 'root'

app_name = 'jimmyphimmasone'
local_dir = os.getcwd()

@task
def _requirements():
    puts('❯ Checking app requirements...')

    with hide('running', 'output'):
        if not os.path.isfile("%s/composer.phar" % (local_dir)):
            local('wget -nc -nv -q http://getcomposer.org/composer.phar')
        else:
            local('php composer.phar self-update -q')

@task
def install():
    execute(_requirements)

    puts('❯ Remove cache and dependencies...')
    local('rm -rf var/cache/*')
    local('rm -rf bower_components')
    local('rm -rf web/js')
    local('rm -rf web/css')

    puts('❯❯ Install composer vendors...')
    local('composer update --no-progress --prefer-source')

    puts('❯❯ Install gumby framework...')
    local('bower install gumby')
    local('bower update')

    puts('❯❯ CSS compile')
    local('compass compile')
    local('mkdir web/css/fonts')
    local('mkdir web/css/fonts/icons')
    local('cp bower_components/gumby/fonts/icons/entypo.eot web/css/fonts/icons/')
    local('cp bower_components/gumby/fonts/icons/entypo.ttf web/css/fonts/icons/')
    local('cp bower_components/gumby/fonts/icons/entypo.woff web/css/fonts/icons/')
    local('cp bower_components/animate.css/animate.css web/css/')
    local('cp bower_components/swipebox/src/css/swipebox.min.css web/css/')
    local('cp src/frontend/css/main.css web/css/')
    local('cp src/frontend/css/main.admin.css web/css/')

    puts('❯❯ Javascript compile vendors...')
    local('claymate build')
    local('bower install gumby-images')

    local('mkdir web/js')
    local('mv gumby.min.js web/js')
    local('cp bower_components/jquery/jquery.min.js web/js/')
    local('cp bower_components/jquery/jquery.min.map web/js/')
    local('cp bower_components/modernizr/modernizr.js web/js/')
    local('cp bower_components/scrollReveal.js/scrollReveal.js web/js/')
    local('cp bower_components/lazyloadxt/dist/jquery.lazyloadxt.min.js web/js/')
    local('cp bower_components/swipebox/src/js/jquery.swipebox.min.js web/js/')
    local('cp src/frontend/js/main.js web/js/')
    local('cp src/frontend/js/main.admin.js web/js/')

    local('cp bower_components/swipebox/src/img/icons.png web/img/')
    local('cp bower_components/swipebox/src/img/icons.svg web/img/')
    local('cp bower_components/swipebox/src/img/loader.gif web/img/')

    local('rm -rf index.html')

@task
def update():

    puts('❯ Update JS and CSS main')

    puts('❯❯ Copy CSS main')
    local('cp src/frontend/css/main.css web/css/')
    local('cp src/frontend/css/main.admin.css web/css/')

    puts('❯❯ Copy Javascript main')
    local('cp src/frontend/js/main.js web/js/')
    local('cp src/frontend/js/main.admin.js web/js/')