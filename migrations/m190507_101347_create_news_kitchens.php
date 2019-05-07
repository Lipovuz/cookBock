<?php

use migrations\BaseMigration;

/**
 * Class m190507_101347_create_news_kitchens
 */
class m190507_101347_create_news_kitchens extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kitchens}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ], $this->tableOptions);

        $this->createIndex('FK_kitchens_kitchens_id', '{{%recipe}}', 'kitchens_id');
        $this->addForeignKey(
            'FK_kitchens_kitchens_id', '{{%recipe}}', 'kitchens_id', '{{%kitchens}}', 'id', 'RESTRICT', 'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_kitchens_kitchens_id','{{%recipe}}');
        $this->dropIndex('FK_kitchens_kitchens_id','{{%recipe}}');
        $this->dropTable('{{%kitchens}}');
    }
}
