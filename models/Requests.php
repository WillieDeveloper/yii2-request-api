<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
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
class Requests extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
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
    public function rules()
    {
        return [
            [['username', 'email', 'message'], 'required'],
            ['comment', 'required', 'when' => function ($model) {
                return $model->status === 'Resolved';
            }],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetAttribute' => ['username', 'email']],
            [['status'], 'string', 'max' => 20],
            ['status', 'in', 'range' => [
                'Active',
                'Resolved',
            ]],
            ['status', 'default', 'value' => 'Active'],
            [['message', 'comment'], 'string'],
            ['comment', 'default', 'value' => null],
        ];
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
