<?php

use diecoding\helpers\Date;
use kartik\ipinfo\IpInfo;
use yii\helpers\Html;

$this->title = 'Profil';
$home = Yii::$app->homeUrl;

// $appName = Yii::$app->user->setup->getConfig('name', 'app', Yii::$app->name[0]);
// $appUnit = Yii::$app->user->setup->getConfig('unit', 'app', Yii::$app->name[1]);
$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <h4 class="page-title text-uppercase">{$this->title}</h4>
                        <ol class="breadcrumb">
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

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card-deck-wrapper">
            <div class="card-deck">
                <div class="card col-md-3 p-2">
                </div>
                <div class="card col-md-9">
                    <div class="card-body">


                        <p class="card-text mt-2">
                            <small class="text-muted">
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
