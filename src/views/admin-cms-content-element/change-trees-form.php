<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 14.10.2015
 */
$model = new \skeeks\cms\models\CmsContentElement();
?>
<? $form = \skeeks\cms\modules\admin\widgets\ActiveForm::begin(); ?>

<? /*= $form->field($model, 'treeIds')->widget(
        \skeeks\cms\widgets\formInputs\selectTree\SelectTreeInputWidget::class,
        [
            'multiple' => true
        ]
    ); */ ?>

<?php echo $form->field($model, 'treeIds')->widget(
    \skeeks\cms\backend\widgets\SelectModelDialogTreeWidget::class,
    [
        'multiple' => true
    ]
); ?>


<?php echo \yii\helpers\Html::checkbox('removeCurrent', false); ?> <label><?php echo \Yii::t('skeeks/cms',
        'Get rid of the already linked (in this case, the selected records bind only to the selected section)') ?></label>
<?php echo $form->buttonsStandart($model, ['save']); ?>

<? \skeeks\cms\modules\admin\widgets\ActiveForm::end(); ?>


<? \yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-info',
        'style' => 'margin-top: 20px;',
    ],
]) ?>
    <p><?php echo \Yii::t('skeeks/cms', 'You can specify some additional sections that will show your records.') ?></p>
    <p><?php echo \Yii::t('skeeks/cms', 'This does not affect the final address of the page, and hence safe.') ?></p>
<? \yii\bootstrap\Alert::end(); ?>