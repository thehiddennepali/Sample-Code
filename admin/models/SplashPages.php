<?php
class SplashPages extends CModel {
	public $splash_template;
	public $property;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
                array('property',        'required'),
                array('splash_template', 'required'),
		);
	}

	public function attributeNames(){
		return array("splash_template", "property");
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			"splash_template" 	=> "Splash Template",
			"property" 		    => "Property",
		);
	}
}
?>
