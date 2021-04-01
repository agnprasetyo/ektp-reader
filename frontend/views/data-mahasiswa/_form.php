<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataMahasiswa;

/* @var $this yii\web\View */
/* @var $model common\models\DataMahasiswa */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="app" class="data-mahasiswa-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
      <div class="row">

    <div class="col-md-6">
        <?php // echo $form->field($model, 'id')->textInput(['value'=>DataMahasiswa::getNewID(), 'disabled' => false, 'readOnly' => true]) ?>

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
    </div></div></div>

    <?php ActiveForm::end(); ?>

</div>
