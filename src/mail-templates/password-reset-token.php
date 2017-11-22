<?php

use skeeks\cms\mail\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $resetLink */
if (!$resetLink) {
    $resetLink = \skeeks\cms\helpers\UrlHelper::construct('admin/auth/reset-password',
        ['token' => $user->password_reset_token])->enableAbsolute()->enableAdmin();
}
?>

<?php echo Html::beginTag('h1'); ?>
Напоминание пароля на <?php echo \Yii::$app->cms->appName ?>
<?php echo Html::endTag('h1'); ?>

<?php echo Html::beginTag('p'); ?>
Здравствуйте!<br><br>Был получен запрос на смену пароля на сайте <?php echo Html::a(\Yii::$app->name,
    \yii\helpers\Url::home(true)) ?>.<br>
<?php echo Html::a("Проследуйте по ссылке", $resetLink) ?> и мы вам пришлем новый пароль.
<br>Если вы не запрашивали смену пароля, просто проигнорируйте это письмо.
<?php echo Html::endTag('p'); ?>
