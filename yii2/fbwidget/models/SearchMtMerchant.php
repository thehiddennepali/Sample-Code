<?php

namespace fbwidget\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fbwidget\models\MtMerchant;

/**
 * SearchMtMerchant represents the model behind the search form about `frontend\models\MtMerchant`.
 */
class SearchMtMerchant extends MtMerchant
{
    public $search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'free_delivery', 'status', 'package_id', 'payment_steps', 'is_featured', 'is_ready', 'is_sponsored', 'user_lang', 'sort_featured', 'is_commission', 'commission_type', 'manager_extended', 'gallery_id', 'is_purchase'], 'integer'],
            [['service_name', 'service_phone', 'contact_name', 'contact_phone', 'contact_email', 'country_code', 'street', 'city', 'state', 'post_code', 'cuisine', 'service', 'delivery_estimation', 'username', 'password', 'activation_key', 'activation_token', 'date_created', 'date_modified', 'date_activated', 'last_login', 'ip_address', 'membership_expired', 'sponsored_expiration', 'lost_password_code', 'membership_purchase_date', 'session_token', 'seo_title', 'seo_description', 'seo_keywords', 'url', 'manager_username', 'manager_password', 'fb', 'tw', 'gl', 'yt', 'it', 'paypall_id', 'paypall_pass', 'gmap_altitude', 'gmap_latitude', 'address', 'vk', 'pr', 'description', 'password_hash', 'password_reset_token', 'auth_key'], 'safe'],
            [['package_price', 'percent_commission', 'fixed_commission'], 'number'],
            [['search'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MtMerchant::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'merchant_id' => $this->merchant_id,
            'free_delivery' => $this->free_delivery,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
            'date_activated' => $this->date_activated,
            'last_login' => $this->last_login,
            'package_id' => $this->package_id,
            'package_price' => $this->package_price,
            'membership_expired' => $this->membership_expired,
            'payment_steps' => $this->payment_steps,
            'is_featured' => $this->is_featured,
            'is_ready' => $this->is_ready,
            'is_sponsored' => $this->is_sponsored,
            'sponsored_expiration' => $this->sponsored_expiration,
            'user_lang' => $this->user_lang,
            'membership_purchase_date' => $this->membership_purchase_date,
            'sort_featured' => $this->sort_featured,
            'is_commission' => $this->is_commission,
            'percent_commission' => $this->percent_commission,
            'fixed_commission' => $this->fixed_commission,
            'commission_type' => $this->commission_type,
            'manager_extended' => $this->manager_extended,
            'gallery_id' => $this->gallery_id,
            'is_purchase' => $this->is_purchase,
        ]);

        $query->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'service_phone', $this->service_phone])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'post_code', $this->post_code])
            ->andFilterWhere(['like', 'cuisine', $this->cuisine])
            ->andFilterWhere(['like', 'service', $this->service])
            ->andFilterWhere(['like', 'delivery_estimation', $this->delivery_estimation])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'activation_key', $this->activation_key])
            ->andFilterWhere(['like', 'activation_token', $this->activation_token])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'lost_password_code', $this->lost_password_code])
            ->andFilterWhere(['like', 'session_token', $this->session_token])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'manager_username', $this->manager_username])
            ->andFilterWhere(['like', 'manager_password', $this->manager_password])
            ->andFilterWhere(['like', 'fb', $this->fb])
            ->andFilterWhere(['like', 'tw', $this->tw])
            ->andFilterWhere(['like', 'gl', $this->gl])
            ->andFilterWhere(['like', 'yt', $this->yt])
            ->andFilterWhere(['like', 'it', $this->it])
            ->andFilterWhere(['like', 'paypall_id', $this->paypall_id])
            ->andFilterWhere(['like', 'paypall_pass', $this->paypall_pass])
            ->andFilterWhere(['like', 'gmap_altitude', $this->gmap_altitude])
            ->andFilterWhere(['like', 'gmap_latitude', $this->gmap_latitude])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'vk', $this->vk])
            ->andFilterWhere(['like', 'pr', $this->pr])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);
        
//        if(!empty($this->search)){
//            
//            $query->orWhere(['like', 'street', $this->search])
//                ->orWhere(['like', 'city', $this->search])
//                ->orWhere(['like', 'post_code', $this->search]);
//            
//        }
//        echo '<pre>';
//        print_r($dataProvider);
//        exit;
        

        return $dataProvider;
    }
}
