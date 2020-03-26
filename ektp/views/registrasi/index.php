<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistrasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registrasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registrasi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Registrasi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nik',
            'nama',
            'alamat',
            'jenis_kelamin',
            //'tempat_lahir',
            // 'tanggal_lahir',
            //'agama',
            //'status',
            //'pekerjaan',
            //'berlaku_hingga',

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => [
                    'style' => 'min-width: 100px',
                ],
                'header'   => 'Action',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view'   => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',
                            $url,
                            [
                                'title' => 'Lihat',
                                'class' => 'btn btn-xs btn-primary',
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                            $url,
                            [
                                'title' => 'Perbarui',
                                'class' => 'btn btn-warning btn-xs',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>',
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
        ],
    ]); ?>


</div>
