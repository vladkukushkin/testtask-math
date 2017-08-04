<?php

use yii\db\Migration;

class m170804_133419_math extends Migration
{
    public function up()
    {
        if (empty($this->db->getTableSchema('{{%math}}'))) {
            $this->createTable(
                '{{%math}}',
                [
                    'id' => $this->primaryKey(),
                    'task' => $this->string(),
                    'result' => $this->integer(),
                ]
            );
        }
    }

    public function down()
    {
        if (!empty($this->db->getTableSchema('{{%math}}'))) {
            $this->dropTable('{{%math}}');
        }
    }
}
