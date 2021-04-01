<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <a href="<?php echo Url::toRoute(['/']) ?>" class="logo">
                    <img src="<?php echo Url::base(true) ?>/images/logo-sm.png" alt="" class="logo-small" style="height: 36px;">
                    <img src="<?php echo Url::base(true) ?>/images/logo-light.png" alt="" class="logo-large" style="height: 36px;">
                </a>
            </div>
            <!-- End Logo container-->

            <div class="menu-extras topbar-custom">

                <ul class="navbar-right list-inline float-right mb-0">

                    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                        <?php
                        $js = <<< JS

var content = $("#main--content");
var loader  = $("#main--loader");
$("#input-search-sys").keyup(function() {
    if ($("#input-search-sys").val()) {
        content.hide();
        loader.show();
    } else {
        content.show();
        loader.hide();
    }
});
$("#input-search-sys").change(function() {
    if ($("#input-search-sys").val()) {
        $("#form-search-sys").submit();
    } else {
        content.show();
        loader.hide();
    }
});
JS;
                        $this->registerJs($js);
                        $form = ActiveForm::begin([
                            'id'      => 'form-search-sys',
                            'action'  => Url::current(['q' => null]),
                            'method'  => 'get',
                            'options' => [
                                'class' => 'app-search',
                                'role'  => 'search',
                            ],
                        ]); ?>
                        <div class="form-group mb-0">
                            <input id="input-search-sys" type="text" class="form-control" placeholder="Search.." aria-describedby="project-search-addon" name="q" value="<?php echo Yii::$app->request->get('q') ?>">
                            <button type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </li>

                    <!-- full screen -->
                    <li class="dropdown notification-list list-inline-item d-none d-md-inline-block" data-toggle="tooltip" data-placement="bottom" title="Fullscreen">
                        <a class="nav-link" href="#" id="btn-fullscreen">
                            <i class="mdi mdi-crop-free noti-icon"></i>
                        </a>
                    </li>

                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <li class="dropdown notification-list list-inline-item">
                            <div class="dropdown notification-list nav-pro-img">
                                <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="..." alt="user" class="rounded-circle" style="background-color: rgba(255,255,255,.05);">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <a class="dropdown-item" href="<?php echo Url::toRoute(['/site/profil']) ?>">
                                        <i class="mdi mdi-account-circle"></i> Profil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" data-method="post" href="<?php echo Url::toRoute(['/site/logout']) ?>">
                                        <i class="mdi mdi-power text-danger"></i>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="dropdown notification-list list-inline-item" data-toggle="tooltip" data-placement="bottom" title="Login">
                            <a class="nav-link" href="<?php echo Url::toRoute(['/site/login']) ?>" role="button">
                                <i class="mdi mdi-login noti-icon"></i>
                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <?php echo $this->render('menu.php') ?>

</header>
<!-- End Navigation Bar-->
