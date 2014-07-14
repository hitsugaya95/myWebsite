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

    local('mkdir -p cache log')

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
    local('rm -rf .sass-cache')
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

    puts('❯❯ Javascript compile vendors...')
    local('claymate build')
    local('bower install gumby-images')
    local('bower install gumby-inview')
    local('bower install gumby-parallax')
    local('claymate build --addons bower_components/gumby-images/gumby.images.js')
    local('claymate build --addons bower_components/gumby-inview/gumby.inview.js')
    local('claymate build --addons bower_components/gumby-parallax/gumby.parallax.js')

    local('mkdir web/js')
    local('mv gumby.min.js web/js')
    local('cp bower_components/jquery/jquery.min.js web/js/')
    local('cp bower_components/jquery/jquery.min.map web/js/')
    local('cp bower_components/modernizr/modernizr.js web/js/')