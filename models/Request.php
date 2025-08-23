<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%requests}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
}
