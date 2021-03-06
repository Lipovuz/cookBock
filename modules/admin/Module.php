<?php

namespace app\modules\admin;

use app\rbac\Rbac;
use yii\base\Module as Modules;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends Modules
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::PERMISSION_ADMIN_PANEL],
                    ],

                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [Rbac::ROLE_USER],
                    ],
                ],

            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
