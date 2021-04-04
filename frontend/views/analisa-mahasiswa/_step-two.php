<?php

use common\models\AnalisaAlternatif;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

\yii\web\YiiAsset::register($this);

$this->title = ' Hasil Analisa Alternatif';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uIndex = Url::toRoute(['index', 'jk' => Yii::$app->request->get('jk')]);
$uBack = Yii::$app->request->referrer ?: $uHome;

extract($other);

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

<div class="--floating-container">
	<div class="--floating-row">
		<?php
		echo Html::a("Next <i class='fa fa-arrow-right ml-2'></i>", [''], [
			"class" => "--btn-float btn-primary btn btn-lg",
			"data-method" => "post",
		])
		?>
	</div>
</div>


<?php

$js = <<< JS

		$(".--floating-container").show();

		$(".--floating-container").click(function () {
			$(".--floating-container").hide();
			$("#--content").hide();
			$("#--progress").show();
		});
JS;
$this->registerJs($js);

?>

<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-body">

				<div id="--progress" class="py-4" style="display: none;">
					<div class="progress">
						<div class="progress-bar progress-bar-primary progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
							<span class="sr-only">Loading</span>
						</div>
					</div>
                </div>

				<div id="--content">
					<div class="row">
						<div class="col-md-6 text-left">
							<strong style="font-size:18pt;"><span class="fa fa-table"></span> Alternatif Menurut
								Kriteria</strong>
						</div>
						<div class="col-md-6 text-right">
							<form method="post">
								<button name="hapus" class="btn btn-danger">Hapus Semua Data</button>
							</form>
						</div>
					</div>
					<br />

					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Table 1</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Table 2</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Table 3</a>
						</li>
					</ul>

					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
							<table width="100%" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center active">Alternatif</th>
										<?php

										$header = "";
										$table2 = "";
										foreach ($dataKriteria as $kriteria) {
											$header .= "<th class='text-center'>Kriteria {$kriteria->nama_kriteria}</th>";
										}
										echo $header;

										?>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($dataMahasiswa as $b => $baris) { ?>
										<tr>
											<?php

											$_col1 = "<th>{$baris->nama}</th>";
											echo $_col1;

											$table2 .= "<tr>";
											$table2 .= $_col1;
											foreach ($dataKriteria as $k => $kolom) { ?>
												<td>
													<?php

													$max = (float) AnalisaAlternatif::find()
														->where(['id_kriteria' => $kolom->id_kriteria])
														->max('nilai');

													$min = (float) AnalisaAlternatif::find()
														->where(['id_kriteria' => $kolom->id_kriteria])
														->min('nilai');

													$skor = AnalisaAlternatif::findOne([
														'id_alternatif' => $baris->id,
														'id_kriteria' => $kolom->id_kriteria,
													]);

													$normal = 0;
													if ($max != $min) {
														$normal = ($max - (float) $skor->nilai) / ($max - $min);
													}
													echo number_format($normal, 4, '.', ',');
													$skor->updateAttributes(['bobot' => $normal]);


													// =================================================
													$hasil = (float) $skor->bobot * (float) $kolom->bobot_kriteria;
													$skor->updateAttributes(['normalisasi' => $hasil]);

													$table2 .= "<td>";
													$table2 .= number_format($hasil, 4, '.', ',');
													$table2 .= "</td>";

													?>
												</td>
											<?php }

											$table2 .= "</tr>";
											?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							<table width="100%" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center active">Alternatif</th>
										<?php echo $header ?>
									</tr>
								</thead>
								<tbody>
									<?php echo $table2 ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
							....
						</div>
					</div>
				
				</div>

			</div>
		</div>

	</div>
</div>