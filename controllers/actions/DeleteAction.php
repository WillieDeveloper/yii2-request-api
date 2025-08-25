<?php

namespace app\controllers\actions;

use app\models\logical\Request;
use app\services\EmailService;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class DeleteAction extends \yii\rest\DeleteAction
{
    /**
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function run($id)
    {
        /** @var Request $model */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        EmailService::sendRequestDeleted($model);

        Yii::$app->getResponse()->setStatusCode(204);
    }
}