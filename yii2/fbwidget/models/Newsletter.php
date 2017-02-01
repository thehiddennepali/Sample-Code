<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "mt_newsletter".
 *
 * @property integer $id
 * @property string $email_address
 * @property string $date_created
 * @property string $ip_address
 */
class Newsletter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_newsletter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_address'], 'required'],
            [['email_address'], 'email'],
            ['email_address','unique'],
            [['date_created','ip_address'], 'safe'],
            [['email_address'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_address' => 'Email Address',
            'date_created' => 'Date Created',
            'ip_address' => 'Ip Address',
        ];
    }
}
