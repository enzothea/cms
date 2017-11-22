<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (�����)
 * @date 26.05.2016
 */

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<? $form = \skeeks\cms\modules\admin\widgets\filters\AdminFiltersForm::begin([
    'action' => '/' . \Yii::$app->request->pathInfo,
]); ?>

<?php echo $form->field($searchModel, 'q')->setVisible(); ?>

<?php echo $form->field($searchModel, 'id'); ?>
<?php echo $form->field($searchModel, 'role')->listBox(\yii\helpers\ArrayHelper::merge([
    '' => ' - '
], \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description')), [
    'size' => 1
]); ?>

<?php echo $form->field($searchModel, 'active')->listBox(\yii\helpers\ArrayHelper::merge([
    '' => ' - '
], \Yii::$app->cms->booleanFormat()), [
    'size' => 1
]); ?>

<?php echo $form->field($searchModel, 'has_image')->checkbox(\Yii::$app->formatter->booleanFormat, false); ?>

<?php echo $form->field($searchModel, 'email_is_approved')->listBox(\yii\helpers\ArrayHelper::merge([
    '' => ' - '
], \Yii::$app->formatter->booleanFormat), [
    'size' => 1
]); ?>

<?php echo $form->field($searchModel, 'phone_is_approved')->listBox(\yii\helpers\ArrayHelper::merge([
    '' => ' - '
], \Yii::$app->formatter->booleanFormat), [
    'size' => 1
]); ?>

<?php echo $form->field($searchModel, 'name') ?>
<?php echo $form->field($searchModel, 'username') ?>
<?php echo $form->field($searchModel, 'email') ?>
<?php echo $form->field($searchModel, 'phone') ?>

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

<?php echo $form->field($searchModel, 'auth_at_from')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>
<?php echo $form->field($searchModel, 'auth_at_to')->widget(
    \kartik\datetime\DateTimePicker::className()
); ?>


<?
/**
 * @var $searchModel \skeeks\cms\models\CmsUser
 */
$searchRelatedPropertiesModel = new \skeeks\cms\models\searchs\SearchRelatedPropertiesModel();
$searchRelatedPropertiesModel->propertyElementClassName = \skeeks\cms\models\CmsUserProperty::className();
$searchRelatedPropertiesModel->initProperties($searchModel->relatedProperties);
$searchRelatedPropertiesModel->load(\Yii::$app->request->get());
$searchRelatedPropertiesModel->search($dataProvider, $searchModel::tableName());
?>
<?php echo $form->relatedFields($searchRelatedPropertiesModel); ?>

<? $form::end(); ?>
