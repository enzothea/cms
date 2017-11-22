<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.05.2015
 */
/* @var $this yii\web\View */
?>
<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Template')); ?>
<?php echo $form->field($model, 'viewFile')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Filtration')); ?>
<?php echo $form->field($model, 'enabledCurrentSite')->listBox(\yii\helpers\ArrayHelper::merge([null => "-"],
    \Yii::$app->cms->booleanFormat()), ['size' => 1]); ?>
<?php echo $form->field($model, 'active')->listBox(\yii\helpers\ArrayHelper::merge([null => "-"],
    \Yii::$app->cms->booleanFormat()), ['size' => 1]); ?>

<?php echo $form->fieldSelectMulti($model, 'tree_type_ids', \yii\helpers\ArrayHelper::map(
    \skeeks\cms\models\CmsTreeType::find()->all(), 'id', 'name'
)); ?>

<?php echo $form->fieldInputInt($model, 'level'); ?>
<?php echo $form->fieldSelectMulti($model, 'site_codes', \yii\helpers\ArrayHelper::map(
    \skeeks\cms\models\CmsSite::find()->active()->all(),
    'code',
    'name'
)); ?>
<?php echo $form->field($model, 'treePid')->widget(
    \skeeks\cms\widgets\formInputs\selectTree\SelectTreeInputWidget::class
); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Sorting')); ?>
<?php echo $form->fieldSelect($model, 'orderBy', (new \skeeks\cms\models\Tree())->attributeLabels()); ?>
<?php echo $form->fieldSelect($model, 'order', [
    SORT_ASC => \Yii::t('skeeks/cms', 'ASC (from lowest to highest)'),
    SORT_DESC => \Yii::t('skeeks/cms', 'DESC (from highest to lowest)'),
]); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Additionally')); ?>
<?php echo $form->field($model, 'label')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Cache settings')); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledRunCache', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldInputInt($model, 'runCacheDuration'); ?>
<?php echo $form->fieldSetEnd(); ?>


