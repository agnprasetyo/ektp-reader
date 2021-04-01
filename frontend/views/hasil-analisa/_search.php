<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\HasilAnalisaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hasil-analisa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_alternatif') ?>

    <?= $form->field($model, 'Si') ?>

    <?= $form->field($model, 'Ri') ?>

    <?= $form->field($model, 'Qi') ?>

    <?php // echo $form->field($model, 'Qii') ?>

    <?php // echo $form->field($model, 'Qiii') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
