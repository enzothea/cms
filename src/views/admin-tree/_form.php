<?php

use skeeks\cms\models\Tree;
use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;

/* @var $this yii\web\View */
/* @var $model Tree */
/* @var $this yii\web\View */
/* @var $controller \skeeks\cms\backend\controllers\BackendModelController */
/* @var $action \skeeks\cms\backend\actions\BackendModelCreateAction|\skeeks\cms\backend\actions\IHasActiveForm */
/* @var $model \skeeks\cms\models\CmsLang */
$controller = $this->context;
$action = $controller->action;

?>

    <div class="sx-box sx-p-10 sx-bg-primary" style="margin-bottom: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <? if ($model->parents) : ?>
                        <? foreach ($model->parents as $tree) : ?>
                            <a href="<?php echo $tree->url ?>" target="_blank"
                               title="<?php echo \Yii::t('skeeks/cms', 'Watch to site (opens new window)') ?>">
                                <?php echo $tree->name ?>
                                <? if ($tree->level == 0) : ?>
                                    [<?php echo $tree->site->name; ?>]
                                <? endif; ?>
                            </a>
                            /
                        <? endforeach; ?>
                    <? endif; ?>
                    <a href="<?php echo $model->url ?>" target="_blank"
                       title="<?php echo Yii::t('skeeks/cms', 'Watch to site (opens new window)') ?>">
                        <?php echo $model->name; ?>
                    </a>
                </div>
                <div class="pull-right">

                </div>
            </div>
        </div>
    </div>

<?php $form = $action->beginActiveForm([
    'id' => 'sx-dynamic-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
]); ?>

<? $this->registerJs(<<<JS

(function(sx, $, _)
{
    sx.classes.DynamicForm = sx.classes.Component.extend({

        _onDomReady: function()
        {
            var self = this;

            $("[data-form-reload=true]").on('change', function()
            {
                self.update();
            });
        },

        update: function()
        {
            _.delay(function()
            {
                var jForm = $("#sx-dynamic-form");
                jForm.append($('<input>', {'type': 'hidden', 'name' : 'sx-not-submit', 'value': 'true'}));
                jForm.submit();
            }, 200);
        }
    });

    sx.DynamicForm = new sx.classes.DynamicForm();
})(sx, sx.$, sx._);


JS
); ?>
<?php echo $form->errorSummary([$model, $model->relatedPropertiesModel]); ?>


<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Main')); ?>



<?php echo $form->fieldRadioListBoolean($model, 'active'); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'name_hidden')->textInput(['maxlength' => 255])
                ->hint(\Yii::t('skeeks/cms', 'Not displayed on the site')) ?>
        </div>
    </div>

<?php echo $form->field($model, 'code')->textInput(['maxlength' => 255])
    ->hint(\Yii::t('skeeks/cms',
        \Yii::t('skeeks/cms', 'This affects the address of the page, be careful when editing.'))); ?>




<?php echo Html::checkbox("isLink", (bool)($model->redirect || $model->redirect_tree_id), [
    'value' => '1',
    'label' => \Yii::t('skeeks/cms', 'This section is a link'),
    'class' => 'smartCheck',
    'id' => 'isLink',
]); ?>

    <div data-listen="isLink" data-show="0" class="sx-hide">
        <?php echo $form->field($model, 'tree_type_id')->widget(
            \skeeks\widget\chosen\Chosen::className(), [
            'items' => \yii\helpers\ArrayHelper::map(
                \skeeks\cms\models\CmsTreeType::find()->active()->all(),
                "id",
                "name"
            ),
            'options' =>
                [
                    'data-form-reload' => 'true'
                ]
        ])->label('Тип раздела')->hint(\Yii::t('skeeks/cms',
            'On selected type of partition can depend how it will be displayed.'));
        ?>

        <?php echo $form->field($model, 'view_file')->textInput()
            ->hint('@app/views/template-name || template-name'); ?>

    </div>

    <div data-listen="isLink" data-show="1" class="sx-hide">
        <?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
            'content' => \Yii::t('skeeks/cms', 'Redirect')
        ]); ?>
        <?php echo $form->field($model, 'redirect_code', [])->radioList([
            301 => 'Постоянное перенаправление [301]',
            302 => 'Временное перенаправление [302]'
        ])
            ->label(\Yii::t('skeeks/cms', 'Redirect Code')) ?>
        <div class="row">
            <div class="col-md-5">
                <?php echo $form->field($model, 'redirect', [])->textInput(['maxlength' => 500])->label(\Yii::t('skeeks/cms',
                    'Redirect'))
                    ->hint(\Yii::t('skeeks/cms',
                        'Specify an absolute or relative URL for redirection, in the free form.')) ?>
            </div>
            <div class="col-md-7">
                <?php echo $form->field($model, 'redirect_tree_id')->widget(
                    \skeeks\cms\widgets\formInputs\selectTree\SelectTree::className(),
                    [
                        "attributeSingle" => "redirect_tree_id",
                        "mode" => \skeeks\cms\widgets\formInputs\selectTree\SelectTree::MOD_SINGLE
                    ]
                ) ?>
            </div>
        </div>


    </div>


