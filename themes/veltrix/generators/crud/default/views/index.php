<?php
/**
 * @link      https://www.diecoding.com/
 * @author    Die Coding (Sugeng Sulistiyawan) <diecoding@gmail.com>
 * @copyright Copyright (c) Die Coding - Digital Startup Indonesia
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$titleName = StringHelper::basename($generator->titleName);

echo "<?php\n\n";

?>
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use diecoding\widgets\BulkButtonWidget;

$this->title = '<?php echo $titleName ?>';

$uHome = Url::base(true);
$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <h4 class="page-title">{$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active">Data {$this->title}</li>
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
            <div class="card-body">
                <?php echo "<?php " ?>$form = ActiveForm::begin([
                    'action' => [''],
                    'method' => 'get',
                ]); ?>
                    <div class="form-group mb-0">
                        <label>Cari Data</label>
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" placeholder="kata kunci.." aria-describedby="project-search-addon" name="q" value="<?= '<?php ' ?>echo Yii::$app->request->get('q') ?>">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="mdi mdi-magnify search-icon font-12"></i></button>
                            </div>
                        </div>
                    </div>
                <?php echo "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">                
                <div class="row mt-2 mb-4">
                    <div class="col-xl-8 col-md-8">
                        <h4 class="mt-0 header-title mb-4">Daftar Data <?php echo '<?php echo Html::encode($this->title) ?>' ?></h4>
                    </div>
                    
                    <div class="col-xl-4 col-md-4 text-sm-right">
                        <?php echo "<?php echo " ?>Html::a('<i class="mdi mdi-gamepad-round-outline ml-2 mr-2"></i> Tambah Data', ['create'], 
                        [
                            'class' => 'btn btn-primary btn-icon',
                            'role'  => 'modal-remote',
                        ]) ?>
                    </div>
                </div>

                <hr>

                <?= "<?php " ?>echo GridView::widget([
                    'id' => 'crud-datatable',
                    'dataProvider' => $dataProvider,
<?= !empty($generator->searchModelClass) ? "                        'filterModel' => \$searchModel,\n" : "" ?>
                    'pjax' => true,
                    'striped' => false,
                    'condensed' => false,
                    'bordered' => false,
                    'responsive' => true,
                    'hover' => true,
                    'responsiveWrap' => false,
                    'export' => [
                        'showConfirmAlert' => false,
                    ],
                    'toolbar' => [
                        [
                            'content' => Html::a(
                                '<i class="mdi mdi-reload"></i>',
                                [''],
                                [
                                    'title' => 'Reset Grid',
                                    'data-pjax' => 1,
                                    'class' => 'btn btn-outline-secondary',
                                ]
                            ) .
                            '{toggleData}' .
                            '{export}'
                        ],
                    ],
                    'panelPrefix' => false,
                    'panel' => [
                        'options' => [
                            'style' => 'margin: 0 -1.25rem;',
                        ],
                        'headingOptions' => [
                            'class' => '',
                            'style' => 'padding: 0 1.25rem;',
                        ],
                        'footerOptions' => [
                            'class' => '',
                            'style' => 'padding: 1rem 1.25rem;',
                        ],
                        'beforeOptions' => [
                            'style' => 'padding: 1rem 1.25rem;',
                        ],
                        'after' => '',
                    ],
                    'columns' => require(__DIR__ . '/_columns.php'),
                ]); ?>
            </div>
        </div>
    </div>
</div>
