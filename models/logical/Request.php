<?php

namespace app\models\logical;

use app\models\Request as BaseRequest;
use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

class Request extends BaseRequest
{
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_RESOLVED = 'Resolved';
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function() {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }
    public function rules(): array
    {
        return [
            [['username', 'email', 'message'], 'required'],
            ['comment', 'required', 'when' => function ($model) {
                return $model->status === 'Resolved';
            }],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetAttribute' => ['username', 'email']],
            ['email', 'email'],
            [['status'], 'string', 'max' => 20],
            ['status', 'in', 'range' => [
                'Active',
                'Resolved',
            ]],
            ['status', 'default', 'value' => 'Active'],
            [['message', 'comment'], 'string'],
            ['comment', 'default', 'value' => null],
            ['user_id', 'integer'],
            ['user_id', 'default', 'value' => 1],
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function fields(): array
    {
        return ['id', 'username', 'email', 'status', 'message', 'comment'];
    }

    public function extraFields(): array
    {
        return ['created_at', 'updated_at'];
    }
}