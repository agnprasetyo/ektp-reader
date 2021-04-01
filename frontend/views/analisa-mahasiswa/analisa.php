<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AnalisaAlternatif */

\yii\web\YiiAsset::register($this);

$this->title = ' Hasil Analisa Alternatif';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uIndex = Url::toRoute(['index', 'jk' => Yii::$app->request->get('jk')]);
$uBack = Yii::$app->request->referrer ?: $uHome;

$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-9">
                        <h4 class="page-title">{$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item"><a href="{$uIndex}">Analisa Alternatif</a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>

                    <div class="col-sm-3">
                        <div class="float-right d-none d-md-block">
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
              <div class="row">
        				<div class="col-md-6 text-left">
        					<strong style="font-size:18pt;"><span class="fa fa-table"></span> Alternatif Menurut Kriteria</strong>
        				</div>
        				<div class="col-md-6 text-right">
        					<form method="post">
        	          <button name="hapus" class="btn btn-danger">Hapus Semua Data</button>
        					</form>
        				</div>
        			</div>
                <br/>

                <table width="100%" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th rowspan="2" class="text-center active">Alternatif</th>
                      <th colspan="2" class="text-center">Kriteria <?=$dataKriteria['nama_kriteria']?></th>
                    </tr>
                    <tr>
                      <th class="text-center">Nilai</th>
                      <th class="bg-primary text-white text-center">Bobot</th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php foreach ($dataAnalisa as $value) { ?>
                      <tr>
                        <th class="active"><?=$value['id_alternatif']?></th>
                        <td>
                          <?=$value['nilai']?>
                        </td>
                        <td>

                          <?php
                          $total = $jumlah($value['id_kriteria']);
                          $hasil = $value['nilai']/$total['jumlah'];
                          echo number_format($hasil, 4, '.', ',');
                          $inputHasil($hasil, $value['id_kriteria'], $value['id_alternatif']);
                          // echo'<pre>';print_r($hasil);echo'</pre>';exit;
                          ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr class="info">
                      <th>Jumlah</th>
                      <th>
                        <?php
                        echo number_format($total['jumlah'], 4, '.', ',');
                        ?>
                      </th>
                    </tr>
                  </tfoot>
                </table>

          </div>
      </div>
  </div>
</div>
