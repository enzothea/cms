<?php

use yii\helpers\Html;
use \skeeks\cms\modules\admin\widgets\ActiveForm;

/* @var $this yii\web\View */
?>
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($model, 'new_password')->passwordInput() ?>
<?php echo $form->field($model, 'new_password_confirm')->passwordInput() ?>
<?php echo $form->buttonsCreateOrUpdate($model) ?>
<?php ActiveForm::end(); ?>

