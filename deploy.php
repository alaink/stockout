<?php

require 'vendor/deployer/deployer/recipe/yii2-app-basic.php';
require_once 'vendor/deployer/deployer/recipe/common.php';
require 'vendor/deployer/deployer/recipe/composer.php';

set('default_stage', 'staging');
set('repository', 'git@github.com:alaink/stockout.git');
env('branch', 'master');

// Define a server for deployment.
server('stockout', 'stockout.wiredin.rw')
    ->user('stockout')
    ->pemFile('~/.ssh/StockoutDevServer.pem')
    ->stage('staging')
    ->env('deploy_path', '/var/www/vhosts/stockout.wiredin.rw/html/web');

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
    'composer.json',
    'composer.lock',
    'LICENSE.md',
    'requirements.php',
    'yii',
    'yii.bat',
    'vendor.zip',
]);

set('shared_dirs', [
    'runtime',
    'web/assets',
]);

set('shared_files', [
    'config/db.php'
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

//    set('writable_dirs', get('shared_dirs'));
    set('writable_dirs', ['web/assets', 'runtime']);
})->desc('Set writable dirs');

task('deploy:set_web_assets_writable', function(){
    $deployPath = env('deploy_path');
    cd($deployPath);
    run('chmod -R 777 {{release_path}}/web/assets');
});
//task('deploy:composer', function() {
//    $deployPath = env('deploy_path');
//    cd($deployPath . '/release');
//
//    run("composer update --no-dev --prefer-dist --optimize-autoloader");
//})->desc('Run composer');

task('deploy:unzip_vendor', function(){
//    $deployPath = env('deploy_path');
//    cd($deployPath);
    run('unzip {{release_path}}/vendor.zip {{release_path}}'); // pbm with destination folder
})->desc('Unzip vendor.zip');

task('deploy:run_migrations', function () {
    run('php {{release_path}}/yii migrate up --migrationPath=@vendor/dektrium/yii2-user/migrations --interactive=0');
    run('php {{release_path}}/yii migrate up --interactive=0');
})->desc('Run migrations');

task('deploy:staging', [
    'deploy:prepare',
    'deploy:release',
    'deploy:upload',
    'deploy:writable_dirs',
//    'deploy:vendors',
//    'deploy:composer',
    //'deploy:unzip_vendor',
    'deploy:run_migrations',
    'deploy:set_web_assets_writable',
    'deploy:symlink',
])->desc('Deploy application to staging.');


before('deploy:staging', 'deploy:started');
after('deploy:staging', 'deploy:done');

