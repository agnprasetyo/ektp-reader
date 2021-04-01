<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HasilAnalisa */

$this->title = 'Update Hasil Analisa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hasil Analisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hasil-analisa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
