<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 26.05.2016
 */
/**
 * @var $query \yii\db\ActiveQuery
 */
$query = $dataProvider->query;
$filter = new \yii\base\DynamicModel([
    'fill',
]);
$filter->addRule('fill', 'integer');

$filter->load(\Yii::$app->request->get());

if ($filter->fill) {
    $query->joinWith('cmsTreeProperties as tp');
    $query->andWhere(['!=', 'tp.value', '']);
    $query->andWhere(['tp.property_id' => $filter->fill]);
    $query->groupBy('id');
}

/*if ($filter->not_fill == 'not_fill')
{
    $query->joinWith('elementProperties as ep');
    $query->andWhere(['=', 'value', '']);
    $query->groupBy('id');
}*/
?>
<? $form = \skeeks\cms\modules\admin\widgets\filters\AdminFiltersForm::begin([
    'action' => '/' . \Yii::$app->request->pathInfo,
]); ?>

<?php echo $form->field($searchModel, 'name')->setVisible(true)->textInput([
    'placeholder' => \Yii::t('skeeks/cms', 'Search by name')
]) ?>

<?php echo $form->field($searchModel, 'id') ?>

<?php echo $form->field($searchModel, 'code'); ?>

<?php echo $form->field($searchModel, 'active')->listBox(\yii\helpers\ArrayHelper::merge([
    '' => ' - '
], \Yii::$app->cms->booleanFormat()), [
    'size' => 1
]); ?>

<?php echo $form->field($filter, 'fill')
    ->label(\Yii::t('skeeks/cms', 'Связь с разделами'))
    ->widget(
        \skeeks\widget\chosen\Chosen::class,
        [
            'items' => \yii\helpers\ArrayHelper::map(
                \skeeks\cms\models\CmsTreeTypeProperty::find()->all(), 'id', 'name'
            )
        ]
    ); ?>

<? $form::end(); ?>
