<?php
namespace fbwidget\controllers;
use fbwidget\components\MerchantController;
use Yii;
use common\models\SingleOrder;
use common\models\GroupOrder;
use common\models\Order;
use fbwidget\components\SingleScheduleHelper;
use \yii\helpers\Html;

class OrderController extends MerchantController
{


    public function actionAdd()
    {
        $this->layout = '';
        if (isset($_POST['SingleOrder']['id']) && $_POST['SingleOrder']['id']) {
            $model = $this->loadModelSingle($_POST['SingleOrder']['id']);
        } else
            $model = new SingleOrder;
        if (isset($_POST['SingleOrder'])) {
            $model->attributes = $_POST['SingleOrder'];
            $model->order_time = $model->order_date . ' ' . $model->free_time_list;//($model->free_time?$model->free_time:$model->free_time_list);

            $model->price = $model->category->price;
            $model->payment_type = 2;
            $model->source_type = 0;
            if($model->addons_list)
            foreach($model->addons_list as $val){
                $m = \common\models\Addon::findOne($val);
                $model->price += $m->price;
            }
            
            $model->editableAddons = $model->addons_list?$model->addons_list:[];
            
            

            if ($model->save()) {
                if(empty($_POST['SingleOrder']['id'])){
                    \fbwidget\components\EmailManager::newAppointment($model);
                }  else {
                    \fbwidget\components\EmailManager::modifiedAppointment($model);
                }
                
                $response = [
                    'id' => $model->id,
                    'staff_id' => $model->staff_id,
                    'merchant_id' => Yii::$app->user->id,
                    'title' => $model->client_name,
                    'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                    'url' => 'order/update-inst?id=' . $model->id,
                    'backgroundColor' => $model->category->color,
                ];
                echo json_encode($response);
                Yii::$app->end();
            } else {
                //d($model->getErrors());
                echo json_encode($model->getErrors());
                Yii::$app->end();
            }

        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Order::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelSingle($id)
    {
        $model = SingleOrder::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelGroup($id)
    {
        $model = GroupOrder::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionGroupAdd()
    {
        $this->layout = '';
        if (isset($_POST['GroupOrder']['id']) && $_POST['GroupOrder']['id']) {
            $model = $this->loadModelGroup($_POST['GroupOrder']['id']);
        } else
        $model = new GroupOrder();
        if (isset($_POST['GroupOrder'])) {
            $model->attributes = $_POST['GroupOrder'];
            $model->staff_id = $model->category->staff_id;
            $model->price = $model->category->price * $model->no_of_seats;
            $model->merchant_id = Yii::$app->user->id;
            $model->payment_type = 2;
            if($model->addons_list)
            foreach($model->addons_list as $val){
                $m = \common\models\Addon::findOne($val);
                $model->price += $m->price;
            }

            $model->editableAddons = $model->addons_list?$model->addons_list:[];
            
            

            if ($model->save()) {
                
//                if(empty($_POST['GroupOrder']['id'])){
//                
//                    \merchant\components\EmailManager::newAppointment($model);
//                    
//                }  else {
//                    \merchant\components\EmailManager::modifiedAppointment($model);
//                }
                
                
                
                $response = [
                    'id' => 'g-' . strtotime($model->order_time). $model->category_id,
                    'title' => $model->category->title . ' (' . date('H:i',strtotime($model->order_time)) . ') left:' . ($model->category->group_people - GroupOrder::countByDate($model->order_time, $model->category_id)),
                    'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                    'url' => Yii::$app->urlManager->createUrl(['group-order/get-group-orders', 'id'=> $model->category_id, 'date_id'=>strtotime($model->order_time)]),
                    'backgroundColor' => $model->category->color,
                    'staff_id' => $model->staff_id,
                    'merchant_id' => Yii::$app->user->id,

                ];
                    
                echo json_encode($response);

                Yii::$app->end();
            } else {
                echo json_encode(['success' => false, 'response' => $model->getErrors()]);
            }

        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->identity->role) $this->redirect(array('dashboard/index'));
        $model = new Order;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->save())
               return $this->redirect(array('index'));
        }

        return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->identity->role) return $this->redirect(array('dashboard/index'));
        $model = $this->loadModel($id);
        if ($model->merchant_id != Yii::$app->user->id)
            return $this->redirect(array('index'));
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->save())
               return $this->redirect(array('index'));
        }

