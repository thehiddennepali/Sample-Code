<?php
namespace fbwidget\components;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 11-Feb-16
 * Time: 16:36
 */
class ImageBehavior extends Behavior
{
    public $imagePath = '';
    const UPLOAD_DIR = '/upload/';
    const UPLOAD_DIRR= '/upload/';
    const UPLOAD_PATH =  '/upload/';
    public $imageField = 'image';
    private  $_prefix = null;
    
    //public $project = 'appointment-portal';

    public function events()
    {
        return[
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }
    
    public static function getImage($id, $imagePath){
        
        $image = \Yii::getAlias('@webroot').self::UPLOAD_DIR.$imagePath.DIRECTORY_SEPARATOR.$id.'.jpg';
        
        
        if(file_exists($image))
            return Yii::$app->request->hostInfo.self::UPLOAD_DIRR.$imagePath.DIRECTORY_SEPARATOR.$id.'.jpg?lastmod='.time();
        else
            return Yii::$app->request->hostInfo.self::UPLOAD_DIRR.'empty.jpg';
    }

    private function getPrefix(){
        if(is_null($this->_prefix)){
            $this->_prefix = str_replace(['admin.','merchant.'],'',Yii::$app->request->hostInfo);
        }
        return $this->_prefix;
    }

    public function getImagePath(){

      return $this->getPrefix().'/appointment-portal/frontend/web'.self::UPLOAD_DIRR.$this->imagePath.DIRECTORY_SEPARATOR .$this->owner->getPrimaryKey().'.jpg';
    }

    public function getImageUrl(){
        //echo $this->getBaseImagePath();exit;
        if(!$this->owner->isNewRecord && file_exists($this->getBaseImagePath())){
            return $this->getImagePath();
        }
        else
            return $this->getPrefix().self::UPLOAD_DIRR.'empty.jpg';

    }

    private function getBaseImagePath(){
        
//        echo \Yii::getAlias('@webroot').self::UPLOAD_DIRR.$this->imagePath.'/'.$this->owner->getPrimaryKey().'.jpg';
//        exit;
        return    \Yii::getAlias('@webroot').self::UPLOAD_DIRR.$this->imagePath.'/'.$this->owner->getPrimaryKey().'.jpg';
    }

    public function beforeValidate($event){
        
        
        $this->owner->{$this->imageField} = \yii\web\UploadedFile::getInstance($this->owner, $this->imageField);
        

    }
    
    private function getAdminBaseImagePath(){
        return    \Yii::getAlias('@webroot').'/../..'.self::UPLOAD_DIRR.$this->imagePath.'/'.$this->owner->getPrimaryKey().'.jpg';
    }

    
    
    public function afterSave($event)
    {
        
        if ($this->owner->{$this->imageField}){
            $this->owner->{$this->imageField}->saveAs($this->getAdminBaseImagePath());
            
        }
    }
    
    
    

    public function afterDelete($event){
        if(file_exists($this->getBaseImagePath()))
        $this->deleteImage();
    }

    public function deleteImage(){
        unlink($this->getBaseImagePath());
    }
}