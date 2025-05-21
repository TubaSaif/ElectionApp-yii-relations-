<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;
use yii\filters\AccessControl;

class AuthController extends Controller
{
    public $layout = 'auth'; // Custom layout without navbar
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout','register','login','index'], 
                'rules' => [
                    [
                        //For logged in users
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout','register','login'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome(); // already logged in
        }
    
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/index']); // login success
        }
    
        return $this->render('login', ['model' => $model]);
    }
    


    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->register()) {
            Yii::$app->user->login($user);
            return $this->goHome();
        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
