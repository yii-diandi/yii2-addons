<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 23:31:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:31:41
 */
 

namespace diandi\addons\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\models\BlocConfWechatpay;

/**
 * BlocConfWechatpaySearch represents the model behind the search form of `diandi\admin\models\BlocConfWechatpay`.
 */
class BlocConfWechatpaySearch extends BlocConfWechatpay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bloc_id', 'app_id', 'create_time', 'update_time'], 'integer'],
            [['mch_id', 'key', 'notify_url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = BlocConfWechatpay::find();

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
            'id' => $this->id,
            'bloc_id' => $this->bloc_id,
            'app_id' => $this->app_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'mch_id', $this->mch_id])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'notify_url', $this->notify_url]);

        return $dataProvider;
    }
}
