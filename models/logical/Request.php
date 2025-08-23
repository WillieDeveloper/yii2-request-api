<?php

namespace app\models\logical;

use app\models\Request as BaseRequest;
class Request extends BaseRequest
{
    public function rules()
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
        ];
    }

    public function fields()
    {
        return ['id', 'username', 'email', 'status', 'message', 'comment'];
    }

    public function extraFields()
    {
        return ['created_at', 'updated_at'];
    }
}