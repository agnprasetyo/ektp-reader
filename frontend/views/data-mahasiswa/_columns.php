<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nik',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'alamat',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hasil_akhir',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'options' => [
            'style' => 'min-width: 100px',
        ],
        'header'   => 'Action',
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'view'   => function ($url, $model) {
                return Html::a('<i class="fa fa-eye"></i>',
                    $url,
                    [
                        'title' => 'Lihat',
                        'class' => 'btn btn-xs btn-primary',
                    ]
                );
            },
            'update' => function ($url, $model) {
                return Html::a('<i class="fa fa-paint-brush"></i>',
                    $url,
                    [
                        'title' => 'Perbarui',
                        'class' => 'btn btn-warning btn-xs',
                    ]
                );
            },
            'delete' => function ($url, $model) {
                return Html::a('<i class="fa fa-trash"></i>',
                    $url,
                    [
                        'title'        => 'Hapus',
                        'class'        => 'btn btn-danger btn-xs',
                        'data-method'  => 'post',
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    ]
                );
            },
        ],
    ],

];
