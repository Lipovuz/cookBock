<?php

use migrations\BaseMigration;

class m181106_102004_create_news_users extends BaseMigration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'password_reset_token' => $this->char(255)->null(),
            'auth_key' => $this->string(255),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'tel' => $this->string(11)->null(),
            'img' => $this->string(255)->null(),
            'role' => $this->string(10),
            'status' => $this->boolean()->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

        $this->batchInsert(
            '{{%users}}',
            [
                'username',
                'password',
                'auth_key',
                'name',
                'email',
                'tel',
                'role',
                'status',
                'created_at',
                'updated_at',
            ],
            [
                [
                    'admin',
                    Yii::$app->security->generatePasswordHash('admin'),
                    Yii::$app->security->generateRandomString(),
                    'Admin',
                    'admin@gmail.com',
                    '0389000900',
                    'admin',
                    '10',
                    time(),
                    time(),
                ],
                [
                    '1',
                    Yii::$app->security->generatePasswordHash('111111'),
                    Yii::$app->security->generateRandomString(),
                    '1',
                    '1@gmail.com',
                    '1111111111',
                    'user',
                    '10',
                    time(),
                    time(),
                ],
                [
                    '2',
                    Yii::$app->security->generatePasswordHash('111111'),
                    Yii::$app->security->generateRandomString(),
                    '2',
                    '2@gmail.com',
                    '2222222222',
                    'user',
                    '10',
                    time(),
                    time(),
                ],
                [
                    '3',
                    Yii::$app->security->generatePasswordHash('111111'),
                    Yii::$app->security->generateRandomString(),
                    '3',
                    '3@gmail.com',
                    '3333333333',
                    'user',
                    '10',
                    time(),
                    time(),
                ],
                [
                    '4',
                    Yii::$app->security->generatePasswordHash('111111'),
                    Yii::$app->security->generateRandomString(),
                    '4',
                    '4@gmail.com',
                    '4444444444',
                    'user',
                    '10',
                    time(),
                    time(),
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
