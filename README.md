# Yii2 Flysystem Component

The [Flysystem](https://flysystem.thephpleague.com) component for [Yii2](http://www.yiiframework.com/) PHP framework with more flexibility than similar components and integrated with Flysystem [MountManager](https://flysystem.thephpleague.com/mount-manager) and returns Flysystem objects as Yii2 component that helps to work with other libraries integrated with Flysystem like [Glide](http://glide.thephpleague.com) .

# Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/) .

Either run

```
composer require airani/yii2-flysystem
```

or add

```
"airani/yii2-flysystem": "~1.0"
```

to the require section of your composer.json file.

# Configuring

Configure application components for any of filesystem adapter as follows

```php
return [
    // ...
    'componenets' => [
        // ...
        'flysystem' => [
            'class' => 'airani\flysystem\MountManager',
            'localFs' => [ // https://flysystem.thephpleague.com/adapter/local/
                'class' => 'League\Flysystem\Adapter\Local',
                'root' => __DIR__.'/path/to/too',
            ],
            'ftpFs' => [ // https://flysystem.thephpleague.com/adapter/ftp/
                'class' => 'League\Flysystem\Adapter\Ftp',
                'config' => [
                    'host' => 'ftp.example.com',
                    'username' => 'username',
                    'password' => 'password',

                    // optional config settings
                    'port' => 21,
                    'root' => '/path/to/root',
                    'passive' => true,
                    'ssl' => true,
                    'timeout' => 30,
                ],
            ],
            // and config other filesystem adapters
            // read adapters section of flysystem guide https://flysystem.thephpleague.com
        ],
    ],
];
```

# Usage

To work with [MountManager](https://flysystem.thephpleague.com/mount-manager/) :
```php
// Read from FTP
$contents = Yii::$app->flysystem->read('ftp://some/file.txt');

// And write to local
Yii::$app->flysystem->write('local://put/it/here.txt', $contents);
```

Or simple usage:

```php
Yii::$app->filesystem->localFs->write('path/to/file.txt', 'contents');
```

for how to work with flysystem read this api [documentation](https://flysystem.thephpleague.com/api/) .
