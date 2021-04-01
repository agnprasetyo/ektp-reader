<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\DataKriteria;

/* @var $this yii\web\View */
/* @var $model common\models\DataKriteria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-kriteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_kriteria')->textInput(['value'=>DataKriteria::getNewID(), 'disabled' => false, 'readOnly' => true]) ?>

    <?= $form->field($model, 'nama_kriteria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_kriteria')->hiddenInput(['value'=>'0', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'bobot_kriteria')->hiddenInput(['value'=>'0', 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'status')->hiddenInput(['value'=>'0', 'maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
