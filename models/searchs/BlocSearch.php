<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-31 06:42:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:32:19
 */

namespace diandi\addons\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\models\Bloc;

/**
 * BlocSearch represents the model behind the search form of `backend\modules\bloc\models\Bloc`.
 */
class BlocSearch extends Bloc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'pid', 'avg_price',  'status'], 'integer'],
            [['business_name', 'category', 'province', 'city', 'district', 'address', 'longitude', 'latitude', 'telephone', 'recommend', 'special', 'introduction', 'open_time', 'sosomap_poi_uid', 'license_no', 'license_name', 'other_files'], 'safe'],
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
        $query = Bloc::find();

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
            'bloc_id' => $this->bloc_id,
            'pid' => $this->pid,
            'avg_price' => $this->avg_price,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'business_name', $this->business_name])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'recommend', $this->recommend])
            ->andFilterWhere(['like', 'special', $this->special])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'open_time', $this->open_time])
            ->andFilterWhere(['like', 'sosomap_poi_uid', $this->sosomap_poi_uid])
            ->andFilterWhere(['like', 'license_no', $this->license_no])
            ->andFilterWhere(['like', 'license_name', $this->license_name]);

        return $dataProvider;
    }
}
