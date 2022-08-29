<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'recipe/deploy/lock.php';
require 'recipe/deploy/rollback.php';
require 'contrib/rsync.php';
require 'contrib/npm.php';


// Project name
set('application', 'chat.tassfx.com');
set('keep_releases', 5);

// laravel.php

task('prepare_application', function () {
    run('mkdir -p {{release_path}}/bootstrap/cache');
    run('mkdir -p {{release_path}}/storage/app/{public}');
    run('mkdir -p {{release_path}}/storage/framework/{cache,sessions,views}');
    run('mkdir -p {{release_path}}/storage/framework/cache/data');
    run('mv -f {{release_path}}/.env.dist {{deploy_path}}/shared/.env');
});
task('php-fpm:reload', function () {
    // nano /etc/sudoers
    // crm ALL=(ALL) NOPASSWD:/etc/init.d/php8.0-fpm reload
    run('sudo /etc/init.d/php8.0-fpm restart');
});
task('supervisor:reload', function () {
    // nano /etc/sudoers
    // crm ALL=(ALL) NOPASSWD:/usr/bin/supervisorctl reload
    run('sudo /usr/bin/supervisorctl restart all');
});

// Shared
add('shared_files', [
    '.env',
]);
add('shared_dirs', [
    'storage'
]);

// Writable
set('writable_chmod_mode', '0775');
set('writable_use_sudo', false);
add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

host('chat.tassfx.com')
    ->setRemoteUser('chat')
    ->setPort(22)
    ->setForwardAgent(true)
    ->setSshMultiplexing(true)
    ->setSshArguments(['-o UserKnownHostsFile=/dev/null'])
    ->setSshArguments(['-o StrictHostKeyChecking=no'])
    //->set('branch', 'main')
    ->set('deploy_path', '/home/chat/chat.tassfx.com')
    ->set('rsync_src', __DIR__)
    ->set('rsync_dest','{{release_path}}');

desc('Deploying...');

add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/.env.example',
        '/example.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.gitlab-ci.yml',
        'deploy_tasks.php',
        'staging.deploy.php',
        'production.deploy.php',
        '_ide_helper.php',
        '_ide_helper_models.php',
    ],
]);

task('deploy:update_code', ['rsync', 'prepare_application', 'deploy:vendors']);

after('deploy:failed', 'deploy:unlock');

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',   // Deploy code & built assets
    'deploy:shared',        // Default recipe
    'deploy:writable',      // Default recipe
    'artisan:view:clear',   // |
    'artisan:cache:clear',  // |
    'artisan:config:clear', // |
    'artisan:storage:link', // |
    'artisan:config:cache', // | Laravel specific steps
    'artisan:route:cache',  // |
    'artisan:view:cache',   // |
    'artisan:optimize',     // |
    'artisan:migrate',      // |
//    'artisan:db:seed',      // |
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success',
]);

desc('Finished');