<? if ($relatedModel->properties) : ?>

    <?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
        'content' => \Yii::t('skeeks/cms', 'Additional properties')
    ]); ?>

    <? foreach ($relatedModel->properties as $property) : ?>
        <?php echo $property->renderActiveForm($form); ?>
    <? endforeach; ?>

<? else : ?>
    <? /*= \Yii::t('skeeks/cms','Additional properties are not set')*/ ?>
<? endif; ?>

<?php echo $form->fieldSetEnd() ?>



<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Announcement')); ?>

<?php echo $form->field($model, 'image_id')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => false
    ]
); ?>

    <div data-listen="isLink" data-show="0" class="sx-hide">
        <?php echo $form->field($model, 'description_short')->widget(
            \skeeks\cms\widgets\formInputs\comboText\ComboTextInputWidget::className(),
            [
                'modelAttributeSaveType' => 'description_short_type',
            ]);
        ?>

        <? /*= $form->field($model, 'description_short')->widget(
        \skeeks\cms\widgets\formInputs\comboText\ComboTextInputWidget::className(),
        [
            'modelAttributeSaveType' => 'description_short_type',
            'ckeditorOptions' => [

                'preset'        => 'full',
                'relatedModel'  => $model,
            ],
            'codemirrorOptions' =>
            [
                'preset'    => 'php',
                'assets'    =>
                [
                    \skeeks\widget\codemirror\CodemirrorAsset::THEME_NIGHT
                ],

                'clientOptions'   =>
                [
                    'theme' => 'night',
                ],
            ]
        ])
        */ ?>

    </div>
<?php echo $form->fieldSetEnd() ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'In detal')); ?>

<?php echo $form->field($model, 'image_full_id')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => false
    ]
); ?>

    <div data-listen="isLink" data-show="0" class="sx-hide">

        <?php echo $form->field($model, 'description_full')->widget(
            \skeeks\cms\widgets\formInputs\comboText\ComboTextInputWidget::className(),
            [
                'modelAttributeSaveType' => 'description_full_type',
            ]);
        ?>

    </div>
<?php echo $form->fieldSetEnd() ?>

<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'SEO')); ?>
<?php echo $form->field($model, 'meta_title')->textarea(); ?>
<?php echo $form->field($model, 'meta_description')->textarea(); ?>
<?php echo $form->field($model, 'meta_keywords')->textarea(); ?>
<?php echo $form->fieldSetEnd() ?>


<?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Images/Files')); ?>

<?php echo $form->field($model, 'imageIds')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'accept' => 'image/*',
        'multiple' => true
    ]
); ?>

<?php echo $form->field($model, 'fileIds')->widget(
    \skeeks\cms\widgets\AjaxFileUploadWidget::class,
    [
        'multiple' => true
    ]
); ?>

