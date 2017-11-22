<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use skeeks\cms\models\Tree;

/* @var $this yii\web\View */
/* @var $model Tree */
?>


<?php $form = ActiveForm::begin(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', "Main")); ?>

<? if ($code = \Yii::$app->request->get('cms_site_id')) : ?>
    <?php echo $form->field($model, 'cms_site_id')->hiddenInput(['value' => $code])->label(false); ?>
<? else: ?>
    <?php echo $form->field($model, 'cms_site_id')->widget(
        \skeeks\widget\chosen\Chosen::className(), [
        'items' => \yii\helpers\ArrayHelper::map(
            \skeeks\cms\models\CmsSite::find()->all(),
            "id",
            "name"
        ),
    ]);
    ?>
<? endif; ?>

<?php echo $form->field($model, 'domain')->textInput(); ?>

<?php echo $form->fieldSetEnd(); ?>
<?php echo $form->buttonsStandart($model) ?>

<?php ActiveForm::end(); ?>