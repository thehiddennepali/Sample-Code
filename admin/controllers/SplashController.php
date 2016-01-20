<?php
class SplashController extends BaseController {
    public function actionView() {
        $model = new SplashPages();
        $model->attributes = $_POST['SplashPages'];

        if($model->validate()) {
            $loginUrl = $model->splash_template;
            $id       = $model->property;
            $loginUrl = $loginUrl . "?id=".$id;
            if(Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('//partials/_splashurl', array('url'=>$loginUrl), false, true);
            }
            else {
                $this->render('//partials/_splashurl', array('url'=>$loginUrl));
            }
            Yii::app()->end();
        }
         
        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('create', array('model'=>$model,'splashTemplates'=>$splashTemplates, 'properties' => $property, 'propertyGroups' => $propertyGroups), false, true);
            Yii::app()->end();
        }
        $this->render('create',array('model'=>$model,'splashTemplates'=>$splashTemplates, 'properties' => $property, 'propertyGroups' => $propertyGroups));
    }

    public function actionCreate() {
        $model 				= new SplashPages();
        if(Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('create', array('model'=>$model), false, true);
            Yii::app()->end();
        }
        $this->render('create', array('model'=>$model));
    }
}
?>
