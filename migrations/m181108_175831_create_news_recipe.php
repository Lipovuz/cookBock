<?php

use migrations\BaseMigration;

class m181108_175831_create_news_recipe extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('{{%recipe}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->boolean()->notNull(),
        ], $this->tableOptions);

        $this->createIndex('FK_recipe_category_id', '{{%recipe}}', 'category_id');
        $this->addForeignKey(
            'FK_recipe_category_id', '{{%recipe}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'RESTRICT'
        );

        $this->createIndex('FK_recipe_user_id', '{{%recipe}}', 'user_id');
        $this->addForeignKey(
            'FK_recipe_user_id', '{{%recipe}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_recipe_user_id','{{%recipe}}');
        $this->dropIndex('FK_recipe_user_id','{{%recipe}}');
        $this->dropForeignKey('FK_recipe_category_id','{{%recipe}}');
        $this->dropIndex('FK_recipe_category_id','{{%recipe}}');
        $this->dropTable('{{%recipe}}');
    }
}
