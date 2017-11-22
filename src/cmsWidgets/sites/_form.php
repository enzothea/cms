<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.05.2015
 */
/* @var $this yii\web\View */
?>
<?php echo $form->fieldSet('Отображение'); ?>
<?php echo $form->field($model, 'viewFile')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Фильтрация'); ?>
<?php echo $form->fieldSelect($model, 'active', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Сортировка'); ?>
<?php echo $form->fieldSelect($model, 'orderBy', (new \skeeks\cms\models\CmsSite())->attributeLabels()); ?>
<?php echo $form->fieldSelect($model, 'order', [
    SORT_ASC => "ASC (от меньшего к большему)",
    SORT_DESC => "DESC (от большего к меньшему)",
]); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Дополнительно'); ?>
<?php echo $form->field($model, 'label')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Настройки кэширования'); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledRunCache', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldInputInt($model, 'runCacheDuration'); ?>
<?php echo $form->fieldSetEnd(); ?>


