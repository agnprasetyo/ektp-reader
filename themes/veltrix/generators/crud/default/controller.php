<?php
/**
 * @link http://www.diecoding.com/
 * @author Die Coding (Sugeng Sulistiyawan) <diecoding@gmail.com>
 * @copyright Copyright (c) 2018
 */

/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$titleName = StringHelper::basename($generator->titleName);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?php echo StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?php echo ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?php echo ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?php echo ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * <?php echo $controllerClass ?> implements the CRUD actions for <?php echo $modelClass ?> model.
 */
class <?php echo $controllerClass ?> extends <?php echo StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        // 'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    // public function beforeAction($action)
    // {
    //     $this->enableCsrfValidation = false;
    //
    //     return true;
    // }

    /**
     * Lists all <?php echo $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
       <?php if (!empty($generator->searchModelClass)): ?>
 $searchModel = new <?php echo isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?php echo $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }


    /**
     * Displays a single <?php echo $modelClass ?> model.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?php echo $actionParams ?>)
    {
        $request = Yii::$app->request;
        $model = $this->findModel(<?php echo $actionParams ?>);

        return $this->render(
            'view', [
                'model' => $model,
            ]
        );
    }

    /**
     * Creates a new <?php echo $modelClass ?> model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new <?php echo $modelClass ?>();

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', [['Sukses:', 'Berhasil menyimpan data.']]);

                return $this->redirect(['view', <?php echo $urlParams ?>]);
            } else {
                Yii::$app->session->setFlash('error', [['Error:', 'Gagal menyimpan data.']]);
            }
        }

        return $this->render(
            'create', [
                'model' => $model,
            ]
        );

    }

    /**
     * Updates an existing <?php echo $modelClass ?> model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?php echo $actionParams ?>)
    {
        $request = Yii::$app->request;
        $model = $this->findModel(<?php echo $actionParams ?>);

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', [['Sukses:', 'Berhasil memperbarui data.']]);

                return $this->redirect(['view', <?php echo $urlParams ?>]);
            } else {
                Yii::$app->session->setFlash('error', [['Error:', 'Gagal memperbarui data.']]);
            }
        }

        return $this->render(
            'update', [
                'model' => $model,
            ]
        );
    }

    /**
     * Delete an existing <?php echo $modelClass ?> model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?php echo $actionParams ?>)
    {
        $model = $this->findModel(<?php echo $actionParams ?>);
        $hasChilds = false;
        if (!$hasChilds) {            
            $model->delete();
            Yii::$app->session->setFlash('success', [['Sukses:', 'Berhasil menghapus data.']]);
        } else {
            Yii::$app->session->setFlash('error', [['Error:', 'Gagal menghapus data.']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?php echo $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?php echo                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?php echo $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        $model = <?php echo $modelClass ?>::findOne(<?php echo $condition ?>);
        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
