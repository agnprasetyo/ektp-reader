<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AnalisaKriteria */

\yii\web\YiiAsset::register($this);

$this->title = 'Hasil Analisa Kriteria';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uKriteria = Url::to(['/data-kriteria/index']);
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
                            <li class="breadcrumb-item"><a href="{$uKriteria}">Data Kriteria</a></li>
                            <li class="breadcrumb-item"><a href="{$uIndex}">Analisa Kriteria</a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>
                    <div class="col-sm-3">
                        <div class="float-right d-none d-md-block">
                            <a href="{$uBack}" class="btn btn-danger">
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
          				<strong style="font-size:18pt;"><span class="fa fa-table"></span> Perbandingan Kriteria</strong>
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
                    <th>Antar Kriteria</th>
                    <?php foreach ($query as $key => $value) { ?>
                      <th><?=$value['nama_kriteria'] ?></th>
                    <?php } ?>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($query as $key => $baris) { ?>
                  <tr>
                    <th class="active"><?=$baris['nama_kriteria'] ?></th>
                      <?php foreach ($query as $key => $kolom) { ?>
                      <td>
                        <?php
        								if ($baris['id_kriteria'] == $kolom['id_kriteria']) {
                          $data = $getTabel($baris['id_kriteria'], $kolom['id_kriteria']);
                          echo number_format($data['nilai_analisa_kriteria'], 4, '.', ',');
                      	} else {
                          $data = $getTabel($baris['id_kriteria'], $kolom['id_kriteria']);
                          echo number_format($data['nilai_analisa_kriteria'], 4, '.', ',');
                      	}
                      	?>
                      </td>
                      <?php } ?>
                  </tr>
                  <?php } ?>
                </tbody>
          			<tfoot>
          				<tr class="info">
          					<th>Jumlah</th>
                    <?php foreach ($query as $key => $value) { ?>
                      <th>
                        <?php
                          $jumlah = $jumlahKolom($value['id_kriteria']) ;
                          echo number_format($jumlah['jumlah'], 4, '.', ',');
                        ?>
                      </th>
                    <?php } ?>
          				</tr>
          			</tfoot>
              </table>

          		<table width="100%" class="table table-striped table-bordered">
          			<thead>
          				<tr>
          					<th>Perbandingan</th>
                    <?php foreach ($query as $key => $value) { ?>
                      <th><?=$value['nama_kriteria'] ?></th>
                    <?php } ?>
          				</tr>
          			</thead>
                <tbody>
                  <?php foreach ($query as $key => $baris): ?>
                  <tr>
                    <th class="active"><?=$baris['nama_kriteria'] ?></th>
                      <?php foreach ($query as $kolom): ?>
                      <td>
                        <?php
                        if ($baris['id_kriteria'] == $kolom['id_kriteria']) {
                          $data = $getTabel($baris['id_kriteria'], $kolom['id_kriteria']);
                          $hasil = $data['nilai_analisa_kriteria']/$kolom['jumlah_kriteria'];
                          echo number_format($hasil, 4, '.', ',');
                        } else {
                          $data = $getTabel($baris['id_kriteria'], $kolom['id_kriteria']);
                          $hasil = $data['nilai_analisa_kriteria']/$kolom['jumlah_kriteria'];
                          echo number_format($hasil, 4, '.', ',');
                        }
                        ?>
                      </td>
                      <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
                </tbody>
          		</table>

          		<table width="100%" class="table table-striped table-bordered">
          			<thead>
          				<tr>
          					<th>Rasio Konsistensi</th>
          					<th class="success">Prioritas</th>
          					<th class="info">Ax</th>
          					<th class="success">SigmaLamda</th>
          				</tr>
          			</thead>
          			<tbody>
          				<?php $total=0; foreach ($query as $baris) { ?>
          					<tr>
          						<th class="active"><?=$baris["nama_kriteria"]?></th>
          						<th class="success">
          							<?php
                          $rata = $avg($baris['id_kriteria']);
                          echo number_format($rata['avg'], 4, '.', ',');
                        ?>
          						</th>
          						<th class="info">
                        <?php
                            $hasil = 0;
                            foreach ($query as $key => $kolom) {
                                $data = $getTabel($baris['id_kriteria'], $kolom['id_kriteria']);
                                $rata = $avg($query[$key]['id_kriteria']);

                                $hasil += $data['nilai_analisa_kriteria'] * $rata['avg'];
                            }
                            echo number_format($hasil, 4, '.', ',');
                        ?>

                      </th>
          						<th class="success">
                        <?php
                          $rata = $avg($baris['id_kriteria']);
                          $sigma =  $hasil / $rata['avg'];
                          echo number_format($sigma, 4, '.', ',');
                          $total += $sigma;

                        ?>
                      </th>
          					</tr>
          				<?php } ?>
          			</tbody>
          			<tfoot>
          				<tr class="danger">
          					<th colspan="3">Rata-rata</th>
          					<th>
                      <?php
                        $count = count($query);
                        $lamdaMaks = $total/$count;
                        echo number_format($lamdaMaks, 4, '.', ',');
                      ?>
                    </th>
          				</tr>
          			</tfoot>
          		</table>

              <table width="100%" class="table table-striped table-bordered">
          			<tbody>
          				<tr>
          					<th>N (kriteria)</th>
          					<td><?=$count?></td>
          				</tr>
          				<!-- <tr>
          					<th>Hasil Akhir (X maks)</th>
          					<td><?php //echo number_format($rata, 4, '.', ',');?></td>
          				</tr> -->
          				<tr>
          					<th>IR</th>
          					<td><?= $ir = $getIr($count); ?></td>
          				</tr>
          				<tr>
          					<th>CI</th>
                    <td><?php $ci = ($lamdaMaks-$count)/($count-1); echo number_format($ci, 4, '.', ',');?></td>
          				</tr>
          				<tr>
          					<th>CR</th>
                    <td><?php $cr = $ci/$ir; echo number_format($cr, 4, '.', ',');?></td>
          				</tr>
          			</tbody>
          		</table>
          </div>
      </div>
  </div>
</div>
