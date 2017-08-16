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
                    'user_id' => $this->integer(),
                    'task' => $this->string(),
                    'result' => $this->decimal(10, 1),
                    'user_result' => $this->decimal(10, 1),
                    'is_correct' => $this->boolean(),
                    'is_finished' => $this->boolean(),
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
