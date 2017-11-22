<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 18.12.2016
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\widgets\tree\CmsTreeWidget */
/* @var $model \skeeks\cms\models\CmsTree */
$widget = $this->context;
?>
<?php echo \yii\helpers\Html::beginTag('li', [
    "class" => "sx-tree-node " . ($widget->isOpenNode($model) ? " open" : ""),
    "data-id" => $model->id,
    "title" => ""
]); ?>

<div class="row">
    <? if ($model->children) : ?>
        <div class="sx-node-open-close">
            <? if ($widget->isOpenNode($model)) : ?>
                <a href="<?php echo $widget->getOpenCloseLink($model); ?>" class="btn btn-sm btn-default">
                    <span class="glyphicon glyphicon-minus" title="<?php echo \Yii::t('skeeks/cms', "Minimize"); ?>"></span>
                </a>
            <? else : ?>
                <a href="<?php echo $widget->getOpenCloseLink($model); ?>" class="btn btn-sm btn-default">
                    <span class="glyphicon glyphicon-plus" title="<?php echo \Yii::t('skeeks/cms', "Restore"); ?>"></span>
                </a>
            <? endif; ?>
        </div>
    <? endif; ?>

    <?php echo $widget->renderNodeContent($model); ?>

</div>

<!-- Construction of child elements -->
<? if ($widget->isOpenNode($model) && $model->children) : ?>
    <?php echo $widget->renderNodes($model->children); ?>
<? endif; ?>

<?php echo \yii\helpers\Html::endTag('li'); ?>

