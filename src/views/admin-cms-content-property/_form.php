<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use skeeks\cms\models\Tree;
use skeeks\cms\modules\admin\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model Tree */
/* @var $handler \skeeks\cms\relatedProperties\PropertyType */

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

<?php echo $form->field($model, 'active')->radioList(\Yii::$app->cms->booleanFormat()) ?>
<?php echo $form->field($model, 'is_required')->radioList(\Yii::$app->cms->booleanFormat()) ?>


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
    <?php echo $handler->renderConfigForm($form); ?>
<? endif; ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Additionally')) ?>
<?php echo $form->field($model, 'hint')->textInput() ?>
<?php echo $form->fieldInputInt($model, 'priority') ?>
<? if ($content_id = \Yii::$app->request->get('content_id')) : ?>


    <div style="display: none;">
        <?php echo $form->field($model, 'cmsContents')->checkboxList(\yii\helpers\ArrayHelper::map(
            \skeeks\cms\models\CmsContent::find()->all(), 'id', 'name'
        ), ['value' => $content_id]); ?>
    </div>

    <? /*= $form->field($model, 'content_id')->hiddenInput(['value' => $content_id])->label(false); */ ?>

<? else: ?>
    <? /*= $form->field($model, 'content_id')->label(\Yii::t('skeeks/cms','Content'))->widget(
        \skeeks\cms\widgets\formInputs\EditedSelect::className(), [
            'items' => \yii\helpers\ArrayHelper::map(
                 \skeeks\cms\models\CmsContent::find()->all(),
                 "id",
                 "name"
             ),
            'controllerRoute' => 'cms/admin-cms-content',
        ]);
    */ ?>
    <?php echo $form->field($model, 'cmsContents')->widget(
        \skeeks\widget\chosen\Chosen::class,
        [
            'multiple' => true,
            'items' => \skeeks\cms\models\CmsContent::getDataForSelect()
        ]
    ); ?>


<? endif; ?>

<? if ($tree_id = \Yii::$app->request->get('tree_id')) : ?>

    <div style="display: none;">
        <?php echo $form->field($model, 'cmsTrees')->checkboxList(
            \yii\helpers\ArrayHelper::map(
                \skeeks\cms\models\CmsTree::find()->where(['id' => $tree_id])->all(),
                'id',
                'name'
            ),
            [
                'value' => [$tree_id]
            ]
        ); ?>
    </div>
<? else : ?>
    <?php echo $form->field($model, 'cmsTrees')->widget(
        \skeeks\cms\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
        [
            'multiple' => true,
        ]
    ); ?>
<? endif; ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->buttonsStandart($model); ?>

<?php ActiveForm::end(); ?>




