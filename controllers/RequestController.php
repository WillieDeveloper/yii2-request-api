<?php

namespace app\controllers;

use app\filters\RequestFieldsFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

class RequestController extends ActiveController
{
    public $modelClass = 'app\models\logical\Request';

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'options'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['index']['prepareSearchQuery'] = function ($query, $requestParams) {
            return RequestFieldsFilter::filter($query, $requestParams, $this->modelClass);
        };
        return $actions;
    }
}