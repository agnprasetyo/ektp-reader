<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\KonversiNilai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="konversi-nilai-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_kriteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai_awal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai_konversi')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
