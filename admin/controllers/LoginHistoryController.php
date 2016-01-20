<?php
class LoginHistoryController extends BaseController {
    public function loadModel($id) {
        $model=LoginHistory::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
