<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 */

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\WidgetConfig */

?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Main')); ?>

<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => \Yii::t('skeeks/cms', 'Main')
]) ?>
<?php echo $form->field($model, 'appName')->textInput()->hint(''); ?>

<?php echo $form->field($model,
    'adminEmail')->textInput()->hint('E-Mail администратора сайта. Этот email будет отображаться как отправитель, в отправленных письмах с сайта.'); ?>

<?php echo $form->field($model, 'noImageUrl')->widget(
    \skeeks\cms\modules\admin\widgets\formInputs\OneImage::className()
)->hint('Это изображение показывается в тех случаях, когда не найдено основное.'); ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Языковые настройки'); ?>
<?php echo $form->fieldSelect($model, 'languageCode', \yii\helpers\ArrayHelper::map(
    \skeeks\cms\models\CmsLang::find()->active()->all(),
    'code',
    'name'
)); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Авторизация'); ?>
<?php echo $form->fieldSelectMulti($model, 'registerRoles',
    \yii\helpers\ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description')
)->hint('Так же после созданию пользователя, ему будут назначены, выбранные группы.'); ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Разделы'); ?>
<?php echo $form->field($model, 'tree_max_code_length'); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Элементы'); ?>
<?php echo $form->field($model, 'element_max_code_length'); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet('Доступ'); ?>

<? \yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-warning',
    ],
]); ?>
<b>Внимание!</b> Права доступа сохраняются в режиме реального времени. Так же эти настройки не зависят от сайта или пользователя.
<? \yii\bootstrap\Alert::end() ?>

<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => "Файлы"
]) ?>

<?php echo \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
    'permissionName' => \skeeks\cms\rbac\CmsManager::PERMISSION_ELFINDER_USER_FILES,
    'label' => 'Доступ к личным файлам',
]); ?>

<?php echo \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
    'permissionName' => \skeeks\cms\rbac\CmsManager::PERMISSION_ELFINDER_COMMON_PUBLIC_FILES,
    'label' => 'Доступ к общим файлам',
]); ?>


<?php echo \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
    'permissionName' => \skeeks\cms\rbac\CmsManager::PERMISSION_ELFINDER_ADDITIONAL_FILES,
    'label' => 'Доступ ко всем файлам',
]); ?>


<?php echo $form->fieldSetEnd(); ?>



