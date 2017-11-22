<?php

use skeeks\cms\mail\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink */
?>

<?php echo Html::beginTag('h1'); ?>
Тестирование отправки писем с сайта <?php echo \Yii::$app->cms->appName ?>
<?php echo Html::endTag('h1'); ?>

<?php echo Html::beginTag('p'); ?>
Здравствуйте!<br><br>Отправка произведена с сайта <?php echo Html::a(\Yii::$app->name, \yii\helpers\Url::home(true)) ?>.<br>
Это письмо можно просто удалить.
<?php echo Html::endTag('p'); ?>
