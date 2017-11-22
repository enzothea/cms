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
<div class="sx-label-node level-<?php echo $model->level; ?> status-<?php echo $model->active; ?>">
    <a href="<?php echo $widget->getOpenCloseLink($model); ?>">
        <?php echo $model->name; ?>
    </a>
</div>

