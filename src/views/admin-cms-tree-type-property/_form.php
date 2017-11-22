<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use skeeks\cms\models\Tree;
use skeeks\cms\modules\admin\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model Tree */
?>


<?php $form = ActiveForm::begin([
    'id' => 'sx-dynamic-form',
    'enableAjaxValidation' => false,
]); ?>

<? $this->registerJs(<<<JS

(function(sx, $, _)
{
    sx.classes.DynamicForm = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $("[data-form-reload=true]").on('change', function()
            {
                self.update();
            });
        },

        update: function()
        {
            _.delay(function()
            {
                var jForm = $("#sx-dynamic-form");
                jForm.append($('<input>', {'type': 'hidden', 'name' : 'sx-not-submit', 'value': 'true'}));
                jForm.submit();
            }, 200);
        }
    });

    sx.DynamicForm = new sx.classes.DynamicForm();
})(sx, sx.$, sx._);


JS
); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Basic settings')) ?>

<?php echo $form->fieldRadioListBoolean($model, 'active') ?>
<?php echo $form->fieldRadioListBoolean($model, 'is_required') ?>

<?php echo $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?php echo $form->field($model, 'code')->textInput() ?>


<?php echo $form->field($model, 'component')->listBox(array_merge(['' => ' — '],
    \Yii::$app->cms->relatedHandlersDataForSelect), [
    'size' => 1,
    'data-form-reload' => 'true'
])
    ->label(\Yii::t('skeeks/cms', "Property type"));
?>

<? if ($handler) : ?>
    <?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget(['content' => \Yii::t('skeeks/cms', 'Settings')]); ?>
    <? if ($handler instanceof \skeeks\cms\relatedProperties\propertyTypes\PropertyTypeList) : ?>
        <? $handler->enumRoute = 'cms/admin-cms-tree-type-property-enum'; ?>
    <? endif; ?>
    <?php echo $handler->renderConfigForm($form); ?>
<? endif; ?>


<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Additionally')) ?>
<?php echo $form->field($model, 'hint')->textInput() ?>
<?php echo $form->fieldInputInt($model, 'priority') ?>

<? if ($content_id = \Yii::$app->request->get('tree_type_id')) : ?>

    <div style="display: none;">
        <?php echo $form->field($model, 'cmsTreeTypes')->checkboxList(\yii\helpers\ArrayHelper::map(
            \skeeks\cms\models\CmsTreeType::find()->all(), 'id', 'name'
        ), ['value' => $content_id]); ?>
    </div>

    <? /*= $form->field($model, 'tree_type_id')->hiddenInput(['value' => $content_id])->label(false); */ ?>

<? else: ?>

    <?php echo $form->field($model, 'cmsTreeTypes')->widget(
        \skeeks\widget\chosen\Chosen::class,
        [
            'multiple' => true,
            'items' => \yii\helpers\ArrayHelper::map(
                \skeeks\cms\models\CmsTreeType::find()->all(), 'id', 'name'
            )
        ]
    ); ?>

<? endif; ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->buttonsStandart($model); ?>

<?php ActiveForm::end(); ?>




