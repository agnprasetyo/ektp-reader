<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tools */

$this->title = 'Create Tools';
$this->params['breadcrumbs'][] = ['label' => 'Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tools-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
