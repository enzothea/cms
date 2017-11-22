<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 29.04.2015
 */
?>
<h2><?php echo \Yii::t('skeeks/cms', 'Servers to store the files.') ?></h2>
<? foreach (\Yii::$app->storage->getClusters() as $count => $cluster) : ?>
    <div class="sx-box sx-p-10 sx-bg-primary">
        <div class="row">
            <div class="col-md-12">
                <h3><b><?php echo $count + 1; ?>. <?php echo $cluster->name; ?></b></h3>
                <hr/>
            </div>
            <div class="col-md-4">
                <p><b><?php echo \Yii::t('skeeks/cms', 'Public file path') ?>: </b> <?php echo $cluster->publicBaseUrl; ?></p>
                <p><b><?php echo \Yii::t('skeeks/cms', 'The folder on the server') ?>: </b> <?php echo $cluster->rootBasePath; ?></p>

                <p><b><?php echo \Yii::t('skeeks/cms',
                            'Total available space') ?></b>: <?php echo Yii::$app->formatter->asShortSize($cluster->getTotalSpace()); ?>
                </p>
                <p><b><?php echo \Yii::t('skeeks/cms',
                            'Used') ?></b>: <?php echo Yii::$app->formatter->asShortSize($cluster->getUsedSpace()); ?></p>
                <p><b><?php echo \Yii::t('skeeks/cms',
                            'Free') ?></b>: <?php echo Yii::$app->formatter->asShortSize($cluster->getFreeSpace()); ?></p>

                <? if ($cluster instanceof \skeeks\cms\components\storage\ClusterLocal) : ?>
                    <? if ($cluster->publicBaseUrlIsAbsolute) : ?>
                        <p><b><?php echo \Yii::t('skeeks/cms', 'Files download from domain') ?>
                                : </b> <?php echo $cluster->publicBaseUrlIsAbsolute; ?></p>
                    <? endif; ?>
                <? endif; ?>
            </div>
            <div class="col-md-5">
                <ul class="statistics">
                    <li>
                        <i class="icon-pie-chart"></i>
                        <div class="number"><?php echo round($cluster->getFreeSpacePct()); ?>%</div>
                        <div class="title"><?php echo \Yii::t('skeeks/cms', 'Free place') ?></div>
                        <div class="progress thin">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="<?php echo $cluster->getFreeSpacePct(); ?>" aria-valuemin="0"
                                 aria-valuemax="100" style="width: <?php echo $cluster->getFreeSpacePct(); ?>%">
                                <span class="sr-only"><?php echo round($cluster->getFreeSpacePct()); ?>
                                    % Complete (success)</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <?

                $baseOptions =
                    [
                        'title' => ['text' => \Yii::t('skeeks/cms', 'At percent ratio')],
                        'chart' => [
                            'type' => 'pie',

                        ],
                        'plotOptions' =>
                            [
                                'pie' =>
                                    [
                                        'allowPointSelect' => 'true',
                                        'cursor' => "pointer",
                                        'depth' => 35,
                                        'dataLabels' =>
                                            [
                                                'enabled' => 'true',
                                                'format' => '{point.name}',
                                            ]
                                    ]
                            ],
                        'series' => [
                            [
                                'type' => 'pie',
                                'name' => '%',
                                'data' =>
                                    [
                                        [\Yii::t('skeeks/cms', 'Free'), round($cluster->getFreeSpacePct())],
                                        [\Yii::t('skeeks/cms', 'Used'), round($cluster->getUsedSpacePct())],
                                    ]

                            ],
                        ]
                    ];
                echo \skeeks\widget\highcharts\Highcharts::widget(['options' => $baseOptions]);

                ?>
            </div>
        </div>
    </div>
<? endforeach; ?>
