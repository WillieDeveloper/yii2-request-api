<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\rest\ActiveController;

class RequestController extends ActiveController
{
    public $modelClass = 'app\models\logical\Request';

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'options'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['create', 'update', 'delete'],
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
}