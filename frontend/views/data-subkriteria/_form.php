<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DataSubkriteria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-subkriteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_kriteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_subkriteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_subkriteria')->textInput() ?>

    <?= $form->field($model, 'bobot_subkriteria')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
