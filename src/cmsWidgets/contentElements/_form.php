<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.05.2015
 */
/* @var $this yii\web\View */
?>
<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Showing')); ?>
<?php echo $form->field($model, 'viewFile')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Pagination')); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledPaging', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledPjaxPagination', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldInputInt($model, 'pageSize'); ?>
<?php echo $form->fieldInputInt($model, 'pageSizeLimitMin'); ?>
<?php echo $form->fieldInputInt($model, 'pageSizeLimitMax'); ?>
<?php echo $form->field($model, 'pageParamName')->textInput(); ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Filtering')); ?>
<?php echo $form->fieldSelect($model, 'active', \Yii::$app->cms->booleanFormat(), [
    'allowDeselect' => true
]); ?>

<?php echo $form->fieldSelect($model, 'enabledActiveTime', \Yii::$app->cms->booleanFormat())->hint(\Yii::t('skeeks/cms',
    "Will be considered time of beginning and end of the publication")); ?>

<?php echo $form->fieldSelectMulti($model, 'createdBy', \yii\helpers\ArrayHelper::map(
    \skeeks\cms\models\User::find()->active()->all(),
    'id',
    'name'
)); ?>

<?php echo $form->fieldSelectMulti($model, 'content_ids', \skeeks\cms\models\CmsContent::getDataForSelect()); ?>

<?php echo $form->fieldRadioListBoolean($model, 'enabledCurrentTree', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledCurrentTreeChild', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledCurrentTreeChildAll', \Yii::$app->cms->booleanFormat()); ?>

<?php echo $form->field($model, 'tree_ids')->widget(
    \skeeks\cms\widgets\formInputs\selectTree\SelectTree::className(),
    [
        'mode' => \skeeks\cms\widgets\formInputs\selectTree\SelectTree::MOD_MULTI,
        'attributeMulti' => 'tree_ids'
    ]
); ?>

<?php echo $form->fieldRadioListBoolean($model, 'enabledSearchParams', \Yii::$app->cms->booleanFormat()); ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Sorting and quantity')); ?>
<?php echo $form->fieldInputInt($model, 'limit'); ?>
<?php echo $form->fieldSelect($model, 'orderBy', (new \skeeks\cms\models\CmsContentElement())->attributeLabels()); ?>
<?php echo $form->fieldSelect($model, 'order', [
    SORT_ASC => "ASC (" . \Yii::t('skeeks/cms', 'from smaller to larger') . ")",
    SORT_DESC => "DESC (" . \Yii::t('skeeks/cms', 'from highest to lowest') . ")",
]); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Additionally')); ?>
<?php echo $form->field($model, 'label')->textInput(); ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Cache settings')); ?>
<?php echo $form->fieldRadioListBoolean($model, 'enabledRunCache', \Yii::$app->cms->booleanFormat()); ?>
<?php echo $form->fieldInputInt($model, 'runCacheDuration'); ?>
<?php echo $form->fieldSetEnd(); ?>



