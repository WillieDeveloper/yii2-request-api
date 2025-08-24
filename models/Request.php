<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "requests".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $status
 * @property string $message
 * @property string|null $comment
 * @property string $created_at
 * @property string $updated_at
 */
class Request extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%requests}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'status' => 'Статус обращения',
            'message' => 'Сообщение пользователя',
            'comment' => 'Ответ ответственного лица',
            'created_at' => 'Время создания заявки',
            'updated_at' => 'Время ответа на заявку ',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
