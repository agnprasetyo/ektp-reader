<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Tools */
/* @var $form yii\widgets\ActiveForm */

$params['user'] = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'value');
?>

<div class="tools-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->dropDownList($params['user'], ['prompt' => 'Pilih User']) ?>

    <?= $form->field($model, 'port')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'serial')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'tempat')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
