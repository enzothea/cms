<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $console \skeeks\cms\controllers\AdminUserController */
?>


<?php $form = ActiveForm::begin(); ?>
<?php ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'General information')) ?>
<?php echo $form->field($model, 'name')->textInput(); ?>
<?php echo $form->field($model, 'code')->textInput(); ?>
<?php echo $form->fieldInputInt($model, 'priority')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>


<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Content')) ?>
<?php echo \skeeks\cms\modules\admin\widgets\RelatedModelsGrid::widget([
    'label' => \Yii::t('skeeks/cms', "Content"),
    'hint' => "",
    'parentModel' => $model,
    'relation' => [
        'content_type' => 'code'
    ],
    'controllerRoute' => '/cms/admin-cms-content',
    'gridViewOptions' => [
        'sortable' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'name',
            'code',
            [
                'class' => \skeeks\cms\grid\BooleanColumn::className(),
                'falseValue' => \skeeks\cms\components\Cms::BOOL_N,
                'trueValue' => \skeeks\cms\components\Cms::BOOL_Y,
                'attribute' => 'active'
            ],
        ],
    ],
]); ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>