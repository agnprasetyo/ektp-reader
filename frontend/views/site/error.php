<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
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
                            <li class="breadcrumb-item"><a href="{$home}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active">Error</li>
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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger bg-danger text-white" role="alert">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="mdi mdi-block-helper display-4"></i>
                        </div>
                        <h4 class="alert-heading font-18"><?php echo $this->title ?></h4>
                        <p><?php echo YII_DEBUG ? nl2br(Html::encode($message)) : '' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
