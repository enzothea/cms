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
/* @var $selectTreeInputWidget \skeeks\cms\widgets\formInputs\selectTree\SelectTreeInputWidget */
$widget = $this->context;
$selectTreeInputWidget = \yii\helpers\ArrayHelper::getValue($widget->contextData, 'selectTreeInputWidget');
?>

<?php echo $selectTreeInputWidget->renderNodeControll($model); ?>
<div class="sx-label-node level-<?php echo $model->level; ?> status-<?php echo $model->active; ?>">
    <a href="<?php echo $widget->getOpenCloseLink($model); ?>"><?php echo $selectTreeInputWidget->renderNodeName($model); ?></a>
</div>

<!-- Possible actions -->
<!--<div class="sx-controll-node row">
    <div class="pull-left sx-controll-act">
        <a href="<? /*= $model->absoluteUrl; */ ?>" target="_blank" class="btn-tree-node-controll btn btn-default btn-sm show-at-site" title="<? /*= \Yii::t('skeeks/cms',"Show at site"); */ ?>">
            <span class="glyphicon glyphicon-eye-open"></span>
        </a>
    </div>
</div>-->

<? /* if ($model->treeType) : */ ?><!--
    <div class="pull-right sx-tree-type">
        <? /*= $model->treeType->name; */ ?>
    </div>
--><? /* endif; */ ?>

