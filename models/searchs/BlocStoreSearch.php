<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 15:06:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 12:26:26
 */

namespace diandi\addons\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\models\BlocStore;
use Yii;

/**
 * BlocStoreSearch represents the model behind the search form of `diandi\admin\models\BlocStore`.
 */
class BlocStoreSearch extends BlocStore
{
    public $bloc_id;
    public $store_id;

    public $extra;

    public function __construct($items = null)
    {
        if ($items['bloc_id']) {
            $this->bloc_id = $items['bloc_id'];
        }

        if (Yii::$app->controller->module->id != 'addons') {
            $this->store_id = Yii::$app->params['store_id'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'bloc_id', 'status'], 'integer'],
            [['name', 'logo', 'province', 'city', 'address', 'county', 'mobile', 'create_time', 'update_time', 'lng_lat'], 'safe'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BlocStore::find()->with(['bloc']);

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
            'store_id' => $this->store_id,
            'bloc_id' => $this->bloc_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'county', $this->county])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time])
            ->andFilterWhere(['like', 'lng_lat', $this->lng_lat]);

        return $dataProvider;
    }
}
