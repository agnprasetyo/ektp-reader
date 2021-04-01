<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HasilAnalisa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hasil-analisa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_alternatif')->textInput() ?>

    <?= $form->field($model, 'Si')->textInput() ?>

    <?= $form->field($model, 'Ri')->textInput() ?>

    <?= $form->field($model, 'Qi')->textInput() ?>

    <?= $form->field($model, 'Qii')->textInput() ?>

    <?= $form->field($model, 'Qiii')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
