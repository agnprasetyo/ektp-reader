<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AnalisaMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$session = Yii::$app->session;

$_width = 100 / 4;
$css = <<< CSS
.wizard > .steps > ul > li {
    width: {$_width}%;
}
@media (max-width: 512px) {
    .wizard > .steps > ul > li {
        width: 100%;
    }
}
CSS;
$this->registerCss($css);

$this->title = 'Analisa Mahasiswa';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uMahasiswa = Url::to(['/data-mahasiswa/index']);
$uImport = Url::toRoute(['import', 'jk' => Yii::$app->request->get('jk')]);
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
                            <li class="breadcrumb-item"><a href="{$uMahasiswa}">Data Mahasiswa</a></li>
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
                <?php

                $numb = [
                    'one', 'two', 'three', 'four', 'five',
                ];

                foreach ([
                    'Import Nilai Mahasiswa',
                    'Mulai Analisa',
                    'Hitung Indeks',
                    'Perangkingan',
                    'Pembuktian',
                ] as $key => $label) {
                    echo Html::a($label, $session['regist'][$numb[$key]]['tab']['href'], [
                        'class' => $session['regist'][$numb[$key]]['tab']['class'],
                        'readonly' => $session['regist'][$numb[$key]]['tab']['disabled'],
                        'disabled' => $session['regist'][$numb[$key]]['tab']['disabled'],
                    ]);
                }
                ?>

            </div>

        </div>
    </div>
</div>

<?php echo $this->render("_{$data['form']}", [
    'model' => $model,
    'data' => $data,
    'other' => $other,
]) ?>