<?php

namespace diandi\addons\modules\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use diandi\addons\modules\DdAddons as DdAddonsModel;

/**
 * DdAddons represents the model behind the search form of `diandi\addons\modules\DdAddons`.
 */
class DdAddons extends DdAddonsModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mid', 'settings'], 'integer'],
            [['identifie', 'type', 'title', 'version', 'ability', 'description', 'author', 'url', 'logo'], 'safe'],
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
        $query = DdAddonsModel::find();

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
            'mid' => $this->mid,
            'settings' => $this->settings,
        ]);

        $query->andFilterWhere(['like', 'identifie', $this->identifie])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'ability', $this->ability])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
