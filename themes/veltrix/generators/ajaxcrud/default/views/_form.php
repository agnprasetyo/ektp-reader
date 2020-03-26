<?php
/**
 * @link      https://www.diecoding.com/
 * @author    Die Coding (Sugeng Sulistiyawan) <diecoding@gmail.com>
 * @copyright Copyright (c) Die Coding - Digital Startup Indonesia
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<?php echo "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "<?php echo " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>

<?php echo '<?php if (!Yii::$app->request->isAjax) { ?>'."\n"?>
    <div class="form-group mt-4 mb-0">
        <?php echo "<?php echo " ?>Html::submitButton('<i class="mdi mdi-content-save-move mr-2"></i> Simpan Data', ['class' => 'btn btn-primary btn-icon']) ?>
    </div>
<?php echo "<?php } ?>\n"?>

<?php echo "<?php " ?>ActiveForm::end(); ?>
