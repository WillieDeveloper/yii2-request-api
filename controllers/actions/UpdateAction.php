<?php

namespace app\controllers\actions;

use app\models\logical\Request;
use app\services\EmailService;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\rest\UpdateAction as BaseUpdateAction;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UpdateAction extends BaseUpdateAction
{
    /**
     * @throws Exception
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function run($id)
    {
        /** @var Request $model */
        $model = $this->findModel($id);
        $oldStatus = $model->status;

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        if ($oldStatus !== Request::STATUS_RESOLVED
            && $model->status === Request::STATUS_RESOLVED) {
            EmailService::sendRequestResolved($model);
        }

        return $model;
    }
}