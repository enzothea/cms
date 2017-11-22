<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 26.05.2016
 */

$filter = new \yii\base\DynamicModel([
    'id',
]);
$filter->addRule('id', 'integer');

$filter->load(\Yii::$app->request->get());

if ($filter->id) {
    $dataProvider->query->andWhere(['id' => $filter->id]);
}

?>
<? $form = \skeeks\cms\modules\admin\widgets\filters\AdminFiltersForm::begin([
    'action' => '/' . \Yii::$app->request->pathInfo,
]); ?>

<?php echo $form->field($searchModel, 'value')->setVisible(true)->textInput([
    'placeholder' => \Yii::t('skeeks/cms', 'Search by name')
]); ?>

<?php echo $form->field($searchModel, 'property_id')->label(\Yii::t('skeeks/cms', 'Property'))->setVisible(true)->widget(
    \skeeks\widget\chosen\Chosen::class,
    [
        'multiple' => true,
        'items' => \yii\helpers\ArrayHelper::map(
            \skeeks\cms\models\CmsContentProperty::find()->all(), 'id', 'name'
        )
    ]
); ?>

<? $form::end(); ?>
