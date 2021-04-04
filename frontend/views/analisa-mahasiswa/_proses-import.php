<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;
use mdm\admin\components\RouteRule;
use mdm\admin\AutocompleteAsset;
use yii\helpers\Json;
use mdm\admin\components\Configs;
use yii\helpers\Url;


AutocompleteAsset::register($this);
$this->registerJs($js);

$this->title = "Proses Import";

// $this->params['use-header'] = false;

$count     = count($modelImport);
$min       = min(array_keys((array) $modelImport));
$max       = max(array_keys((array) $modelImport));
$modelJson = Json::encode($modelImport);

$url = Url::toRoute(['proses-import', 'update' => $update, 'inc' => '']);
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
	tr.addClass('table-primary');
	tr[0].childNodes[1].innerHTML = '<span class="badge badge-primary">Dalam Proses</span>';

	$.post( "$url" + key, {
		data: model[key]
	}).done(function( data ) {

        console.log(data);

		tr.removeClass('table-primary');
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
        }
	});
}
JS;
$this->registerJs($js);

?>

<h1 class="h3 mb-1 text-gray-800"><?php echo Yii::t("app", "Import Data {0}", [$data["title"]]) ?></h1>

<div class="content-body">
    <div class="action-btns text-right">
        <div class="mb-2">
            <?php echo Html::a(
                '<i class="mdi mdi-arrow-left mr-1"></i> ' . Yii::t("app", "Kembali"),
                ['index'],
                [
                    'class' => 'btn btn-dark',
                ]
            ) ?>
        </div>
    </div>


    <div class="row my-4">
        <div class="col-md-3 col-sm-6 col-xs-12">

            <div class="card border-left-primary shadow h-100 py-2">
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

            <div class="card border-left-danger shadow h-100 py-2">
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

            <div class="card border-left-warning shadow h-100 py-2">
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

            <div class="card border-left-success shadow h-100 py-2">
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>#</th>
                                    <th>STATUS</th>
                                    <th>NAME</th>
                                    <th>DESCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($modelImport as $key => $data) {
                                    $i = $key;
                                    echo "<tr id='tr{$key}' scope='row'>";
                                    echo "<td>{$i}</td>";
                                    echo "<td><span class='badge badge-info'>Menunggu...</span></td>";
                                    foreach ($data as $value) {
                                        echo "<td>{$value}</td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
