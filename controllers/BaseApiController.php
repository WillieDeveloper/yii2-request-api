<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class BaseApiController extends ActiveController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['options'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => $this->accessRules(),
            'denyCallback' => function () {
                throw new ForbiddenHttpException('You are not allowed to perform this action.');
            }
        ];

        return $behaviors;
    }

    protected function accessRules(): array
    {
        return [
            [
                'allow' => true,
                'actions' => ['options'],
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'actions' => ['index', 'view', 'create', 'update'],
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'actions' => ['delete'],
                'roles' => ['admin'],
            ],
        ];
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        $user = Yii::$app->user->identity;

        if ($action === 'update' || $action === 'view') {
            if ($model->user_id !== $user->id && !$user->isAdmin()) {
                throw new ForbiddenHttpException('You can only access your own records.');
            }
        }

        if ($action === 'delete' && !$user->isAdmin()) {
            throw new ForbiddenHttpException('Admin access required for deletion.');
        }
    }
}