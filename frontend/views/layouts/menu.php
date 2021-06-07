<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\AuthAssign;

?>

<!-- MENU Start -->
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li>
                    <a href="<?php echo Url::toRoute(['/']) ?>">
                        <i class="mdi mdi-home"></i>
                        Beranda
                    </a>
                </li>

                <?php if (Yii::$app->assign->hasAssign(AuthAssign::ADMINISTRATOR)) { ?>
                    <li>
                        <a href="<?php echo Url::toRoute(['/data-mahasiswa/reader']) ?>">
                            <i class="mdi mdi-drawing"></i>
                            Registrasi
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo Url::toRoute(['/data-kriteria']) ?>">
                            <i class="mdi mdi-receipt"></i>
                            Kriteria
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Url::toRoute(['/data-mahasiswa']) ?>">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            Mahasiswa
                        </a>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-cogs"></i>
                            Setting
                            <i class="mdi mdi-chevron-down mdi-drop"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="<?php echo Url::toRoute(['/tools']) ?>">Reader</a></li>
                            <li><a href="<?php echo Url::toRoute(['/nilai']) ?>">Nilai</a></li>
                            <li><a href="<?php echo Url::toRoute(['/konversi-nilai']) ?>">Konversi Nilai</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->
