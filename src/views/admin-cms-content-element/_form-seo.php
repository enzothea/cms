<?php
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
/* @var $relatedModel \skeeks\cms\relatedProperties\models\RelatedPropertiesModel */
?>
<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'SEO')); ?>
<?php echo $form->field($model, 'meta_title')->textarea(); ?>
<?php echo $form->field($model, 'meta_description')->textarea(); ?>
<?php echo $form->field($model, 'meta_keywords')->textarea(); ?>
<?php echo $form->fieldSetEnd() ?>
