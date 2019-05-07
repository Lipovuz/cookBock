<?php

namespace app\models;

use app\models\behaviors\Slug;
use yii\db\ActiveRecord;
use app\modules\admin\models\Category;

/**
 * This is the model class for table "recipe".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $text
 * @property string $preview
 * @property int $status
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $slug
 */

class Recipe extends ActiveRecord
{


    public static function tableName()
    {
        return '{{%recipe}}';
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['user_id'=>'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => Slug::className(),
                'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true
            ]
        ];
    }

    public function rules()
    {
        return [
            [['status'],'default','value'=>User::STATUS_WORKED],
            [[ 'category_id',  'name', 'text', 'status'], 'required'],
            [['id', 'category_id', 'user_id', 'status'], 'integer'],
            [['text','description','preview','meta_description','meta_keywords'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категорія',
            'user_id' => 'User ID',
            'name' => 'Назва',
            'description' => 'Короткий опис',
            'text' => 'Рецепт',
            'preview'=> 'Прев\'ю',
            'status' => 'Статус',
            'meta_description' => 'Опис сторінки (description)',
            'meta_keywords' => 'Ключові слова сторінки (keywords)',
        ];
    }
}
