<?php

use yii\db\Migration;

/**
 * Class m181202_204732_slug
 */

class m181202_204732_slug extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%category}}', 'meta_title');
        $this->dropColumn('{{%recipe}}', 'meta_title');
        $this->addColumn('{{%recipe}}', 'slug', $this->string()->null());
        $this->addColumn('{{%category}}', 'slug', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%recipe}}', 'slug');
        $this->dropColumn('{{%category}}', 'slug');
    }
}
