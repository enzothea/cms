<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 *
 * @var $component \skeeks\cms\base\Component
 */
/* @var $this yii\web\View */
?>

<?php echo $this->render('_header', [
    'component' => $component
]); ?>


<div class="sx-box sx-mb-10 sx-p-10">
    <p><?php echo \Yii::t('skeeks/cms',
            'This component may have personal preferences for each user. And it works differently depending on which of the sites is displayed.') ?></p>
    <p><?php echo \Yii::t('skeeks/cms',
            'In that case, if user not has personal settings will be used the default settings.') ?></p>
    <? if ($settings = \skeeks\cms\models\CmsComponentSettings::findByComponent($component)->andWhere([
        '>',
        'user_id',
        0
    ])->count()) : ?>
        <p><b><?php echo \Yii::t('skeeks/cms', 'Number of customized users') ?>:</b> <?php echo $settings; ?></p>
        <button type="submit" class="btn btn-danger btn-xs"
                onclick="sx.ComponentSettings.Remove.removeUsers(); return false;">
            <i class="glyphicon glyphicon-remove"></i> <?php echo \Yii::t('skeeks/cms', 'Reset settings for all users') ?>
        </button>
    <? else: ?>
        <small><?php echo \Yii::t('skeeks/cms', 'Neither user does not have personal settings for this component') ?></small>
    <? endif; ?>
</div>

<?
$search = new \skeeks\cms\models\Search(\skeeks\cms\models\User::className());
$search->search(\Yii::$app->request->get());
$search->getDataProvider()->query->andWhere(['active' => \skeeks\cms\components\Cms::BOOL_Y]);
?>
<?php echo \skeeks\cms\modules\admin\widgets\GridViewHasSettings::widget([
    'dataProvider' => $search->getDataProvider(),
    'filterModel' => $search->getLoadedModel(),
    'columns' => [
        [
            'class' => \yii\grid\DataColumn::className(),
            'value' => function (\skeeks\cms\models\User $model, $key, $index) {
                return \yii\helpers\Html::a('<i class="glyphicon glyphicon-cog"></i>',
                    \skeeks\cms\helpers\UrlHelper::constructCurrent()->setRoute('cms/admin-component-settings/user')->set('user_id',
                        $model->id)->toString(),
                    [
                        'class' => 'btn btn-default btn-xs',
                        'title' => \Yii::t('skeeks/cms', 'Customize')
                    ]);
            },

            'format' => 'raw',
        ],

        'username',
        'name',

        [
            'class' => \skeeks\cms\grid\ComponentSettingsColumn::className(),
            'component' => $component,
        ],
    ]
]) ?>


<?php echo $this->render('_footer'); ?>
