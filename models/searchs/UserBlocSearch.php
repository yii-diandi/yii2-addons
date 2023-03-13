<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-07 15:59:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 18:55:11
 */
 

namespace diandi\addons\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\models\UserBloc;

/**
 * UserBlocSearch represents the model behind the search form of `diandi\admin\models\UserBloc`.
 */
class UserBlocSearch extends UserBloc
{
    public $bloc_id;


    public function __construct($items = null)
    {
        if ($items['bloc_id']) {
            $this->bloc_id = $items['bloc_id'];
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'bloc_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
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
        $query = UserBloc::find()->with(['bloc','store','user']);

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
            'user_id' => $this->user_id,
            'bloc_id' => $this->bloc_id,
        ]);

        $query->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);

        return $dataProvider;
    }
}
