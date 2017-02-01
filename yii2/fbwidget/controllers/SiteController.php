<?php
namespace fbwidget\controllers;

use fbwidget\models\LoginForm;
//use fbwidget\models\PasswordResetRequestForm;
//use fbwidget\models\ResetPasswordForm;
use fbwidget\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Cookie;


/**
 * Site controller
 */
class SiteController extends Controller
{
    
    
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * @inheritdoc
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
     * Displays homepage.
     *
     * @return mixed
     */
    
    public function beforeAction($event)
    {
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        return parent::beforeAction($event);
    }
//    public function actionIndex(){
//         $this->layout = 'widget-layout';
//        
//        $id = explode('_',urldecode(base64_decode($id)));
//        
//        $id = $id[0];
//        
//        $appointment = new \frontend\models\Appointment();
//        
//        $session = Yii::$app->session;
//        
//        $model = $this->findModel($id);
//        
//        $language = $model->language->code;
//        if(isset($language)){            
//            
//            Yii::$app->language = $language;
//
//            $languageCookie = new Cookie([
//                'name' => 'language',
//                'value' => $language,
//                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
//            ]);
//            Yii::$app->response->cookies->add($languageCookie);
//            
//        }
//        
//        if($appointment->load(Yii::$app->request->post())){
//            
//            
//            if(!isset($session['cart']) || count(array_filter($session['cart'])) == 0){
//                $appointment->addError('order', 'Please add at least one service to cart');
//            }else if($appointment->validate()){
//                
//                if(Yii::$app->user->id){
//                    $this->redirect(['checkout/widget-payment']); 
//                }else{
//                    $this->redirect(['checkout/widget-index']);
//                }
//                
//            }
//            
//        }
//        
//        return $this->render('widgetview',[
//            'model' => $model,
//            'appointment' => $appointment,
//        ]);
//    }


    public function actionIndex()
    {        
	    
        $seo = \common\models\Seo::findOne(['type' => 1]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('seo', $seo->meta_description)
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('seo', $seo->meta_keyword)
        ]);
        
        
        if(isset($_GET['Merchant']['search'])){
            $keyword = $_GET['Merchant']['search']; 
            $latLang = \fbwidget\models\MtMerchant::getLatLang($keyword);
            
            
            
            $session = Yii::$app->session;
            $session['latlang']  = $latLang;
            $session['keyword']  = $keyword;
            
            
            
            
            return $this->redirect(['merchant/search','Merchant[search]' => $keyword]);
            
        }
        return $this->render('index', [
            'seo' => $seo
        ]);
    }
    
    
    public function actionLanguage(){
        
        $language = $_POST['code'];
        if(isset($language)){            
            
            Yii::$app->language = $language;

            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            Yii::$app->response->cookies->add($languageCookie);
            echo true;
            Yii::$app->end();
            
        }
        
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
            
        }

        $model = new LoginForm();
        
        
        if ($model->load(Yii::$app->request->post()) ) {
            
            
            
            
            if(Yii::$app->request->isAjax){
                
                if($model->login()){
                    $result = ['success'=>true, 'redirect'=>Yii::$app->urlManager->createUrl('client/dashboard')];
                    Yii::$app->response->format = trim(Response::FORMAT_JSON);
                    return $result;
                    
                }else{
                    $error = ActiveForm::validate($model);
                    Yii::$app->response->format = trim(Response::FORMAT_JSON);
                    return $error; 
                }
            }else{
                if($model->login()){
                    return $this->goBack();
                }
            }
            
            
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        
        return $this->render('contact', [
                //'model' => $model,
            ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAboutUs()
    {
        return $this->render('about-us');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $model = new PasswordResetRequestForm();
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                //return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
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

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    
}
