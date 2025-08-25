<?php
use yii\helpers\Html;

/**
 * @var app\models\logical\Request $model
 */
?>

<h2>Ваша заявка удалена</h2>

<p>Здравствуйте, <?= Html::encode($model->username) ?>!</p>

<p>Ваша заявка от <?= Yii::$app->formatter->asDate($model->created_at) ?> была удалена администратором.</p>

<p>Если это произошло по ошибке, пожалуйста, создайте новую заявку.</p>

<p>С уважением,<br>Команда поддержки</p>
