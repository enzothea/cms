<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 14.10.2015
 */
/* @var $this yii\web\View */
/* @var $action \skeeks\cms\modules\admin\actions\modelEditor\AdminMultiDialogModelEditAction */
/* @var $content \skeeks\cms\models\CmsContent */

$model = new \skeeks\cms\models\CmsContentElement();

$jsData = \yii\helpers\Json::encode([
    'id' => $action->id
]);

$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.MultiRP = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;
            this.jWrapper = $("#" + this.get('id'));
            this.jForm = $('form', this.jWrapper);
            this.jSelect = $('.sx-select', this.jWrapper);

            this.jSelect.on('change', function()
            {
                $(".sx-multi", self.jForm).slideUp();

                if (self.jSelect.val())
                {
                    self.jForm.show();
                } else
                {
                    self.jForm.hide();
                }

                _.each(self.jSelect.val(), function(element)
                {
                    $(".sx-multi-" + element, self.jForm).slideDown();

                });
            });
        }
    });

    new sx.classes.MultiRP({$jsData});
})(sx, sx.$, sx._);
JS
);
?>
<div id="<?php echo $action->id; ?>">
    <? if ($action->controller && $action->controller->content) : ?>

        <? $content = $action->controller->content; ?>
        <? $element = $content->createElement(); ?>
        <? $element->loadDefaultValues(); ?>

        <? if ($element && $element->relatedPropertiesModel) : ?>

            <? $form = \skeeks\cms\modules\admin\widgets\ActiveForm::begin([
                'options' => [
                    'class' => 'sx-form',
                ]
            ]); ?>
            <?php echo \skeeks\widget\chosen\Chosen::widget([
                'multiple' => true,
                'name' => 'fields',
                'options' => [
                    'class' => 'sx-select'
                ],
                'items' => $element->relatedPropertiesModel->attributeLabels()
            ]); ?>

            <?php echo \yii\helpers\Html::hiddenInput('content_id', $content->id); ?>

            <? foreach ($element->relatedPropertiesModel->properties as $property) : ?>
                <div class="sx-multi sx-multi-<?php echo $property->code; ?>" style="display: none;">
                    <? if ($property->property_type == \skeeks\cms\relatedProperties\PropertyType::CODE_ELEMENT) : ?>

                        <? if ($property->handler->fieldElement == \skeeks\cms\relatedProperties\propertyTypes\PropertyTypeElement::FIELD_ELEMENT_SELECT) : ?>
                            <?
                            echo $form->field($element->relatedPropertiesModel, $property->code)->widget(
                                \skeeks\cms\backend\widgets\SelectModelDialogContentElementWidget::class,
                                [
                                    'content_id' => $property->handler->content_id
                                ]
                            );
                            ?>
                        <? else : ?>
                            <?
                            echo $form->field($element->relatedPropertiesModel, $property->code)->widget(
                                \skeeks\cms\backend\widgets\SelectModelDialogContentElementWidget::class,
                                [
                                    'content_id' => $property->handler->content_id,
                                    'multiple' => true
                                ]
                            );
                            ?>
                        <? endif; ?>
                    <? else : ?>
                        <?php echo $property->renderActiveForm($form); ?>
                    <? endif; ?>
                </div>
            <? endforeach; ?>
            <?php echo $form->buttonsStandart($model, ['save']); ?>
            <? $form::end(); ?>
        <? else : ?>
            Not found properties
        <? endif; ?>
    <? endif; ?>
</div>



