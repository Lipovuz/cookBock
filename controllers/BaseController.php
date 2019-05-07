<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 15.12.18
 * Time: 13:55
 */

namespace app\controllers;

use app\models\Recipe;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{


    /**
     * Set meta tags.
     *
     * @param string|null $description
     * @param string|null $keywords
     */
    public function setMetaTag(string $description = null, string $keywords = null)
    {
        if (null !== $description & !empty($description)) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $description,
            ]);
        }

        if (null !== $keywords & !empty($keywords)) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $keywords,
            ]);
        }
    }

    protected function findModelBySlug($slug)
    {
        if (($model = Recipe::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
