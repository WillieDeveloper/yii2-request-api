<?php

namespace app\controllers;

use app\controllers\actions\DeleteAction;
use app\controllers\actions\UpdateAction;
use app\filters\RequestFieldsFilter;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;

class RequestController extends ActiveController
{
    public $modelClass = 'app\models\logical\Request';

    public function behaviors(): array
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['create', 'options'],
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['index', 'view', 'update', 'delete'],
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 86400,
                ],
            ],
            'rateLimiter' => [
                'class' => RateLimiter::class,
                'only' => ['create', 'update', 'delete'],
                'errorMessage' => 'Слишком много запросов. Попробуйте позже.'
            ],
//            'authenticator' => [
//                'class' => HttpBearerAuth::class,
//                'except' => ['create', 'options'],
//            ],
        ];
    }

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['index']['prepareSearchQuery'] = function ($query, $requestParams) {
            return RequestFieldsFilter::filter($query, $requestParams, $this->modelClass);
        };
        $actions['update'] = [
            'class' => UpdateAction::class,
            'modelClass' => $this->modelClass,
        ];
        $actions['delete'] = [
            'class' => DeleteAction::class,
            'modelClass' => $this->modelClass,
        ];
        return $actions;
    }
}