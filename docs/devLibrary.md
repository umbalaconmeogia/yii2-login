# Step to dev yii2 library

Guide line of developing an yii2 library (used as dependency on yii2 based system)
(This document will be moved to another placed)

## Prepare an yii2 appcliation skeleten

Create a yii2 application source code Based on yii2 basic or advanced template.
This application is called *the test app* in this document.

## Create repository on Github

## Clone the surce code on local pc

```shell
git clone https://github.com/umbalaconmeogia/yii2-user.git
```

Here after we call it *the lib*.

Create *docs* and *src* directory in the directory of the lib.

Create *composer.json" file as following.
```json
{
    "name": "umbalaconmeogia/yii2-user",
    "description": "User login and user management",
    "type": "yii2-extension",
    "keywords": [
        "yii2",
        "extension",
		"user",
        "login",
        "manager"
    ],
    "license": "MIT",
    "authors": [
        {
            "name": "Tran Trung Thanh",
            "role": "Developer"
        }
    ],
    "require": {
		"umbalaconmeogia/yii2-batsg": "*"
    },
    "autoload": {
        "psr-4": {
            "umbalaconmeogia\\user\\": "src/"
        }
    }
}
```

## Add the lib into composer.json of the test app

```json
    "minimum-stability": "dev",
    "require": {
	    ....
		"umbalaconmeogia/yii2-user": "@dev"
    },
	"repositories": [
	    ....
	    {
		    "type": "path",
			"url": "../../../yii2-user"
		}
	]
```

Install the lib to *vendor* directory of the test app (symbolic link is created).
```shell
composer require umbalaconmeogia/yii2-user
```

## Config module in the test app common\config\main.php