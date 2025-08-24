<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        return $behaviors;
    }

    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findOne(['username' => $username]);

        if (!$user || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Invalid credentials');
        }

        return [
            'token' => $user->generateJwt(),
            'role' => $user->role,
        ];
    }

    public function actionRegister()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(), '');
        $user->password_hash = Yii::$app->security->generatePasswordHash(
            Yii::$app->request->post('password')
        );
        $user->role = User::ROLE_USER;

        if ($user->save()) {
            return [
                'token' => $user->generateJwt(),
                'role' => $user->role,
            ];
        }

        return $user->errors;
    }
}