<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
?>
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($model, 'value')->textInput(['maxlength' => 255]) ?>

<? if (\Yii::$app->request->get('user_id')) : ?>
    <?php echo $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->request->get('user_id')])->label(false) ?>
<? else: ?>
    <?php echo $form->fieldSelect($model, 'user_id', \yii\helpers\ArrayHelper::map(
        \skeeks\cms\models\User::find()->active()->all(),
        'id',
        'displayName'
    ), [
        'allowDeselect' => true
    ]) ?>
<? endif; ?>


<?php echo $form->fieldRadioListBoolean($model, 'approved'); ?>
<?php echo $form->fieldRadioListBoolean($model, 'def'); ?>

<?php echo $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>
