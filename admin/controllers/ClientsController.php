<?php
class ClientsController extends BaseController {

    public function actionCreate() {
        $model          = new Clients;
        $account        = new Accounts;
        $preference     = new Preferences;

        if(isset($_POST['Clients'], $_POST['Accounts'], $_POST['Preferences'])) {
            $model->attributes      = $_POST['Clients'];
            $account->attributes    = $_POST['Accounts'];
            $preference->attributes = $_POST['Preferences'];
            $model->login_name      = $account->login_name;
            $model->client_code     = RandomGenerator::generateString(AdminGlobals::CLIENT_CODE_LENGTH);
            $model->subscription_status = "active";

            $preference->prepaid_passwd = RandomGenerator::generateString(AdminGlobals::PREPAID_PASSWD_LENGTH);

            $account->account_name  = $model->client_name;
            $account->email         = $model->email;
            $account->is_visible    = 0;

            $valid = $model->validate();
            $valid = $account->validate() && $valid;
            $valid = $preference->validate() && $valid;

            if($valid) {
                $transaction = Yii::app()->db->beginTransaction();
                $success = $model->save(false);
                if($success) {
                    $account->client_id = $preference->client_id = $model->id;
                }
                $success = $success && $account->save(false);
                $success = $success && $preference->save(false);
                if($success) {
                    $transaction->commit();
                    if(Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('view',array('model'=>$this->loadModel($model->id), 'account'=>$account, 'preference'=>$preference), false, true);
                        Yii::app()->end();
                    }
                    $this->redirect(array('view', 'id'=>$model->id));
                }
                $transaction->rollBack();
            }
        }
        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('create', array('model'=>$model, 'account'=>$account, 'preference'=>$preference), false, true);
            Yii::app()->end();
        }
        $this->render('create',array('model'=>$model, 'account'=>$account, 'preference'=>$preference));
    }

    public function actionUpdate($id) {
        $model          = $this->loadModel($id);
        $account        = new Accounts;
        $preference     = new Preferences;

        $account->client_id     = $model->id;
        $preference->client_id  = $model->id;

        $account    = $account->find('t.login_name=:login_name AND t.client_id=:client_id',
                                     array(':login_name' => $model->login_name, ':client_id' => (int)$model->id));
        $preference = $preference->find('t.client_id=:client_id', array(':client_id' => (int)$model->id));

        if($account === null || $preference === null)
            throw new CHttpException(500,'Internal Database Error.');

        if(isset($_POST['Clients'], $_POST['Accounts'], $_POST['Preferences'])) {
            $model->attributes      = $_POST['Clients'];
            $account->attributes    = $_POST['Accounts'];
            $preference->attributes = $_POST['Preferences'];
            $model->login_name      = $account->login_name;
            $account->account_name  = $model->client_name;
            $account->email         = $model->email;

            $valid = $model->validate();
            $valid = $account->validate() && $valid;
            $valid = $preference->validate() && $valid;

            if($valid) {
                $transaction = Yii::app()->db->beginTransaction();
                $success = $model->save();
                $success = $success && $account->save();
                $success = $success && $preference->save();

                if($success) {
                    $transaction->commit();
                    if(Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('view',array('model'=>$this->loadModel($model->id), 'account'=>$account, 'preference'=>$preference), false, true);
                        Yii::app()->end();
                    }
                    $this->redirect(array('view','id'=>$model->id));
                }
                $transaction->rollBack();
            }
        }
        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('update', array('model'=>$model, 'account'=>$account, 'preference'=>$preference), false, true);
            Yii::app()->end();
        }
        $this->render('update',array('model'=>$model, 'account'=>$account, 'preference'=>$preference));
    }

    public function actionView($id) {
        $model      = $this->loadModel($id);
        $account    = new Accounts;
        $preference = new Preferences;

        $account->client_id     = $model->id;
        $preference->client_id  = $model->id;

        $account    = $account->find('t.login_name=:login_name AND client_id=:client_id',
                                     array(':login_name' => $model->login_name, ':client_id' => (int)$model->id));
        $preference = $preference->with('payment_gateways')->find('t.client_id=:client_id', array(':client_id' => (int)$model->id));

        if($account === null || $preference === null)
            throw new CHttpException(404, 'Error while processing the request.');

        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('view', array('model'=>$this->loadModel($id), 'account'=>$account, 'preference'=>$preference), false, true);
            Yii::app()->end();
        }
        $this->render('view', array('model'=>$this->loadModel($id), 'account'=>$account, 'preference'=>$preference));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);

        if($_POST['delete'] != 1) {
            if(Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('//partials/_delete', array('field_name'=>"id", "field_value" => $model->id, "display_name" => $model->client_name), false, true);
                Yii::app()->end();
            }
            else {
                $this->render('//partials/_delete', array('field_name'=>"id", "field_value" => $model->id, "display_name" => $model->client_name));
            }
        }

        if(Yii::app()->request->isPostRequest) {
            $account    = new Accounts;
            $preference = new Preferences;

            $account->client_id     = $model->id;
            $preference->client_id  = $model->id;

            $account    = $account->find('t.login_name=:login_name AND client_id=:client_id',
                                         array(':login_name' => $model->login_name, ':client_id' => (int)$model->id));
            $preference = $preference->find('t.client_id=:client_id',   array(':client_id' => (int)$model->id));

            $transaction = Yii::app()->db->beginTransaction();
            $success = $model->delete();
            $success = ($account !== null && $success)    ? ($account->delete())    : $success;
            $success = ($preference !== null && $success) ? ($preference->delete()) : $success;

            if($success)
                $transaction->commit();
            else
                $transaction->rollBack();

            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionQuickApprove($id) {
        $model = $this->loadModel($id);
        $model->subscription_status = "trial";
        $model->save();

        $this->_sendApprovalMail($model);

        $model = new Clients();
        $model->unsetAttributes();

        if(isset($_GET["Clients"]))
            $model->attributes = $_GET["Clients"];

        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('admin', array('model'=>$model), false, true);
            Yii::app()->end();
        }
        else {
            $this->render('admin', array( 'model'=>$model));
        }
    }

    private function _sendApprovalMail($model) {
        $account    = Accounts::model()->find('t.login_name=:login_name AND t.client_id=:client_id',
                                              array(':login_name' => $model->login_name,
                                                    ':client_id'  => (int)$model->id));
        $subject    = "Account Approved";
        $username   = $account->login_name;
        $fromMail   = Config::SIGNUP_FROM_MAIL_ADDR;
        $toMail     = $model->email;
        $loginUrl   = Yii::app()->getBaseUrl(true). "/index.php";

        $nextBillingDate = Yii::app()->localtime->toLocalDateTime($model->next_billing_date);
        list($nextBillingDate, ) = explode(" ", $nextBillingDate);

        $body = "
                <html>
                <head>
                  <title>$subject</title>
                </head>
                <body>
                    <pre>
                    Dear Customer,<br/><br/>
                    Your account is authorized, you can get the benifit of trial period.<br/><br/>
                    Your username is - $username<br/>

                    You can login at - $loginUrl<br>
                    Your trial period is going to end by - $nextBillingDate<br/>

                    Thank you,<br/>
                    $thankYou<br/>
                    </pre>
                </body>
                </html>";

        Utils::queueMail($body, $subject, $fromMail, $toMail);
    }

    public function loadModel($id) {
        $model = Clients::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
?>
