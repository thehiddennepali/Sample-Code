<?php
class AccountsController extends BaseController {
    public function actionView($id) {
         if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('view', array('model'=>$this->loadModel($id)), false, true);
            Yii::app()->end();
        }
        $this->render('view', array('model'=>$this->loadModel($id)));
    }

    public function actionCreate() {
        $model = new Accounts;

        if(isset($_POST['Accounts'])) {
            $model->attributes=$_POST['Accounts'];
            if($model->save()) {
                if(Yii::app()->request->isAjaxRequest) {
                    $this->renderPartial('view',array('model'=>$this->loadModel($model->id)), false, true);
                    Yii::app()->end();
                }
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('create', array('model'=>$model), false, true);
            Yii::app()->end();
        }
        $this->render('create',array('model'=>$model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if(isset($_POST['Accounts'])) {
            $model->attributes  = $_POST['Accounts'];
            if($model->save()) {
                  if(Yii::app()->request->isAjaxRequest) {
                    $this->renderPartial('view', array('model'=>$this->loadModel($model->id)), false, true);
                    Yii::app()->end();
                }
                $this->redirect(array('view','id'=>$model->id));
            }
        }
        if(Yii::app()->request->isAjaxRequest) {
             $this->renderPartial('update', array('model'=>$model), false, true);
             Yii::app()->end();
         }
        $this->render('update',array( 'model'=>$model));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        parent::deleteGeneric($id,"id", $model->id,$model->account_name);
    }

    public function actionAdmin() {
        $model = new Accounts('search');
        $model->unsetAttributes();
        if(isset($_GET['Accounts']))
            $model->attributes = $_GET['Accounts'];

        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('admin', array('model'=>$model), false, true);
            Yii::app()->end();
        }
        $this->render('admin', array( 'model'=>$model));
    }

    public function loadModel($id) {
        $model=Accounts::model()->visible()->with('role_groups')->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
?>
