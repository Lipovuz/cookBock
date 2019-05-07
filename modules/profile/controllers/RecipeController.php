<?php

namespace app\modules\profile\controllers;

use app\controllers\BaseController;
use app\rbac\Rbac;
use function Couchbase\defaultDecoder;
use Yii;
use app\models\Recipe;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\web\UploadedFile;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends BaseController
{
    public $layout;


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (\Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)) {
            $this->layout = '@app/modules/admin/views/layouts/main.php';
            return $this->layout;
        }
        $this->layout = '@app/views/layouts/main.php';

        return $this->layout;
    }

    public function actionView($recipe_slug)
    {
        if (Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)) {
            $this->layout = '@app/modules/admin/views/layouts/main.php';
        }

        $model = $this->findModelBySlug($recipe_slug);
        $this->setMetaTag($model->meta_description,$model->meta_keywords);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Lists all Recipe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Recipe::find()->orderBy('status'),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        return $this->render('index', compact('dataProvider'));
    }

    public function actionProfile()
    {
        $user_id=Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Recipe::find()->where(['user_id'=>$user_id]),]);
        $model =  User::find()->where(['id'=>$user_id])->one();

        return $this->render('profile', compact('model','dataProvider'));
    }

    /**
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Recipe();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->preview = UploadedFile::getInstance($model, 'preview');
            if(!empty($model->preview))
            {
                $model->preview->saveAs('img/preview_'.$model->id.'.'.$model->preview->extension);
                $model->preview = 'preview_'.$model->id.'.'.$model->preview->extension;
                $model->save();
            }
            return $this->redirect(['profile', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->setMetaTag($model->meta_description,$model->meta_keywords);
        $model->status = User::STATUS_WORKED;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->preview = UploadedFile::getInstance($model, 'preview');
            if(!empty($model->preview))
            {
                $model->preview->saveAs('img/preview_'.$model->id.'.'.$model->preview->extension);
                $model->preview = 'preview_'.$model->id.'.'.$model->preview->extension;

                $model->save();
            }
            if (Yii::$app->user->can(Rbac::ROLE_ADMIN)) {
                return $this->redirect(['index', 'id' => $model->id]);
            }else{
                return $this->redirect(['profile', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionImageDelete($id)
    {
        $model = $this->findModel($id);
        unlink('img/'.$model->preview);
        $model->preview = null;
        $model->save() ;
        return $this->redirect(['update','id'=>$id]);
    }

    /**
     * Deletes an existing Recipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->preview !== null & $model->preview !== '')
        unlink('img/'.$model->preview);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
