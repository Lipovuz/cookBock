<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\modules\admin\models\Category;
use yii\console\Controller;
use Faker\Factory;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

class CreateCategoryController extends Controller
{

    /**
     * Create category.
     */
    public function actionIndex()
    {
        $existCategories = [];
        for ($i=0; $i < 30; $i++) {
            $faker = Factory::create('ru_RU');
            $category = new Category();
            if (count($existCategories) > 0 && ($i % 2 === 0)) {
                $category->parent_id = $existCategories[rand(0, count($existCategories)-1)];
            }
            $category->name = $faker->city;
            $category->status = 10;
            $category->save();
            $existCategories[] = $category->id;
        }
    }
}
