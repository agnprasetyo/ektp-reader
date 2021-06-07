<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Registrasi';

$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue/dist/vue.js');
$this->registerJsFile('https://unpkg.com/axios/dist/axios.min.js');
$this->registerJsVar('nikUrl', Url::to(['api/view']));
$this->registerJs($this->render('_index.js', ['tools' => $tools]));

$uHome = Url::base(true);
$uIndex = Url::toRoute(['index', 'jk' => Yii::$app->request->get('jk')]);

$uBack = Yii::$app->request->referrer ?: $uHome;
$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <h4 class="page-title">Form {$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
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

            <div id="app" class="card-deck">
                <div class="card col-md-3 p-5">
                    <label for="url">Status Koneksi dengan Server :</label>
                    <p>{{ statusMessage }}</p>
                </div>
                <div class="card col-md-9">
                    <div class="card-body">
                        <div v-if="errorMessage != ''" class="alert alert-danger">
                            {{ errorMessage }}
                        </div>
                        <table>
                            <tr>
                                <td>
                                    <b>NIK</b>
                                </td>
                                <td> : </td>
                                <td> {{ db.nik }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Nama</b>
                                </td>
                                <td> : </td>
                                <td> {{ db.nama }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>NIM</b>
                                </td>
                                <td> : </td>
                                <td> {{ db.nim }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Prodi</b>
                                </td>
                                <td> : </td>
                                <td> {{ db.jurusan }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Fakultas</b>
                                </td>
                                <td> : </td>
                                <td> {{ db.fakultas }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Status Beasiswa</b>
                                </td>
                                <td> : </td>
                                <td> {{ db.qi }}</td>
                            </tr>
                            

                        </table>

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