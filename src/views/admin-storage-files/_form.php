<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use skeeks\cms\models\Tree;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\StorageFile */

?>

<? $this->registerCss(<<<CSS
    .sx-image-controll .sx-image img
    {
        max-height: 200px;
        border: 2px solid silver;
    }
CSS
); ?>

<div class="sx-image-controll">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Main')); ?>
    <? if ($model->isImage()) : ?>
        <div class="sx-image">
            <img src="<?php echo $model->src; ?>"/>
        </div>
    <? endif; ?>
    <div class="">

    </div>
    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 255])->hint(\Yii::t('skeeks/cms',
        'This name is usually needed for SEO, so that the file was found in the search engines')) ?>
    <?php echo $form->field($model, 'name_to_save')->textInput(['maxlength' => 255])->hint(\Yii::t('skeeks/cms',
        'Filename, when someone will be download it.')) ?>

    <?php echo $form->fieldSetEnd(); ?>




    <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Description')); ?>

    <?php echo $form->field($model, 'description_full')->widget(
        \skeeks\cms\widgets\formInputs\ckeditor\Ckeditor::className(),
        [
            'options' => ['rows' => 20],
            'preset' => 'full',
            'relatedModel' => $model,
        ])
    ?>

    <?php echo $form->field($model, 'description_short')->widget(
        \skeeks\cms\widgets\formInputs\ckeditor\Ckeditor::className(),
        [
            'options' => ['rows' => 6],
            'preset' => 'full',
            'relatedModel' => $model,
        ])
    ?>

    <?php echo $form->fieldSetEnd() ?>



    <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Additional Information')); ?>

    <?php echo $form->field($model, 'original_name')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled'
    ])->hint(\Yii::t('skeeks/cms', 'Filename at upload time to the site')) ?>


    <div class="form-group field-storagefile-mime_type">
        <label>Размер файла</label>
        <?php echo Html::textInput("file-size", \Yii::$app->formatter->asShortSize($model->size), [
            'disabled' => 'disabled',
            'class' => 'form-control',
        ]) ?>
    </div>
    <? /*= $form->field($model, 'size')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled',
        'value' => \Yii::$app->formatter->asShortSize($model->size)
    ]); */ ?>

    <?php echo $form->field($model, 'mime_type')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled'
    ])->hint('Internet Media Types — ' . \Yii::t('skeeks/cms',
            'types of data which can be transmitted via the Internet using standard MIME.')); ?>

    <?php echo $form->field($model, 'extension')->textInput([
        'maxlength' => 255,
        'disabled' => 'disabled'
    ]); ?>

    <? if ($model->isImage()) : ?>
        <? if (!$model->image_height || !$model->image_width) : ?>
            <? $model->updateFileInfo(); ?>
        <? endif; ?>
        <div class="col-md-12">
            <div class="col-md-2">
                <?php echo $form->field($model, 'image_width')->textInput([
                    'maxlength' => 255,
                    'disabled' => 'disabled'
                ]); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->field($model, 'image_height')->textInput([
                    'maxlength' => 255,
                    'disabled' => 'disabled'
                ]); ?>
            </div>
        </div>
    <? endif; ?>



    <?php echo $form->fieldSetEnd(); ?>


    <? if ($model->isImage()) : ?>
        <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Thumbnails')); ?>
        <p><?php echo \Yii::t('skeeks/cms',
                'This is an image in different places of the site displayed in different sizes.') ?></p>

        <?php echo $form->fieldSetEnd(); ?>

        <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Image editor')); ?>

        <?php echo $form->fieldSetEnd(); ?>
    <? endif; ?>

    <?php echo $form->buttonsCreateOrUpdate($model); ?>
    <?php ActiveForm::end(); ?>
</div>