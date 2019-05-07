<?php

namespace app\controllers;

use app\models\User;
use app\modules\admin\models\Category;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\Recipe;
use app\rbac\Rbac;

class SiteController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout',],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())){
            if ($user = $model->signup()){
                if (Yii::$app->getUser()->login($user)){
                    Yii::$app->session->setFlash('success', "Запит для реєстрації користувача надіслано!");
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup',compact('model'));
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * @param string|null $slug
     * @return string
     */
    public function actionIndex(string $slug = null)
    {
        if (Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)) {
            $this->layout = '@app/modules/admin/views/layouts/main.php';
        }

        $category = Category::findOne(['slug' => $slug]);

        $recipe = Recipe::find()
            ->where(['status'=>User::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC]);

        if ($category) {
            $recipe->andWhere(['category_id' => $category->id]);
            $this->setMetaTag($category->meta_description, $category->meta_keywords);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $recipe,
            'pagination' => [
                'pageSize' => 25,
            ]
        ]);


        return $this->render('index',
            [
                'category' => $category,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Recipe model.
     * @return mixed
     */

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Перевірте свою електронну пошту для подальших інструкцій.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'На жаль, ми не можемо скинути пароль для наданої почти.');
            }
        }

        return $this->render('passwordResetRequestForm',compact('model'));
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPasswordForm($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render('resetPasswordForm',compact('model'));
    }
}
