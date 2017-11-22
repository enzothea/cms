<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 21.03.2017
 */
/* @var $this yii\web\View */
/* @var $controller \skeeks\cms\backend\controllers\BackendModelController */
/* @var $action \skeeks\cms\backend\actions\BackendModelCreateAction|\skeeks\cms\backend\actions\IHasActiveForm */
/* @var $model \skeeks\cms\models\CmsLang */
$controller = $this->context;
$action = $controller->action;
?>
<?php $form = $action->beginActiveForm(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Main')); ?>

<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => \Yii::t('skeeks/cms', 'Main')
]); ?>

<? if ($content_type = \Yii::$app->request->get('content_type')) : ?>
    <?php echo $form->field($model, 'content_type')->hiddenInput(['value' => $content_type])->label(false); ?>
<? else: ?>
    <div style="display: none;">
        <?php echo $form->fieldSelect($model, 'content_type',
            \yii\helpers\ArrayHelper::map(\skeeks\cms\models\CmsContentType::find()->all(), 'code', 'name')); ?>
    </div>
<? endif; ?>

<?php echo $form->field($model, 'name')->textInput(); ?>
<?php echo $form->field($model, 'code')->textInput()
    ->hint(\Yii::t('skeeks/cms',
        'The name of the template to draw the elements of this type will be the same as the name of the code.')); ?>

<?php echo $form->field($model, 'view_file')->textInput()
    ->hint(\Yii::t('skeeks/cms', 'The path to the template. If not specified, the pattern will be the same code.')); ?>


<?php echo $form->fieldRadioListBoolean($model, 'active'); ?>
<?php echo $form->fieldRadioListBoolean($model, 'visible'); ?>


<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => \Yii::t('skeeks/cms', 'Link to section')
]); ?>

<div class="row">
    <div class="col-md-6">

        <?php echo $form->field($model, 'default_tree_id')->widget(
            \skeeks\cms\backend\widgets\SelectModelDialogTreeWidget::class
        ); ?>
        <? /*= $form->fieldSelect($model, 'default_tree_id', \skeeks\cms\helpers\TreeOptions::getAllMultiOptions(), [
                    'allowDeselect' => true
                ]); */ ?>
    </div>
    <div class="col-md-6">
        <?php echo $form->fieldRadioListBoolean($model, 'is_allow_change_tree'); ?>
    </div>
</div>


<?php echo $form->field($model, 'root_tree_id')->widget(
    \skeeks\cms\backend\widgets\SelectModelDialogTreeWidget::class
)->hint(\Yii::t('skeeks/cms', 'If it is set to the root partition, the elements can be tied to him and his sub.')); ?>

<? /*= $form->fieldSelect($model, 'root_tree_id', \skeeks\cms\helpers\TreeOptions::getAllMultiOptions(), [
            'allowDeselect' => true
        ])->hint(\Yii::t('skeeks/cms', 'If it is set to the root partition, the elements can be tied to him and his sub.')); */ ?>

<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => \Yii::t('skeeks/cms', 'Relationship to other content')
]); ?>

<div class="row">
    <div class="col-md-3">
        <?php echo $form->fieldSelect($model, 'parent_content_id', \skeeks\cms\models\CmsContent::getDataForSelect(true,
            function (\yii\db\ActiveQuery $activeQuery) use ($model) {
                if (!$model->isNewRecord) {
                    $activeQuery->andWhere(['!=', 'id', $model->id]);
                }
            }),
            [
                'allowDeselect' => true
            ]
        ); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->fieldRadioListBoolean($model, 'parent_content_is_required'); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->fieldSelect($model, 'parent_content_on_delete',
            \skeeks\cms\models\CmsContent::getOnDeleteOptions()); ?>
    </div>
</div>


<? if ($model->childrenContents) : ?>
    <p><b><?php echo \Yii::t('skeeks/cms', 'Children content') ?></b></p>
    <? foreach ($model->childrenContents as $contentChildren) : ?>
        <p><?php echo \yii\helpers\Html::a($contentChildren->name, \skeeks\cms\helpers\UrlHelper::construct([
                '/cms/admin-cms-content/update',
                'pk' => $contentChildren->id
            ])->enableAdmin()->toString()) ?></p>
    <? endforeach; ?>

<? endif; ?>


<?php echo $form->fieldSetEnd(); ?>


