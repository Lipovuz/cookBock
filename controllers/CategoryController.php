<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 19.12.18
 * Time: 21:59
 */

namespace app\controllers;


use app\models\Recipe;
use app\models\User;
use app\modules\admin\models\Category;
use app\rbac\Rbac;
use yii\data\ActiveDataProvider;

class CategoryController extends BaseController
{


    /**
     * @param string|null $slug
     * @return string
     */
    public function actionView(string $slug = null)
    {
        if (\Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)) {
            $this->layout = '@app/modules/admin/views/layouts/main.php';
        }

        $category = Category::findOne(['slug' => $slug]);

        $recipe = Recipe::find()
            ->where(['status'=>User::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC]);

        if ($category) {
            $recipe->andWhere(['category_id' => $category->id]);
            $this->setMetaTag($category->meta_description, $category->meta_keywords);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $recipe,
            'pagination' => [
                'pageSize' => 25,
            ]
        ]);


        return $this->render('view',
            [
                'category' => $category,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}
