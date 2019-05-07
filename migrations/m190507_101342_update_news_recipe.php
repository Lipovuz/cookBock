<?php

use yii\db\Migration;

/**
 * Class m190507_101347_create_news_kitchens
 */
class m190507_101342_update_news_recipe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%recipe}}', 'kitchens_id', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%recipe}}','kitchens_id');
    }
}
