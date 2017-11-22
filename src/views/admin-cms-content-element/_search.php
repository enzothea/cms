<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 26.05.2016
 */
?>
<? $form = \skeeks\cms\modules\admin\widgets\filters\AdminFiltersForm::begin([
    //'action' => '/' . \Yii::$app->request->pathInfo,
    'namespace' => \Yii::$app->controller->uniqueId . "_" . $content_id
]); ?>

<?php echo \yii\helpers\Html::hiddenInput('content_id', $content_id) ?>

<?php echo $form->field($searchModel, 'id'); ?>

<?php echo $form->field($searchModel, 'q')->textInput([
    'placeholder' => \Yii::t('skeeks/cms', 'Search name and description')
])->setVisible(); ?>

<?php echo $form->field($searchModel, 'name')->textInput([
    'placeholder' => \Yii::t('skeeks/cms', 'Search by name')
]) ?>

<?php echo $form->field($searchModel, 'active')->listBox(\yii\helpers\ArrayHelper::merge([
    '' => ' - '
], \Yii::$app->cms->booleanFormat()), [
    'size' => 1
]); ?>

<?php echo $form->field($searchModel, 'section')->widget(
    \skeeks\cms\backend\widgets\SelectModelDialogTreeWidget::class
); ?>

<? /*= $form->field($searchModel, 'section')->widget(
        \skeeks\cms\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
        [
            'multiple' => false,
        ]
    ); */ ?>


<?php echo $form->field($searchModel, 'has_image')->checkbox(\Yii::$app->formatter->booleanFormat, false); ?>
<?php echo $form->field($searchModel, 'has_full_image')->checkbox(\Yii::$app->formatter->booleanFormat, false); ?>


<?php echo $form->field($searchModel, 'created_by')->widget(
    \skeeks\cms\backend\widgets\SelectModelDialogUserWidget::class
); ?>
<?php echo $form->field($searchModel, 'updated_by')->widget(
    \skeeks\cms\backend\widgets\SelectModelDialogUserWidget::class
); ?>


<?php echo $form->field($searchModel, 'created_at_from')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>
<?php echo $form->field($searchModel, 'created_at_to')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>

<?php echo $form->field($searchModel, 'updated_at_from')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>
<?php echo $form->field($searchModel, 'updated_at_to')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>

<?php echo $form->field($searchModel, 'published_at_from')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>
<?php echo $form->field($searchModel, 'published_at_to')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>

<?php echo $form->field($searchModel, 'code'); ?>


<?
$searchRelatedPropertiesModel = new \skeeks\cms\models\searchs\SearchRelatedPropertiesModel();
$searchRelatedPropertiesModel->initProperties($cmsContent->cmsContentProperties);
$searchRelatedPropertiesModel->load(\Yii::$app->request->get());
?>
<?php echo $form->relatedFields($searchRelatedPropertiesModel); ?>

<? $form::end(); ?>
