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
                      <th class="text-center active">Alternatif</th>
                      <th>Hasil Si</th>
                      <th>Hasil Ri</th>
                      <th>Hasil Qi</th>
                      <th>Hasil Qii</th>
                      <th>Hasil Qiii</th>
                    </tr>

                  </thead>
                  <tbody>

                    <?php
                      // foreach ($dataMahasiswa as $b) {
                      //   foreach ($dataKriteria as $k) {
                      //       $bobot = $getSkor($b['id'], $k['id_kriteria']);
                      //       $hasil = $bobot['bobot'] * $k['bobot_kriteria'];
                      //
                      //       $normalisasi = $inputNormalisasi($hasil, $b['id'], $k['id_kriteria']);
                      //   }
                      //
                      //   $si = $jumlah($b['id']);
                      //   $satu = $inputSi($si['jumlah'], $b['id']);
                      //
                      //   // $dataMahasiswa[$key]['si'] = $si['jumlah'];
                      //
                      //   $ri = $terbesar($b['id']);
                      //   $dua = $inputRi($ri['max'], $b['id']);
                      // }
                    ?>

                    <?php foreach ($dataMahasiswa as $key => $baris) { ?>
                      <tr>
                        <th class="active"><?=$baris['nama']?></th>
                        <td>
                          <?php
                          $si = $jumlah($baris['id']);
                          $satu = $inputSi($si['jumlah'], $baris['id']);
                          echo number_format($si['jumlah'], 4, '.', ',');
                          ?>
                        </td>
                        <td>
                          <?php
                          $ri = $terbesar($baris['id']);
                          $dua = $inputRi($ri['max'], $baris['id']);
                          echo number_format($ri['max'], 4, '.', ',');?>
                        </td>
                        <td>
                          <?php
                            $maxSi = $utility($baris['id']);
                            $maxRi = $regret($baris['id']);
                            $minSi = $utility($baris['id']);
                            $minRi = $regret($baris['id']);

                            // echo "Si1 : ";print_r($si['jumlah']);
                            // echo " || Si2 : ";print_r($baris['si']);
                            // echo " || MinSi : ";print_r($minSi['smallest']);
                            // echo " || MaxSi : ";print_r($maxSi['largest']);
                            //
                            // echo " || Ri : ";print_r($ri['max']);
                            // echo " || MinRi : ";print_r($minRi['smallest']);
                            // echo " || MaxRi : ";print_r($maxRi['largest']);
                            // exit;

                            $qi = (0.5*(($baris['si']-$minSi['smallest'])/($maxSi['largest']-$minSi['smallest'])))+((1-0.5)*(($ri['max']-$minRi['smallest'])/($maxRi['largest']-$minRi['smallest'])));

                            $qii = (0.45*(($si['jumlah']-$minSi['smallest'])/($maxSi['largest']-$minSi['smallest'])))+((1-0.45)*(($ri['max']-$minRi['smallest'])/($maxRi['largest']-$minRi['smallest'])));
                            $qiii = (0.55*(($si['jumlah']-$minSi['smallest'])/($maxSi['largest']-$minSi['smallest'])))+((1-0.55)*(($ri['max']-$minRi['smallest'])/($maxRi['largest']-$minRi['smallest'])));
                            echo number_format($qi, 4, '.', ',');

                            $tiga = $inputQi($qi, $qii, $qiii, $baris['id']);
                          ?>
                        </td>
                        <td><?= number_format($qii, 4, '.', ','); ?></td>
                        <td><?= number_format($qiii, 4, '.', ','); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>

                  <tfoot>
                    <tr class="info">
                      <th>Maksimal</th>
                        <td><?= number_format($maxSi['largest'], 4, '.', ','); ?></td>
                        <td><?= number_format($maxRi['largest'], 4, '.', ','); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="info">
                      <th>Minimal</th>
                        <td><?= number_format($minSi['smallest'], 4, '.', ','); ?></td>
                        <td><?= number_format($minRi['smallest'], 4, '.', ','); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                  </tfoot>
                </table>

          </div>
      </div>
  </div>
</div>
