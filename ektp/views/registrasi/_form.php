<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="app" class="registrasi-form">

    <?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'class' => 'form-horizontal form-wizard-wrapper',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-md-4',
            'offset' => 'col-md-offset-4',
            'wrapper' => 'col-md-8',
        ],
    ],
    // 'validateOnChange' => false,
    // 'validateOnBlur' => false,
    // 'validateOnType' => false,
    // 'validateOnSubmit' => false,
    ]); ?>
    <div class="col-md-6">

      <div class="form-group">
        <label for="url">URL</label>
        <input type="text" name="url" v-model="url" class="form-control">
      </div>
      <div class="form-group">
        <button type="button" @click="refreshUrl" class="btn btn-primary">Refresh</button>
      </div>

        <?= $form->field($model, 'nik')->textInput([
          'v-model' => "ektp.nik",
          'disabled' => false,
          'readOnly' => true,
        ])->label('Nomor Identitas') ?>

        <?= $form->field($model, 'nama')->textInput([
          'v-model' => "ektp.namaLengkap",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'alamat')->textInput([
          'v-model' => "ektp.alamatLengkap",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'jenis_kelamin')->textInput([
          'v-model' => "ektp.jenisKelamin",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'tempat_lahir')->textInput([
          'v-model' => "ektp.tempatLahir",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'tanggal_lahir')->textInput([
          'v-model' => "ektp.tanggalLahir",
          'format' => 'dd-mm-yyyy',
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'agama')->textInput([
          'v-model' => "ektp.agama",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'status')->textInput([
          'v-model' => "ektp.statusKawin",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'pekerjaan')->textInput([
          'v-model' => "ektp.jenisPekerjaan",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

        <?= $form->field($model, 'berlaku_hingga')->textInput([
          'v-model' => "ektp.berlakuHingga",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>

    </div>
    <div class="col-md-6">
      <br><br><br><br><br><br>
        <?= $form->field($model, 'nim')->textInput([
          'v-model' => "siakad.nim",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>
        <?= $form->field($model, 'jenjang')->textInput([
          'v-model' => "siakad.nama_jenjang",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>
        <?= $form->field($model, 'jurusan')->textInput([
          'v-model' => "siakad.nama_jurusan",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>
        <?= $form->field($model, 'fakultas')->textInput([
          'v-model' => "siakad.nama_fakultas",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>
        <?= $form->field($model, 'status_mhs')->textInput([
          'v-model' => "siakad.status",
          'disabled' => false,
          'readOnly' => true,
        ]) ?>
        
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
