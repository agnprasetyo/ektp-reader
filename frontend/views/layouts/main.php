<?php

use diecoding\helpers\Date;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\AppAsset::register($this);
\diecoding\toastr\ToastrFlash::widget();

\diecoding\DiecodingAsset::register($this);

$themeConfig = new \diecoding\components\ThemeConfig();
$themeUrl = $themeConfig->getPublishedUrl("veltrix");

// print_r(md5(Date::currentDate("Y-m-d") . "simpeg"));
// exit;

// echo "<pre>";print_r(Yii::getAlias("@tests"));exit;
// echo "<pre>";print_r(Yii::$app->assetManager->bundles);exit;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<head lang="<?php echo Yii::$app->language ?>">
    <meta charset="<?php echo Yii::$app->charset ?>" />
    <?php echo Html::csrfMetaTags() ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>
        <?php
        $title = isset($this->title) ? Html::encode($this->title) . ' &mdash; ' . Yii::$app->name : Yii::$app->name;
        echo $title;
        ?>
    </title>
    <link rel="shortcut icon" href="<?php echo Url::base(true) ?>/images/favicon.png">

    <link href="<?php echo $themeUrl ?>/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themeUrl ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themeUrl ?>/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themeUrl ?>/css/style.css" rel="stylesheet" type="text/css">

    <script src="<?php echo $themeUrl ?>/js/jquery.min.js"></script>

    <?php $this->head() ?>


    <script data-pace-options='{ "ajax": false }' src="<?php echo (YII_ENV_DEV ? Url::to(['/plugins/pace/pace.js']) : Url::to(['/plugins/pace/pace.min.js'])) ?>"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="header-bg" >
        <?php echo $this->render('navbar.php') ?>
        <?php echo @$this->params['header-block'] ?>
    </div>
    <!-- end header-bg -->

    <!-- page wrapper start -->
    <div class="wrapper" style="background: url(https://files.diecoding.com/assets/images/pattern/symphony.png) fixed; min-height: 659px;">

        <div id="main--loader" class="container-fluid" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <div class="loading text-center">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-warning" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-danger" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="main--content" class="container-fluid">
            <?php echo $content ?>
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- page wrapper end -->

    <?php echo $this->render('footer.php') ?>

    <?php

    Modal::begin([
        "id"     => "actCreateModal",
        "title"  => "",
        "footer" => "",
    ]);

    Modal::end();

    Modal::begin([
        "id"     => "ajaxCrudModal",
        "title"  => "",
        "footer" => "",
    ]);

    Modal::end();

    ?>

    <script src="<?php echo Yii::$app->themeConfig->getPublishedUrl("veltrix") ?>/plugins/sweet-alert2/sweetalert2.min.js"></script>

    <?php $this->endBody() ?>
    <script src="<?php echo $themeUrl ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $themeUrl ?>/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $themeUrl ?>/js/waves.min.js"></script>
    <script src="<?php echo (YII_ENV_DEV ? Url::to(['/js/app.js']) : Url::to(['/js/app.min.js'])) ?>"></script>
</body>

</html>
<?php $this->endPage() ?>
