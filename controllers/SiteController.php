<?php

namespace app\controllers;

use app\models\ChartHelpers;
use app\models\DrawCharts;
use app\models\RecordHelpers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'index', 'contact', 'about'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index' ,'logout', 'contact', 'about'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        if(RecordHelpers::getProfileType() == Yii::$app->params['FMCG']):
            $ticketByProduct = ChartHelpers::getProductOccurrence();
            $ticketByProductChart = DrawCharts::pieChart($ticketByProduct, 'ticket_product');
            
            $ticketByType = ChartHelpers::getTicketsByType();
            $ticketByTypeChart = DrawCharts::pieChart($ticketByType, 'ticket_type');
    
            $retailersByRegion = ChartHelpers::RetailersByRegionData();
            $retailersByRegionChart = DrawCharts::rotatedLColumn($retailersByRegion, 'retailer-region');
    
            $statusTicketByRegion = ChartHelpers::statusTicketsByRegionData();
            $statusTicketByRegionChart = DrawCharts::basicColumn($statusTicketByRegion, 'status-ticket-region');
            
            $weeks = ChartHelpers::formatWeeks();
            $weeklyTicket = ChartHelpers::weeklyTicketsByTypeData();
            $weeklyTicketStackedChart = DrawCharts::stackedColumn($weeks, $weeklyTicket, 'weekly-ticket-stacked');
            $weeklyTicketLineChart = DrawCharts::basicLine($weeks, $weeklyTicket, 'weekly-ticket-basic-line');
            
            
            return $this->render('index',[
                'ticketByProductChart' => $ticketByProductChart,
                'ticketByTypeChart' => $ticketByTypeChart,
                'retailersByRegionChart' => $retailersByRegionChart,
                'statusTicketByRegionChart' => $statusTicketByRegionChart,
                'weeklyTicketStackedChart' => $weeklyTicketStackedChart,
                'weeklyTicketLineChart' => $weeklyTicketLineChart
            ]);
        else: // subdealers don't have a dashboard
            $this->redirect(array('tickets/index'));
        endif;
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
