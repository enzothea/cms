<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
?>
<?php $form = ActiveForm::begin(); ?>

<? if ($form_id = \Yii::$app->request->get('property_id')) : ?>
    <?php echo $form->field($model, 'property_id')->hiddenInput(['value' => $form_id])->label(false); ?>
<? else: ?>
    <?php echo $form->field($model, 'property_id')->widget(
        \skeeks\widget\chosen\Chosen::className(), [
        'items' => \yii\helpers\ArrayHelper::map(
            \skeeks\cms\models\CmsTreeTypeProperty::find()->all(),
            "id",
            "name"
        ),
    ]);
    ?>
<? endif; ?>

<?php echo $form->field($model, 'value')->textInput(['maxlength' => 255]) ?>
<?php echo $form->field($model, 'code')->textInput(['maxlength' => 32]) ?>

<?php echo $form->buttonsCreateOrUpdate($model); ?>

<?php ActiveForm::end(); ?>
