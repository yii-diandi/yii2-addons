<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 23:31:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:31:27
 */
 

namespace diandi\addons\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\models\BlocConfSms;

/**
 * BlocConfSmsSearch represents the model behind the search form of `diandi\admin\models\BlocConfSms`.
 */
class BlocConfSmsSearch extends BlocConfSms
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bloc_id', 'access_key_secret'], 'integer'],
            [['access_key_id', 'sign_name', 'template_code'], 'safe'],
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
        $query = BlocConfSms::find();

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
            'access_key_secret' => $this->access_key_secret,
        ]);

        $query->andFilterWhere(['like', 'access_key_id', $this->access_key_id])
            ->andFilterWhere(['like', 'sign_name', $this->sign_name])
            ->andFilterWhere(['like', 'template_code', $this->template_code]);

        return $dataProvider;
    }
}
