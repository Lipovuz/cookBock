<?php

namespace app\modules\profile;

use yii\filters\AccessControl;
use yii\base\Module as Modules;
use app\rbac\Rbac;

/**
 * profile module definition class
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN],
                    ],
                    [
                        'actions' => ['create','profile','update','delete','image-delete'],
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
    public $controllerNamespace = 'app\modules\profile\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
