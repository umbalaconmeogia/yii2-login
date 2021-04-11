<?php
namespace umbalaconmeogia\systemuser;

use Yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
    /**
     * Add configuration for command line.
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Config for command line.
        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'umbalaconmeogia\systemuser\commands';
        }
    }

    public function behaviors()
    {
        $behaviors = [];
        if (! Yii::$app instanceof \yii\console\Application) {
            $behaviors = [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        // [
                        //     'allow' => true,
                        //     'actions' => ['set-language'],
                        //     'roles' => ['?'],
                        // ],
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ];
        }

        return $behaviors;
    }
}