<?php
use yii\helpers\Html;

/**
 * @var app\models\logical\Request $model
 */
?>

<h2>Ваша заявка рассмотрена</h2>

<p>Здравствуйте, <?= Html::encode($model->username) ?>!</p>

<p>На вашу заявку был дан ответ:</p>

<blockquote>
    <?= nl2br(Html::encode($model->comment)) ?>
</blockquote>

<p>С уважением,<br>Команда поддержки</p>
