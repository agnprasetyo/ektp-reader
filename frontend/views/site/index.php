<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

// $this->title = 'My Yii Application';
$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);

$appName = "SISTEM SELEKSI BEASISWA KIP";
$appUnit = "KEMAHASISWAAN DAN ALUMNI UNS";
$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-12 text-uppercase">
                        <h4 class="page-title">{$appName}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">{$appUnit}</li>
                        </ol>
                    </div>
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

                <!-- <h4 class="mt-0 header-title">Kartu Indonesia Pintar</h4> -->
                <img src="<?php echo Url::base(true) ?>/images/Capture.jpg" alt="" style="margin: auto; width: 100%; ">
                <div id="world-map-markers" class="vector-map-height"></div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- </div>
        </div>
    </div>
</div> -->