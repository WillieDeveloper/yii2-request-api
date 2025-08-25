<?php

namespace app\services;

use app\models\logical\Request;
use Yii;

class EmailService
{
    public static function sendRequestResolved(Request $request): bool
    {
        return Yii::$app->mailer->compose('request-resolved', ['model' => $request])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($request->email)
            ->setSubject('Ваша заявка рассмотрена')
            ->send();
    }

    public static function sendRequestDeleted(Request $request): bool
    {
        return Yii::$app->mailer->compose('request-deleted', ['model' => $request])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($request->email)
            ->setSubject('Ваша заявка удалена')
            ->send();
    }
}