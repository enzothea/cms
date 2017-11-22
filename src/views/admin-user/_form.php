<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsUser */
/* @var $console \skeeks\cms\controllers\AdminUserController */

/* @var $this yii\web\View */
/* @var $controller \skeeks\cms\backend\controllers\BackendModelController */
/* @var $action \skeeks\cms\backend\actions\BackendModelCreateAction|\skeeks\cms\backend\actions\IHasActiveForm */
/* @var $model \skeeks\cms\models\CmsLang */
$controller = $this->context;
$action = $controller->action;

?>



<?php $form = $action->beginActiveForm(); ?>
<?php echo $form->errorSummary([$model, $relatedModel]); ?>


<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'General information')) ?>


<?php echo $form->fieldRadioListBoolean($model, 'active'); ?>

<?php echo $form->field($model, 'gender')->radioList([
    'men' => \Yii::t('skeeks/cms', 'Male'),
    'women' => \Yii::t('skeeks/cms', 'Female'),
]); ?>

<?php echo $form->field($model, 'image_id')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => false
    ]
); ?>

<?php echo $form->field($model, 'username')->textInput(['maxlength' => 25])->hint(\Yii::t('skeeks/cms',
    'The unique username. Used for authorization and to form links to personal cabinet.')); ?>

<?php echo $form->field($model, 'first_name')->textInput(); ?>
<?php echo $form->field($model, 'last_name')->textInput(); ?>
<?php echo $form->field($model, 'patronymic')->textInput(); ?>

<div class="row">
    <div class="col-md-5">
        <?php echo $form->field($model, 'email')->textInput(); ?>
        <? if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_USER_FULL_EDIT)) : ?>
            <?php echo $form->field($model, 'email_is_approved')->checkbox(\Yii::$app->formatter->booleanFormat); ?>
        <? endif; ?>
    </div>
    <div class="col-md-5">
        <?
        \skeeks\cms\admin\assets\JqueryMaskInputAsset::register($this);
        $id = \yii\helpers\Html::getInputId($model, 'phone');
        $this->registerJs(<<<JS
$("#{$id}").mask("+7 999 999-99-99");
JS
        );
        ?>

        <?php echo $form->field($model, 'phone')->textInput([
            'placeholder' => '+7 903 722-28-73'
        ]); ?>
        <? if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_USER_FULL_EDIT)) : ?>
            <?php echo $form->field($model, 'phone_is_approved')->checkbox(\Yii::$app->formatter->booleanFormat); ?>
        <? endif; ?>
    </div>
</div>


<? if ($model->relatedProperties) : ?>
    <?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('skeeks/cms', 'Additional properties')
    ]); ?>
    <? if ($properties = $model->relatedProperties) : ?>
        <? foreach ($properties as $property) : ?>
            <?php echo $property->renderActiveForm($form, $model) ?>
        <? endforeach; ?>
    <? endif; ?>

<? else : ?>
    <? /*= \Yii::t('skeeks/cms','Additional properties are not set')*/ ?>
<? endif; ?>


<?php echo $form->fieldSetEnd(); ?>

<? if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_USER_FULL_EDIT)) : ?>
    <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Groups')) ?>

    <? $this->registerCss(<<<CSS
    .sx-checkbox label
    {
        width: 100%;
    }
CSS
    ) ?>
    <?php echo $form->field($model, 'roleNames')->checkboxList(
        \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description'), [
            'class' => 'sx-checkbox'
        ]
    ); ?>

    <?php echo $form->fieldSetEnd(); ?>
<? endif; ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Password')); ?>

<?php echo $form->field($passwordChange, 'new_password')->passwordInput() ?>
<?php echo $form->field($passwordChange, 'new_password_confirm')->passwordInput() ?>

<?php echo $form->fieldSetEnd(); ?>

<? /*= $form->fieldSet(\Yii::t('skeeks/cms','Additionally'))*/ ?><!--
    <? /*= $form->field($model, 'city')->textInput(); */ ?>
    <? /*= $form->field($model, 'address')->textInput(); */ ?>
    <? /*= $form->field($model, 'info')->textarea(); */ ?>
    <? /*= $form->field($model, 'status_of_life')->textarea(); */ ?>
--><? /*= $form->fieldSetEnd(); */ ?>

<? if (!$model->isNewRecord && class_exists('\skeeks\cms\authclient\models\UserAuthClient')) : ?>
    <?php echo $form->fieldSet(\Yii::t('skeeks/authclient', 'Social profiles')) ?>
    <?php echo \skeeks\cms\modules\admin\widgets\RelatedModelsGrid::widget([
        'label' => \Yii::t('skeeks/authclient', "Social profiles"),
        'hint' => "",
        'parentModel' => $model,
        'relation' => [
            'user_id' => 'id'
        ],
        'controllerRoute' => 'authclient/admin-user-auth-client',
        'gridViewOptions' => [
            'columns' => [
                'displayName'
            ],
        ],
    ]); ?>
    <?php echo $form->fieldSetEnd(); ?>
<? endif; ?>

<?php echo $form->buttonsStandart($model); ?>
<?php echo $form->errorSummary([$model, $relatedModel]); ?>
<?php \skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab::end(); ?>
