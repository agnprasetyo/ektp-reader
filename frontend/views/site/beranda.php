<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Profil';
$home = Yii::$app->homeUrl;

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
                    <img src="<?php echo Url::base(true) ?>/images/og.png" alt="" style="margin: auto; width: 50%; ">
                </div>
                <div class="card col-md-9">
                    <div class="card-body">
                        <label for="url">NAMA :</label>
                        <p>
                            <?= $datauser->username ?>
                        </p>
                        <label for="url">URL PORT :</label>
                        <p>
                            <?= $tools->port ?>
                        </p>
                        <label for="url">SERIAL ALAT:</label>
                        <p>
                            <?= $tools->serial ?>
                        </p>
                        <label for="url">TEMPAT ALAT:</label>
                        <p>
                            <?= $tools->tempat ?>
                        </p>


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