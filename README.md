# yii2-user
Provide functions relate to user login and user management.

## Edit composer.json

Run
```shell
composer require umbalaconmeogia/yii2-systemuser
```

or add `"umbalaconmeogia/yii2-systemuser": "*"` to composer.json then run `composer update`

## Edit config

Add to modules in config

```php
'modules' => [
    'systemuser' => [
        'class' => 'umbalaconmeogia\systemuser\Module',
    ],
    // Other stuffs
],
```

## Run migration

```shell
php yii migrate --migrationPath=@vendor/umbalaconmeogia/yii2-systemuser/src/migrations
```