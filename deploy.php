<?php

// All Deployer recipes are based on `recipe/common.php`.
require 'deployer/recipe/yii2-app-basic.php';
require_once "deployer/recipe/common.php";

set('default_stage', 'staging');
set('repository', 'git@github.com:alaink/stockout.git');
env('branch', 'master');

// Define a server for deployment.
server('stockout', 'stockout.wiredin.rw')
    ->user('stockout')
    ->pemFile('~/.ssh/StockoutDevServer.pem')
    ->stage('staging')
    ->env('deploy_path', '/var/www/vhosts/stockout.wiredin.rw/html/web');

// Specify the repository from which to download your project's code.
// The server needs to have git installed for this to work.
// If you're not using a forward agent, then the server has to be able to clone
// your project from this repository.


set('copy_dirs', [
    'assets',
    'commands',
    'config',
    'controllers',
    'mail',
    'migrations',
    'models',
    'runtime',
    'theme',
    'uploadedFiles',
    'views',
    'web',
    '.bowerrc',
    '.htaccess',
    'LICENSE.md',
    'requirements.php',
    'yii',
    'yii.bat',
    'composer.json',
    'composer.lock',
]);

set('shared_dirs', [
    'runtime',
    'web/assets',
]);


task('deploy:started', function() {
    writeln('<info>Deploying...</info>');
});

task('deploy:done', function() {
    writeln('<info>Deployment is done.</info>');
});

task('deploy:upload', function() {

    $files = get('copy_dirs');
    $releasePath = env('release_path');

    foreach ($files as $file)
    {
        upload($file, "{$releasePath}/{$file}");
    }
})->desc('Uploading files');

task('deploy:writable_dirs', function() {
    $deployPath = env('deploy_path');
    cd($deployPath);

    set('writable_dirs', get('shared_dirs'));
})->desc('Set writable dirs');

task('deploy:composer', function() {
    $deployPath = env('deploy_path');
    cd($deployPath);

    run("composer update --no-dev --prefer-dist --optimize-autoloader");
})->desc('Run composer');

task('deploy:run_migrations', function () {
    run('php {{release_path}}/yii migrate up --migrationPath=@vendor/dektrium/yii2-user/migrations --interactive=0');
    run('php {{release_path}}/yii migrate up --interactive=0');
})->desc('Run migrations');

task('deploy:staging', [
    'deploy:prepare',
    'deploy:release',
    'deploy:upload',
    'deploy:writable_dirs',
    'deploy:composer',
    'deploy:run_migrations',
])->desc('Deploy application to staging.');


before('deploy:staging', 'deploy:started');
after('deploy:staging', 'deploy:done');