        return $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        // if(!Yii::$app->user->role)    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        if (Yii::$app->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    public function actionDeleteSingleOrder($id)
    {
        // if(!Yii::$app->user->role)    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        if (Yii::$app->request->isAjax) {
            // we only allow deletion via POST request
            $model = $this->loadModelSingle($id);
            $model->remove();
            $response = [
                'staff_id' => $model->staff_id,
                'merchant_id' => Yii::$app->user->id,

            ];
            
            \fbwidget\components\EmailManager::cancelAppointment($model);
            echo json_encode($response);
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->identity->role) return $this->redirect(array('dashboard/index'));
        
        
        $searchModel = new \common\models\OrderSearch();
        $searchModel->merchant_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 10;

        return $this->render('admin', array(
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionGetFreeStaff()
    {

        if (isset($_POST['date_val']) && $_POST['date_val']) {

            $d = $_POST['date_val'];
            //$t = $_POST['time_val'];
            $m = $_POST['min_val'];
            $c = $_POST['cat'];
            $u = $_POST['update'];
            
            

            if (\common\extensions\SingleScheduleHelper::isMerchantWork($d, $m)) {
                
                $staffs = \common\models\Staff::find()
                        ->joinWith('staff_has_category')
                    ->where(['is_active' => 1,
                        'merchant_id' =>  Yii::$app->user->id,
                        'staff_has_category.category_id'=>$c])
                    ->all();
                $data = [];
                
                $t = "";

                foreach ($staffs as $staff) {
                    
                    if (\common\extensions\SingleScheduleHelper::isStaffWork($d, $t, $m, $staff, $u, $c))
                        $data[] = $staff;
                }

                $data = \yii\helpers\ArrayHelper::map($data, 'id', 'name');
                if ($data) {
                    echo Html::tag('option',Html::encode('select'),
                        array('value' => ''));
                    foreach ($data as $value => $name) {
                        echo Html::tag('option',Html::encode($name),
                            array('value' => $value));
                    }
                } else {
                    echo Html::tag('option',Html::encode('No staff for this time'),
                        array('value' => ''));
                }

            } else {
                echo Html::tag('option',Html::encode('this day is free'),
                    array('value' => ''), true);
            }

            Yii::$app->end();
        }
    }

    public function actionUpdateInst($id)
    {
        
        
        $model = SingleOrder::findOne(['id' => $id]);
        
        

        $res = [
            'id' => $model->id,
            'name' => $model->client_name,
            'phone' => $model->client_phone,
            'email' => $model->client_email,
            'date' => date('d-m-Y', strtotime($model->order_time)),
            'time' => '<option selected value="' . date('H:i', strtotime($model->order_time)) . '">' . date('H:i', strtotime($model->order_time)) . '</option>',
            'staff_id' => $model->staff_id,
            'staff' => $model->staff_id?'<option selected value="' . $model->staff_id . '">' . $model->staff->name . '</option>':'',
            'minimum' => $model->category->time_in_minutes,
            'price' => $model->price,
            'cat_price' => $model->category->price,
            'add_ons'=>$this->renderAjax('_addons_checboxlist', ['model' => $model], true),
            'cat' => $model->category_id,
            'merchant_id' => Yii::$app->user->id,
            'time_sum' => $model->orderTimeLength,
        ];
        echo json_encode($res);
        Yii::$app->end();
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionGetEvents($id){
        
        if (!isset($_GET['start']) || !isset($_GET['end'])) {
            die("Please provide a date range.");
        }


        $range_start = $_GET['start'].' 00:00:00';
        $range_end = $_GET['end'].' 00:00:00';
        echo \common\extensions\SingleScheduleHelper::getStaffOrders($id,$range_start,$range_end);
        Yii::$app->end();
    }

    public function actionGetGroupOrder($id){
        $model = GroupOrder::findOne($id);
        $res = [
            'id' => $model->id,
            'name' => $model->client_name,
            'phone' => $model->client_phone,
            'email' => $model->client_email,
            'date' => $model->order_time,
            'more_info' => $model->more_info,
            'cat' => $model->category_id,
            'price' => $model->price,
            'no_of_seats' => $model->no_of_seats,
            'cat_price' => $model->category->price,
            'add_ons' => ($model->addons) ? \yii\helpers\ArrayHelper::map($model->addons,'id','id') : [],
        ];
        echo json_encode($res);
        Yii::$app->end();
    }

}
