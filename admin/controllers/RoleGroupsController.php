<?php
class RoleGroupsController extends BaseController {

    public function actionCreate() {
        $model = new RoleGroups;
        if(isset($_POST['RoleGroups'])) {
            $model->attributes=$_POST['RoleGroups'];
            $model->role = implode("||", $_POST['actions']);
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

        if(isset($_POST['RoleGroups'])) {
            $model->attributes  = $_POST['RoleGroups'];
            $model->role = implode("||", $_POST['actions']);
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

         if($_POST['delete'] != 1) {
            if(Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('//partials/_delete', array('field_name'=>"id", "field_value" => $model->id, "display_name" => $model->role_group_name), false, true);
                Yii::app()->end();
            }
            else {
                $this->render('//partials/_delete', array('field_name'=>"id", "field_value" => $model->id, "display_name" => $model->role_group_name));
            }
        }

        if(Yii::app()->request->isPostRequest) {
            $model->delete();

            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function loadModel($id) {
        $model=RoleGroups::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
?>
