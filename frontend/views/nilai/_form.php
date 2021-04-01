<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Nilai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nilai-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jum_nilai')->textInput() ?>

    <?= $form->field($model, 'ket_nilai')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
