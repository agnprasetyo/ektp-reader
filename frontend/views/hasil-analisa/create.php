<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HasilAnalisa */

$this->title = 'Create Hasil Analisa';
$this->params['breadcrumbs'][] = ['label' => 'Hasil Analisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hasil-analisa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
