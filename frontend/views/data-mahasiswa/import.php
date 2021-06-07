<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\NilaiAwal */

$this->title = 'Import Data Mahasiswa';

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
                        <h4 class="page-title">Form {$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item"><a href="{$uIndex}">Data Mahasiswa</a></li>
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

<?php if (empty($other)) { ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
                    ]); ?>

                    <div class="col-md-12">
                        <?php
                        // echo '<label class="control-label">Select Document</label>';
                        echo $form->field($model, 'file')->widget(\diecoding\dropify\Dropify::className());
                        ?>
                    </div>

                    <div class="form-group mt-4 mb-0 text-right">
                        <!-- <hr class="my-4"> -->
                        <?php echo Html::submitButton('<i class="mdi mdi-content-save-move"></i> ' . Yii::t("app", "Simpan Data"), ['class' => 'btn btn-primary btn-icon']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>

<?php } else {

    $_other = $other;
    unset($_other[0]);

    $headings = $other[0];
    array_walk(
        $_other,
        function (&$row) use ($headings) {
            $row = array_combine($headings, $row);
        }
    );

    // dd($row);

    // dd($_other);

    $count     = count($_other);
    $min       = min(array_keys((array) $_other));
    $max       = max(array_keys((array) $_other));
    $modelJson = Json::encode($_other);

    $url = Url::toRoute(['proses-import', 'inc' => '']);
    $js = <<< JS
var model   = $modelJson,
    max     = $max,
    min     = $min,
    count   = $count,
    proses  = 0,
    success = 0,
    warning = 0,
    error   = 0;

generate(model, max, min);

function generate(model, max, key)
{
    proses++;

    tr = $("#tr" + key);
    tr.addClass('table-warning');
    tr[0].childNodes[1].innerHTML = '<span class="badge badge-warning">Dalam Proses</span>';

    $.post( "$url" + key, {
        data: model[key]
    }).done(function( data ) {

        console.log(data);

        tr.removeClass('table-warning');
        tr.addClass("table-" + data['data']['class']);
        tr.html(data['data']['html']);

        if (data['data']['class'] === 'danger') {
            error++;
        } else if (data['data']['class'] === 'success') {
            success++;
        } else if (data['data']['class'] === 'warning') {
            warning++;
        }

        $("#proses").html(proses + ' / ' + count + ' <small>Data</small>');
        $("#error").html(error + ' <small>Data</small>');
        $("#warning").html(warning + ' <small>Data</small>');
        $("#success").html(success + ' <small>Data</small>');

        if (max >= (key + 1)) {
            generate(model, max, key + 1);
        } else {
            // $(".--floating-container").show();

            // $(".--floating-container").click(function () {
            //     $(".--floating-container").hide();
            // });
        }
    });
}
JS;
    $this->registerJs($js);

?>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <div id="--content">
                        <?php echo Html::a("<i class='fa fa-upload mr-2'></i> Import File Kembali", [''], [
                            "class" => "btn btn-success mb-4",
                        ]) ?>

                        <div class="row my-4">
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <div class="card border-left-primary shadow py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Terproses
                                                </div>
                                                <div id="proses" class="h5 mb-0 font-weight-bold text-gray-800">
                                                    0 / <?php echo $count ?> <smal>Data</smal>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <div class="card border-left-danger shadow py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    Error
                                                </div>
                                                <div id="error" class="h5 mb-0 font-weight-bold text-gray-800">
                                                    0 / <?php echo $count ?> <smal>Data</smal>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-ban fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <div class="card border-left-warning shadow py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Peringatan
                                                </div>
                                                <div id="warning" class="h5 mb-0 font-weight-bold text-gray-800">
                                                    0 / <?php echo $count ?> <smal>Data</smal>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <div class="card border-left-success shadow py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Sukses
                                                </div>
                                                <div id="success" class="h5 mb-0 font-weight-bold text-gray-800">
                                                    0 / <?php echo $count ?> <smal>Data</smal>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>STATUS</th>

                                        <?php

                                        foreach ($other[0] as $key => $value) {
                                            $value = strtoupper($value);
                                            echo "<th>{$value}</th>";
                                        } ?>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    foreach ($other as $key => $value) {
                                        if ($key > 0) {
                                            echo "<tr id='tr{$key}' class='table-info'>";

                                            echo "<td>{$key}</td>";
                                            echo "<td><span class='badge badge-info'>Menunggu...</span></td>";
                                            foreach ($value as $key1 => $value1) {
                                                echo "<td>{$value1}</td>";
                                            }
                                            echo "</tr>";
                                        }
                                    } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

<?php } ?>