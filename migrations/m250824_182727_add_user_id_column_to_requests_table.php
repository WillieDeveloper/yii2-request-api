<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%requests}}`.
 */
class m250824_182727_add_user_id_column_to_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%requests}}', 'user_id', $this->integer()->notNull());
        $this->addForeignKey(
            'fk-requests-user_id',
            '{{%requests}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-requests-user_id', '{{%requests}}');
        $this->dropColumn('{{%requests}}', 'user_id');
    }
}
