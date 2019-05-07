<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\commands;

use app\models\Kitchens;
use app\models\Recipe;
use app\models\User;
use app\modules\admin\models\Category;
use Faker\Factory;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreateRecipeController extends Controller
{


    /**
     * Create recipe.
     */
    public function actionIndex()
    {
        for ($i=0; $i < 50; $i++) {
            $faker = Factory::create('ru_RU');
            $recipe = new Recipe();
            $category_id = rand(1,count(Category::find()->all()));
            $kitchens_id = rand(1,count(Kitchens::find()->all()));
            $user_id = rand(1,count(User::find()->all()));

            $recipe -> category_id = $category_id;
            $recipe -> kitchens_id = $kitchens_id;
            $recipe -> user_id = $user_id;
            $recipe -> name = $faker->city;
            $recipe -> description = $faker->city;
            $recipe -> text = $faker->text;
            $recipe -> preview = null;
            $recipe -> status = 10;

            $recipe->save();
        }
    }
}
