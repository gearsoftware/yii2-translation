<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use yii\db\Migration;

class m150320_102452_init_translations extends Migration
{
    const MESSAGE_TABLE = '{{%message}}';
    const MESSAGE_SOURCE_TABLE = '{{%message_source}}';
    
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(self::MESSAGE_SOURCE_TABLE, [
            'id' => $this->primaryKey(),
            'category' => $this->string(32)->notNull(),
            'message' => $this->text(),
            'immutable' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);

        $this->createTable(self::MESSAGE_TABLE, [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->createIndex('message_index', self::MESSAGE_TABLE, ['source_id', 'language']);
        $this->addForeignKey('fk_message_source_message', self::MESSAGE_TABLE, 'source_id', self::MESSAGE_SOURCE_TABLE, 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', self::MESSAGE_TABLE);

        $this->dropTable(self::MESSAGE_TABLE);
        $this->dropTable(self::MESSAGE_SOURCE_TABLE);

    }
}