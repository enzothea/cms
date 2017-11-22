<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.06.2015
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\widgets\formInputs\componentSettings\ComponentSettingsWidget */
/* @var $element string */

$options = $widget->clientOptions;
$clientOptions = \yii\helpers\Json::encode($options);
?>
<div id="<?php echo $widget->id; ?>">
    <div class="sx-select-controll">
        <?php echo $element; ?>
    </div>
    <a href="#" class="<?php echo $widget->buttonClasses; ?>">
        <i class="glyphicon glyphicon-cog"></i> <?php echo $widget->buttonText; ?>
    </a>
</div>

<?

$this->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.ComponentSettingsWidget({$clientOptions});
})(sx, sx.$, sx._);
JS
)
?>
