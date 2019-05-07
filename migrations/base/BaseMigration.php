<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 08.11.18
 * Time: 20:13
 */

namespace migrations;

use yii\db\Migration;

class BaseMigration extends Migration
{
    protected $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
}