<?php
/**
 * @link http://www.diecoding.com/
 * @author Die Coding (Sugeng Sulistiyawan) <diecoding@gmail.com>
 * @copyright Copyright (c) 2018
 */

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator themes\veltrix\generators\crud\Generator */

echo '<h3>General Configuration</h2>';
echo $form->field($generator, 'titleName');
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
