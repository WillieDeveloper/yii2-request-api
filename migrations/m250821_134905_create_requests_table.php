<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requests}}`.
 */
class m250821_134905_create_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requests}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'status' => $this->string(20)->notNull()->defaultValue('Active'),
            'message' => $this->text()->notNull(),
            'comment' => $this->text(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addCheck('check-request-status', '{{%requests}}', "status IN ('Active', 'Resolved')");

        $this->createIndex('idx-requests-credentials', '{{%requests}}', ['username', 'email'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-requests-credentials', '{{%requests}}');

        $this->dropCheck('check-request-status', '{{%requests}}');

        $this->dropTable('{{%requests}}');
    }
}
