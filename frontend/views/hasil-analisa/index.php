<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HasilAnalisaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hasil Analisas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hasil-analisa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Hasil Analisa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_alternatif',
            'Si',
            'Ri',
            'Qi',
            //'Qii',
            //'Qiii',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
