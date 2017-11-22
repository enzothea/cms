<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 21.03.2017
 */
/* @var $this yii\web\View */
/* @var $controller \skeeks\cms\backend\controllers\BackendModelController */
/* @var $action \skeeks\cms\backend\actions\BackendModelCreateAction|\skeeks\cms\backend\actions\IHasActiveForm */
/* @var $model \skeeks\cms\models\CmsLang */
$controller = $this->context;
$action = $controller->action;
?>


<?php $form = $action->beginActiveForm(); ?>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', "Main")); ?>

<?php echo $form->field($model, 'image_id')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => false
    ]
); ?>

<?php echo $form->field($model, 'name'); ?>
<?php echo $form->field($model, 'code')->textInput(); ?>


<? if ($model->def === \skeeks\cms\components\Cms::BOOL_Y): ?>
    <?php echo $form->field($model, 'active')->hiddenInput()->hint(\Yii::t('skeeks/cms',
        'Site selected by default always active')); ?>
    <?php echo $form->field($model, 'def')->hiddenInput()->hint(\Yii::t('skeeks/cms',
        'This site is the site selected by default. If you want to change it, you need to choose a different site, the default site.')); ?>
<? else : ?>
    <?php echo $form->fieldRadioListBoolean($model, 'active'); ?>
    <?php echo $form->fieldRadioListBoolean($model, 'def'); ?>
<? endif; ?>




<?php echo $form->field($model, 'description')->textarea(); ?>
<?php echo $form->field($model, 'server_name')->textInput(['maxlength' => 255]) ?>
<?php echo $form->fieldInputInt($model, 'priority'); ?>

<?php echo $form->fieldSetEnd(); ?>

<? if (!$model->isNewRecord) : ?>
    <?php echo $form->fieldSet(\Yii::t('skeeks/cms', "Domains")); ?>

    <?php echo \skeeks\cms\modules\admin\widgets\RelatedModelsGrid::widget([
        'label' => "",
        'hint' => "",
        'parentModel' => $model,
        'relation' => [
            'cms_site_id' => 'id'
        ],

        'controllerRoute' => '/cms/admin-cms-site-domain',
        'gridViewOptions' => [
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                'domain',
            ],
        ],
    ]); ?>

    <?php echo $form->fieldSetEnd(); ?>
<? endif; ?>
<?php echo $form->buttonsStandart($model) ?>

<?php echo $form->errorSummary($model); ?>
<?php $action->endActiveForm(); ?>