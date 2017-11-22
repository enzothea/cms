<?php
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
/* @var $relatedModel \skeeks\cms\relatedProperties\models\RelatedPropertiesModel */
?>
<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Announcement')); ?>
<?php echo $form->field($model, 'image_id')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => false
    ]
); ?>
<?php echo $form->field($model, 'description_short')->widget(
    \skeeks\cms\widgets\formInputs\comboText\ComboTextInputWidget::className(),
    [
        'modelAttributeSaveType' => 'description_short_type',
    ]);
?>
<?php echo $form->fieldSetEnd() ?>
