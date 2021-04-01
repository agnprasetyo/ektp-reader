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
<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body"> -->

                <!-- <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <a href="halo">
                            <div class="card mini-stat bg-primary text-white">
                                <div class="card-body">
                                    <div class="">
                                        <div class="float-right mini-stat-img ml-4">
                                            <img src="<?php echo "icon" ?>" alt="">
                                        </div>
                                        <h5 class="font-14 text-uppercase mt-0 text-white-50"><?php echo "label" ?></h5>
                                        <h4 class="font-30 font-500 mb-0 text-white">

                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> -->
                <!-- end row -->

                <div class="card-deck-wrapper mb-4">
                    <div class="card-deck">
                        <div class="card col-xl-6 col-md-6 col-sm-12">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Statistik</h4>
                                <nav>
                                    <div class="nav nav-tabs tab-wid recent-stock-widget nav-justified" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-comp-tab" data-toggle="tab" href="#nav-comp" role="tab" aria-controls="nav-comp" aria-selected="true">
                                            <i class="dripicons-heart h4 product-icon"></i>
                                            <p class="text-muted mb-0">Aktif</p>
                                        </a>
                                        <a class="nav-item nav-link" id="nav-laptop-tab" data-toggle="tab" href="#nav-laptop" role="tab" aria-controls="nav-laptop" aria-selected="false">
                                            <i class="dripicons-warning h4 product-icon"></i>
                                            <p class="text-muted mb-0">Tidak Aktif</p>
                                        </a>
                                    </div>
                                </nav>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-comp" role="tabpanel" aria-labelledby="nav-comp-tab">
                                        <div class="text-center">
                                            <div id="radial-chart"></div>
                                            <h5 class="font-18">Aktif</h5>
                                            <p class="text-muted mb-0">
                                              data1
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-laptop" role="tabpanel" aria-labelledby="nav-laptop-tab">
                                        <div class="text-center">
                                            <div id="radial-chart-2"></div>
                                            <h5 class="font-18">Tidak Aktif</h5>
                                            <p class="text-muted mb-0">
                                              data2
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card col-xl-6 col-md-6 col-sm-12">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Statistik Aktivitas</h4>
                                <div id="multiple-radial-chart" class="chart-hide-xs" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Grafik</h4>
                                <div id="world-map-markers" class="vector-map-height"></div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            <!-- </div>
        </div>
    </div>
</div> -->
