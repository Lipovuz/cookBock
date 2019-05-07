<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 19.12.18
 * Time: 22:00
 */

namespace app\controllers;


use app\rbac\Rbac;
use Yii;
use yii\web\NotFoundHttpException;

class RecipeController extends BaseController
{


    /**
     * Displays a single Recipe model.
     * @param $recipe_slug
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws NotFoundHttpException
     */
    public function actionView($recipe_slug)
    {
        if (Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)) {
            $this->layout = '@app/modules/admin/views/layouts/main.php';
        }

        $model = $this->findModelBySlug($recipe_slug);
        $this->setMetaTag($model->meta_description,$model->meta_keywords);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
