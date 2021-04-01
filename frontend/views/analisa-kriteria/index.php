<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AnalisaKriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analisa Kriteria';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uKriteria = Url::to(['/data-kriteria/index']);
$uHasil = Url::toRoute(['hasil', 'jk' => Yii::$app->request->get('jk')]);
$uBack = Yii::$app->request->referrer ?: $uHome;

$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h4 class="page-title">{$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item"><a href="{$uKriteria}">Data Kriteria</a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>

                    <div class="col-sm-4">
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                          <a href="{$uHasil}" class="btn btn-primary">
                            <i class="mdi mdi-eye mr-2"></i>
                            Hasil Analisa
                          </a>
                        </div>
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                          <a href="{$uBack}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left mr-2"></i>
                            Kembali
                          </a>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>
            <!-- end page title -->
        </div> <!-- end col -->
    </div> <!-- end row-->
</div>
HTML;
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
      				<!-- <form method="post" action="analisa-kriteria-tabel.php"> -->
              <?php $form = ActiveForm::begin(['id' => 'analisa-kriteria-form', 'method' => 'post']); ?>
      					<div class="row">
      						<div class="col-xs-12 col-md-3">
      							<div class="form-group">
      								<label>Kriteria Pertama</label>
      							</div>
      						</div>
      						<div class="col-xs-12 col-md-6">
      							<div class="form-group">
      								<label>Pernilaian</label>
      							</div>
      						</div>
      						<div class="col-xs-12 col-md-3">
      							<div class="form-group">
      								<label>Kriteria Kedua</label>
      							</div>
      						</div>
      					</div>
      						<?php for ($i=0; $i < (count($query)); $i++) { ?>
      							<?php for ($j=(count($query)-1); $j > $i ; $j--) {?>
                      <?php
                          $kriteriaSatu = $query[$i]['id_kriteria'];
                          $kriteriaDua = $query[$j]['id_kriteria'];
                      ?>
      								<div class="row">
      									<div class="col-xs-12 col-md-3">
      										<div class="form-group">
      												<input type="text" class="form-control" value="<?= $query[$i]['nama_kriteria'] ?>" readonly />
      												<input type="hidden" name="kriteria_pertama[]" value="<?=$kriteriaSatu?>" />
      										</div>
      									</div>
      									<div class="col-xs-12 col-md-6">
      										<div class="form-group">
                            <?= \yii\helpers\Html::dropDownList('nilai_analisa_kriteria[]', null, $nilai, ['class' => 'form-control']) ?>
      										</div>
      									</div>

                        <input type="hidden" name="hasil_analisa_kriteria[]" value="0" />

      									<div class="col-xs-12 col-md-3">
      										<div class="form-group">
      												<input type="text" class="form-control" value="<?=$query[$j]['nama_kriteria']?>" readonly />
      												<input type="hidden" name="kriteria_kedua[]" value="<?=$kriteriaDua?>" />
      										</div>
      									</div>
      								</div>
      							<?php } ?>
      						<?php } ?>

                <p>
                    <?php // Html::a('Analisa Kriteria', ['analisa'], ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </p>
              <?php ActiveForm::end(); ?>
      				<!-- </form> -->
          </div>
      </div>
  </div>
</div>
