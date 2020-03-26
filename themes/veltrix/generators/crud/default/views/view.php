<?php
/**
 * @link http://www.diecoding.com/
 * @author Die Coding (Sugeng Sulistiyawan) <diecoding@gmail.com>
 * @copyright Copyright (c) 2018
 */


use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$titleName = StringHelper::basename($generator->titleName);

echo "<?php\n\n";

?>

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model-><?php echo $nameAttribute ?>;

$uHome = Url::base(true);
$uUpdate = Url::toRoute(['update', <?php echo $urlParams ?>]);
$uIndex = Url::toRoute(['index']);

$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-9">
                        <h4 class="page-title">Data {$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item"><a href="{$uIndex}"><?php echo $titleName ?></a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>

                    <div class="col-sm-3">
                        <div class="float-right d-none d-md-block">
                            <a href="{$uIndex}" class="btn btn-secondary">
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
                <h4 class="mt-0 header-title mb-4">Rincian Data: <?php echo '<?php echo Html::encode($this->title) ?>' ?></h4>
                
                <div class="mt-2 mb-4">
                    <?php echo "<?php echo " ?>Html::a('<i class="mdi mdi-grease-pencil mr-2"></i> Perbarui', ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary btn-icon']) ?>
                    <?php echo "<?php " ?>
                        $hasChilds = false;
                        if (!$hasChilds) {
                            echo Html::a('<i class="mdi mdi-trash-can mr-2"></i> Hapus', ['delete', <?= $urlParams ?>], [
                                'class' => 'btn btn-danger btn-icon',
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                        }
                     ?>
                    <hr>
                </div>

                <div class="table-responsive">
                        <?php echo "<?php echo " ?>DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                    <?php
                    if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        echo "            '" . $name . "',\n";
                    }
                    } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                    }
                                ?>
                            ],
                        ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>