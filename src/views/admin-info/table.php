<?php

use yii\helpers\Html;

/* @var $caption string */
/* @var $values array */
?>


<?php if (empty($values)): ?>

    <p>Empty.</p>

<?php else: ?>

    <table class="table table-condensed table-bordered table-striped table-hover sx-table" style="table-layout: fixed;">
        <thead>
        <tr>
            <th><?php echo \Yii::t('skeeks/cms', 'Name') ?></th>
            <th><?php echo \Yii::t('skeeks/cms', 'Value') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($values as $name => $value): ?>
            <tr>
                <th><?php echo Html::encode($name) ?></th>
                <td style="overflow:auto"><?php echo $value ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>
