<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 23:30:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:30:58
 */
 

namespace diandi\addons\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\models\BlocConfBaidu;

/**
 * BlocConfBaiduSearch represents the model behind the search form of `diandi\admin\models\BlocConfBaidu`.
 */
class BlocConfBaiduSearch extends BlocConfBaidu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bloc_id', 'API_KEY', 'create_time', 'update_time'], 'integer'],
            [['APP_ID', 'SECRET_KEY', 'name'], 'safe'],
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
        $query = BlocConfBaidu::find();

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
            'API_KEY' => $this->API_KEY,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'APP_ID', $this->APP_ID])
            ->andFilterWhere(['like', 'SECRET_KEY', $this->SECRET_KEY])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