<?php echo $form->fieldSetEnd() ?>


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

            <? if ($contents = \skeeks\cms\models\CmsContent::find()->active()->all()) : ?>

                <?php echo $form->fieldSet(\Yii::t('skeeks/cms', 'Properties of elements')) ?>


                <? foreach ($contents as $content) : ?>

                    <h2><?php echo \skeeks\cms\modules\admin\widgets\BlockTitleWidget::widget([
                            'content' => $content->name
                        ]); ?></h2>
                    <? $pjax = \yii\widgets\Pjax::begin(); ?>
                    <?
                    $query = \skeeks\cms\models\CmsContentProperty::find()->orderBy(['priority' => SORT_ASC]);
                    $query->joinWith('cmsContentProperty2contents cmap');
                    $query->joinWith('cmsContentProperty2trees tmap');
                    $query->andWhere([
                        'cmap.cms_content_id' => $content->id,
                    ]);
                    $query->andWhere([
                        'or',
                        ['tmap.cms_tree_id' => $model->id],
                        ['tmap.cms_tree_id' => null],
                    ]);
                    ?>
                    <?
                    if ($actionCreate) {
                        $actionCreate->url = \yii\helpers\ArrayHelper::merge($actionCreate->urlData, [
                            'content_id' => $content->id,
                            'tree_id' => $model->id
                        ]);

                        $actionCreate->name = \Yii::t("skeeks/cms", "Create");

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
                                        $contents = \yii\helpers\ArrayHelper::map($cmsContentProperty->cmsContents,
                                            'id', 'name');
                                        return implode(', ', $contents);
                                    }
                                ],

                                [
                                    'label' => \Yii::t('skeeks/cms', 'Sections'),
                                    'format' => 'raw',
                                    'value' => function (\skeeks\cms\models\CmsContentProperty $cmsContentProperty) {
                                        if ($cmsContentProperty->cmsTrees) {
                                            $contents = \yii\helpers\ArrayHelper::map($cmsContentProperty->cmsTrees,
                                                'id', function ($cmsTree) {
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
                                                    'Only shown in sections') . ':</b><br />' . implode('<br />',
                                                    $contents);
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

                <? endforeach; ?>




                <?php echo $form->fieldSetEnd(); ?>


            <? endif; ?>


        <? endif; ?>
    <? endif; ?>
<? endif; ?>

        <!--
<? /*= $form->fieldSet(\Yii::t('skeeks/cms','Additionally')) */ ?>

    <? /*= $form->field($model, 'tree_menu_ids')->label(\Yii::t('skeeks/cms','Marks'))->widget(
        \skeeks\cms\widgets\formInputs\EditedSelect::className(), [
            'items' => \yii\helpers\ArrayHelper::map(
                 \skeeks\cms\models\TreeMenu::find()->all(),
                 "id",
                 "name"
             ),
            'multiple' => true,
            'controllerRoute' => 'cms/admin-tree-menu',
        ]

        )->hint(\Yii::t('skeeks/cms','You can link the current section to a few marks, and according to this, section will be displayed in different menus for example.'));
    */ ?>

--><? /*= $form->fieldSetEnd() */ ?>


<?
/*$columnsFile = \Yii::getAlias('@skeeks/cms/views/admin-cms-content-element/_columns.php');*/
/**
 * @var $content \skeeks\cms\models\CmsContent
 */
?>
<? /* if ($contents = \skeeks\cms\models\CmsContent::find()->active()->all()) : */ ?><!--
    <? /* foreach ($contents as $content) : */ ?>
        <? /*= $form->fieldSet($content->name) */ ?>


            <? /*= \skeeks\cms\modules\admin\widgets\RelatedModelsGrid::widget([
                'label'             => $content->name,
                'hint'              => \Yii::t('skeeks/cms',"Showing all elements of type '{name}' associated with this section. Taken into account only the main binding.",['name' => $content->name]),
                'parentModel'       => $model,
                'relation'          => [
                    'tree_id'       => 'id',
                    'content_id'    => $content->id
                ],

                'sort'              => [
                    'defaultOrder' =>
                    [
                        'priority' => 'published_at'
                    ]
                ],

                'controllerRoute'   => 'cms/admin-cms-content-element',
                'gridViewOptions'   => [
                    'columns' => (array) include $columnsFile
                ],
            ]); */ ?>

        <? /*= $form->fieldSetEnd() */ ?>
    <? /* endforeach; */ ?>
--><? /* endif; */ ?>

<?php echo $form->buttonsCreateOrUpdate($model); ?>

<? $this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.createNamespace('classes', sx);

        sx.classes.SmartCheck = sx.classes.Component.extend({

            _init: function()
            {},

            _onDomReady: function()
            {
                var self = this;

                this.JsmartCheck = $('.smartCheck');

                self.updateInstance($(this.JsmartCheck));

                this.JsmartCheck.on("change", function()
                {
                    self.updateInstance($(this));
                });
            },

            updateInstance: function(JsmartCheck)
            {
                if (!JsmartCheck instanceof jQuery)
                {
                    throw new Error('1');
                }

                var id  = JsmartCheck.attr('id');
                var val = Number(JsmartCheck.is(":checked"));

                if (!id)
                {
                    return false;
                }

                if (val == 0)
                {
                    $('#tree-redirect').val('');
                    $('#tree-redirect_tree_id').val('');
                }

                $('[data-listen="' + id + '"]').hide();
                $('[data-listen="' + id + '"][data-show="' + val + '"]').show();

            },
        });

        new sx.classes.SmartCheck();
    })(sx, sx.$, sx._);
JS
);
?>
<?php echo $form->errorSummary([$model, $model->relatedPropertiesModel]); ?>
<?php ActiveForm::end(); ?>