<? if (!$model->isNewRecord) : ?>
    <? if ($controllerProperty = \Yii::$app->createController('cms/admin-cms-content-property')[0]) : ?>
        <?
        /**
         * @var \skeeks\cms\backend\BackendAction $actionIndex
         * @var \skeeks\cms\backend\BackendAction $actionCreate
         */
        $actionCreate = \yii\helpers\ArrayHelper::getValue($controllerProperty->actions, 'create');
        $actionIndex = \yii\helpers\ArrayHelper::getValue($controllerProperty->actions, 'index');
        ?>

        <? if ($actionIndex) : ?>
            <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Properties')) ?>

            <? $pjax = \yii\widgets\Pjax::begin(); ?>
            <?
            $query = \skeeks\cms\models\CmsContentProperty::find()->orderBy(['priority' => SORT_ASC]);
            $query->joinWith('cmsContentProperty2contents map');
            $query->andWhere(['map.cms_content_id' => $model->id]);
            ?>
            <?
            if ($actionCreate) {
                $actionCreate->url = \yii\helpers\ArrayHelper::merge($actionCreate->urlData, [
                    'content_id' => $model->id
                ]);

                $actionCreate->name = \Yii::t("skeeks/cms", "Create");

                /*echo \skeeks\cms\backend\widgets\DropdownControllerActionsWidget::widget([
                    'actions' => ['create' => $actionCreate],
                    'isOpenNewWindow' => true
                ]);*/

                echo \skeeks\cms\backend\widgets\ControllerActionsWidget::widget([
                    'actions' => ['create' => $actionCreate],
                    'clientOptions' => ['pjax-id' => $pjax->id],
                    'isOpenNewWindow' => true,
                    'tag' => 'div',
                    'itemWrapperTag' => 'span',
                    'itemTag' => 'button',
                    'itemOptions' => ['class' => 'btn btn-default'],
                    'options' => ['class' => 'sx-controll-actions'],
                ]);
            }
            ?>
            <?php echo \skeeks\cms\modules\admin\widgets\GridViewStandart::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $query
                ]),
                'settingsData' =>
                    [
                        'namespace' => \Yii::$app->controller->uniqueId . "__" . $model->id
                    ],
                'adminController' => $controllerProperty,
                'isOpenNewWindow' => true,
                //'filterModel'       => $searchModel,
                'autoColumns' => false,
                'pjax' => $pjax,
                'columns' =>
                    [
                        'name',

                        [
                            'label' => \Yii::t('skeeks/cms', 'Type'),
                            'format' => 'raw',
                            'value' => function (\skeeks\cms\models\CmsContentProperty $cmsContentProperty) {
                                return $cmsContentProperty->handler->name;
                            }
                        ],

                        [
                            'label' => \Yii::t('skeeks/cms', 'Content'),
                            'value' => function (\skeeks\cms\models\CmsContentProperty $cmsContentProperty) {
                                $contents = \yii\helpers\ArrayHelper::map($cmsContentProperty->cmsContents, 'id',
                                    'name');
                                return implode(', ', $contents);
                            }
                        ],

                        [
                            'label' => \Yii::t('skeeks/cms', 'Sections'),
                            'format' => 'raw',
                            'value' => function (\skeeks\cms\models\CmsContentProperty $cmsContentProperty) {
                                if ($cmsContentProperty->cmsTrees) {
                                    $contents = \yii\helpers\ArrayHelper::map($cmsContentProperty->cmsTrees, 'id',
                                        function ($cmsTree) {
                                            $path = [];

                                            if ($cmsTree->parents) {
                                                foreach ($cmsTree->parents as $parent) {
                                                    if ($parent->isRoot()) {
                                                        $path[] = "[" . $parent->site->name . "] " . $parent->name;
                                                    } else {
                                                        $path[] = $parent->name;
                                                    }
                                                }
                                            }
                                            $path = implode(" / ", $path);
                                            return "<small><a href='{$cmsTree->url}' target='_blank' data-pjax='0'>{$path} / {$cmsTree->name}</a></small>";

                                        });


                                    return '<b>' . \Yii::t('skeeks/cms',
                                            'Only shown in sections') . ':</b><br />' . implode('<br />', $contents);
                                } else {
                                    return '<b>' . \Yii::t('skeeks/cms', 'Always shown') . '</b>';
                                }
                            }
                        ],
                        [
                            'class' => \skeeks\cms\grid\BooleanColumn::className(),
                            'attribute' => "active"
                        ],
                        'code',
                        'priority',
                    ]
            ]); ?>

            <? \yii\widgets\Pjax::end(); ?>

            <?php echo $form->fieldSetEnd(); ?>
        <? endif; ?>
    <? endif; ?>





    <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Seo')); ?>
    <?php echo $form->field($model, 'meta_title_template')->textarea()->hint("Используйте конструкции вида {=model.name}"); ?>
    <?php echo $form->field($model, 'meta_description_template')->textarea(); ?>
    <?php echo $form->field($model, 'meta_keywords_template')->textarea(); ?>
    <?php echo $form->fieldSetEnd(); ?>

<? endif; ?>


<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Captions')); ?>
<?php echo $form->field($model, 'name_one')->textInput(); ?>
<?php echo $form->field($model, 'name_meny')->textInput(); ?>
<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Additionally')); ?>

<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => \Yii::t('skeeks/cms', 'Access')
]); ?>
<?php echo $form->fieldRadioListBoolean($model, 'access_check_element'); ?>

<?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
    'content' => \Yii::t('skeeks/cms', 'Additionally')
]); ?>
<?php echo $form->fieldInputInt($model, 'priority'); ?>
<? /*= $form->fieldRadioListBoolean($model, 'index_for_search'); */ ?>

<?php echo $form->fieldSetEnd(); ?>

<?php echo $form->buttonsCreateOrUpdate($model); ?>
<?php $action->endActiveForm(); ?>
