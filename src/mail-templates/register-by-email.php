<?php

use skeeks\cms\mail\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink */
?>

<?php echo Html::beginTag('h1'); ?>
    Регистрация на сайте <?php echo \Yii::$app->cms->appName ?>
<?php echo Html::endTag('h1'); ?>

<?php echo Html::beginTag('p'); ?>
    Здравствуйте!<br><br>Вы успешно зарегистрированны на сайте <?php echo Html::a(\Yii::$app->name,
    \yii\helpers\Url::home(true)) ?>.<br>
<?php echo Html::endTag('p'); ?>

<?php echo Html::beginTag('p'); ?>
    Для авторизации на сайте используйте следующие данные:
    <br>
    <b>Email: </b><?php echo $user->email; ?><br>
    <b>Пароль: </b><?php echo $password; ?><br>
<?php echo Html::a("Ссылка на авторизацию", \skeeks\cms\helpers\UrlHelper::construct('cms/auth/login')
    ->setRef(
        \skeeks\cms\helpers\UrlHelper::construct('/cms/profile')->enableAbsolute()->toString()
    )
    ->enableAbsolute()
    ->toString()
) ?>
<?php echo Html::endTag('p'); ?>