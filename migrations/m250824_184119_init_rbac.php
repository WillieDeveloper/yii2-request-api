<?php

use yii\db\Migration;

class m250824_184119_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Создаем роли
        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);

        // Создаем разрешения
        $viewOwn = $auth->createPermission('viewOwn');
        $viewOwn->description = 'View own records';
        $auth->add($viewOwn);

        $create = $auth->createPermission('create');
        $create->description = 'Create records';
        $auth->add($create);

        $updateOwn = $auth->createPermission('updateOwn');
        $updateOwn->description = 'Update own records';
        $auth->add($updateOwn);

        $delete = $auth->createPermission('delete');
        $delete->description = 'Delete any records';
        $auth->add($delete);

        $index = $auth->createPermission('index');
        $index->description = 'List all records (admin only)';
        $auth->add($index);

        // Назначаем разрешения ролям
        $auth->addChild($user, $viewOwn);
        $auth->addChild($user, $create);
        $auth->addChild($user, $updateOwn);

        $auth->addChild($admin, $delete);
        $auth->addChild($admin, $index);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250824_184119_init_rbac cannot be reverted.\n";
    }
}
