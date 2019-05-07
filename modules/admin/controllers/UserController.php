<?php

namespace app\modules\admin\controllers;

use app\rbac\Rbac;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public $layout;


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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy('status'),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->img = UploadedFile::getInstance($model, 'img');
            if(!empty($model->img))
            {
                $model->img->saveAs('img/blog_'.$model->id.'.'.$model->img->extension);
                $model->img = 'blog_'.$model->id.'.'.$model->img->extension;
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }


    public function actionUpdate($id)
    {
        if (Yii::$app->user->can(Rbac::ROLE_USER)){
            $this->layout = '@app/views/layouts/main';
        }
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->img = UploadedFile::getInstance($model, 'img');
            if(!empty($model->img))
            {
                $model->img->saveAs('img/blog_'.$model->id.'.'.$model->img->extension);
                $model->img = 'blog_'.$model->id.'.'.$model->img->extension;

                $model->save();
            }
            if (Yii::$app->user->can(Rbac::ROLE_ADMIN)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->redirect(['/profile/recipe/profile']);
            }
        }

        return $this->render('update', [
            'model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionImageDelete($id)
    {
        $model = $this->findModel($id);
        unlink('img/'.$model->img);
        $model->img = null;
        $model->save();
        $this->redirect(['update','id'=>$id]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
