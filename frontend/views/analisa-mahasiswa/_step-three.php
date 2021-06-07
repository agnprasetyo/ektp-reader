<?php

use common\models\AnalisaAlternatif;
use common\models\DataMahasiswa;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnalisaAlternatif */

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
                        <!-- <div class="col-md-6 text-right">
                            <form method="post">
                                <button name="hapus" class="btn btn-danger">Hapus Semua Data</button>
                            </form>
                        </div> -->
                    </div>
                    <br />

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
                            <?php foreach ($dataMahasiswa as $b => $baris) { ?>
                                <tr>
                                    <th class="active"><?= $baris->nama ?></th>
                                    <td>
                                        <?php

                                        $si = (float) AnalisaAlternatif::find()
                                            ->where(['id_alternatif' => $baris->id])
                                            ->sum('normalisasi');

                                        echo number_format($si, 4, '.', ',');

                                        ?>
                                    </td>
                                    <td>
                                        <?php

                                        $ri = (float) AnalisaAlternatif::find()
                                            ->where(['id_alternatif' => $baris->id])
                                            ->max('normalisasi');

                                        echo number_format($ri, 4, '.', ',');

                                        ?>
                                    </td>
                                    <td>
                                        <?php

                                        $maxSi = (float) DataMahasiswa::find()->max('si');
                                        $maxRi = (float) DataMahasiswa::find()->max('ri');
                                        $minSi = (float) DataMahasiswa::find()->min('si');
                                        $minRi = (float) DataMahasiswa::find()->min('ri');

                                        $qi = $qii = $qiii = 0;
                                        if ($maxSi != $minSi && $maxRi != $minRi) {
                                            $qi = (0.5 * (($si - $minSi) / ($maxSi - $minSi))) + ((1 - 0.5) * (($ri - $minRi) / ($maxRi - $minRi)));

                                            $qii = (0.45 * (($si - $minSi) / ($maxSi - $minSi))) + ((1 - 0.45) * (($ri - $minRi) / ($maxRi - $minRi)));

                                            $qiii = (0.55 * (($si - $minSi) / ($maxSi - $minSi))) + ((1 - 0.55) * (($ri - $minRi) / ($maxRi - $minRi)));
                                        }
                                        echo number_format($qi, 4, '.', ',');

                                        $baris->updateAttributes([
                                            'si' => $si,
                                            'ri' => $ri,
                                            'qi' => $qi,
                                            'qii' => $qii,
                                            'qiii' => $qiii,
                                        ]);
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
                                <td><?= number_format($maxSi, 4, '.', ','); ?></td>
                                <td><?= number_format($maxRi, 4, '.', ','); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="info">
                                <th>Minimal</th>
                                <td><?= number_format($minSi, 4, '.', ','); ?></td>
                                <td><?= number_format($minRi, 4, '.', ','); ?></td>
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
</div>