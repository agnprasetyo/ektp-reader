<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('@themes', dirname(dirname(__DIR__)) . '/themes');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');


use yii\helpers\VarDumper;

/**
 * Extends VarDumper::dump() yii2
 *
 * @param mixed $var
 * @return void
 */
function dd($var)
{
    VarDumper::dump($var, 100, true);
    exit;
}

/**
 * @param mixed $var
 * @param bool $exit
 * @return void
 */
function pp($var, $exit = false)
{
    echo "<pre style='padding: 28px;'>";
    print_r($var);
    echo "</pre>";

    if ($exit) {
        exit;
    }
}
