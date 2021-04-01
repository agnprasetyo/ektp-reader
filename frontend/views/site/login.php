<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$jk = Yii::$app->request->get('jk');
$uHome = Url::base(true);
$uCreate = Url::toRoute(['create', 'jk' => Yii::$app->request->get('jk')]);

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

<div class="row justify-content-center">
  <!-- <div class="col-6 text-center"> -->
    <div class="card">
      <div class="card-body text-center">
        <div align="center">
          <a href="<?php echo Url::toRoute(['/']) ?>" class="logo">
            <img src="<?php echo Url::base(true) ?>/images/uns.png" alt="" class="logo-small" style="height: 100px;">
          </a>
        </div>
      </div>
      <div class="card-body text-center">
        <p>Sign In untuk masuk</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
        ->field($model, 'username', $fieldOptions1)
        ->label(false)
        ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
        ->field($model, 'password', $fieldOptions2)
        ->label(false)
        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="form-group row">
          <div class="col-sm-8 text-left">
            <div class="custom-control custom-checkbox">
              <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
          </div>
          <div class="col-sm-4 text-right">
            <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
          </div>
        </div>
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="<?php echo \Yii::$app->request->BaseUrl.'/site/signup'?>" class="btn btn-block btn-danger btn-flat">Sign Up</a>
        </div>
        <div style="color:#999;margin:1em 0">
            If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
            <br>
            Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
        </div>
        <?php ActiveForm::end(); ?>

      </div>




      </div>
      <!-- /.login-box-body -->
    <!-- </div> -->
  </div>
</div>
