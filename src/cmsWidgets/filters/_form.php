<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.05.2015
 */
/* @var $this yii\web\View */
/* @var $contentType \skeeks\cms\models\CmsContentType */
/* @var $model \skeeks\cms\shop\cmsWidgets\filters\ShopProductFiltersWidget */

?>
<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Showing')); ?>
<?php echo $form->field($model, 'viewFile')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Data source')); ?>
<?php echo $form->fieldSelect($model, 'content_id', \skeeks\cms\models\CmsContent::getDataForSelect()); ?>

<? /*= $form->fieldSelectMulti($model, 'searchModelAttributes', [
        'image' => \Yii::t('skeeks/cms', 'Filter by photo'),
        'hasQuantity' => \Yii::t('skeeks/cms', 'Filter by availability')
    ]); */ ?>

<? /*= $form->field($model, 'searchModelAttributes')->dropDownList([
        'image' => \Yii::t('skeeks/cms', 'Filter by photo'),
        'hasQuantity' => \Yii::t('skeeks/cms', 'Filter by availability')
    ], [
'multiple' => true,
'size' => 4
]); */ ?>

<? if ($model->cmsContent) : ?>
    <?php echo $form->fieldSelectMulti($model, 'realatedProperties',
        \yii\helpers\ArrayHelper::map($model->cmsContent->cmsContentProperties, 'code', 'name')); ?>
<? else: ?>
    Дополнительные свойства появятся после сохранения настроек
<? endif; ?>



<?php echo $form->fieldSetEnd(); ?>

