<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Registrasi */

// $this->title = 'Create Registrasi';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue/dist/vue.js');
$this->registerJsFile('https://unpkg.com/axios/dist/axios.min.js');
$this->registerJs($this->render('_index.js', ['port' => $port]));
?>
<div class="registrasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
