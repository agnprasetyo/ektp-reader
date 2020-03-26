<?php
/**
 * @link      https://www.diecoding.com/
 * @author    Die Coding (Sugeng Sulistiyawan) <diecoding@gmail.com>
 * @copyright Copyright (c) Die Coding - Digital Startup Indonesia
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";

?>
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $name) {
        echo "    [\n";
        echo "        'class'     => '\kartik\grid\DataColumn',\n";
        echo "        'attribute' => '" . $name . "',\n";
        echo "    ],\n";
    }
    ?>
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{all}',
        'buttons' => [
            'all' => function ($url, $model, $key) {
                $view = Html::a('<i class="mdi mdi-eye"></i>', 
                    ['view', <?= $urlParams ?>],
                    [
                        'class' => 'btn-sm btn btn-dark',
                        'data' => [
                            'toggle' => 'tooltip',
                            'title' => 'Lihat',
                            'pjax' => 0,
                        ],
                    ]);

                $update = Html::a('<i class="mdi mdi-grease-pencil"></i>', 
                    ['update', <?= $urlParams ?>],
                    [
                        'class' => 'btn-sm btn btn-primary',
                        'data' => [
                            'toggle' => 'tooltip',
                            'title' => 'Perbarui',
                            'pjax' => 0,
                        ],
                    ]);

                $delete = Html::a('<i class="mdi mdi-trash-can"></i>', 
                    ['delete', <?= $urlParams ?>],
                    [
                        'class' => 'btn-sm btn btn-danger',
                        'data' => [
                            'toggle' => 'tooltip',
                            'title' => 'Hapus',
                            'pjax' => 0,
                            'method' => 'post',
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        ],
                    ]);

                $hasChilds = false;
                $delete = !$hasChilds ? $delete : '';

                return "<div class='btn-group'>
                    {$view}
                    {$update}
                    {$delete}
                </div>";
            },
        ],
    ],

];
