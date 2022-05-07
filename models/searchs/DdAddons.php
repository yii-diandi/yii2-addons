<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 19:30:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-07 15:04:12
 */

namespace diandi\addons\models\searchs;

use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use diandi\addons\models\DdAddons as DdAddonsModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdAddons represents the model behind the search form of `diandi\addons\models\DdAddons`.
 */
class DdAddons extends DdAddonsModel
{
    public $module_names;

    /**
     * 父级ID
     */
    public $parent_mids;

    public function __construct($item = null)
    {
        if ($item['module_names']) {
            $this->module_names = $item['module_names'];
        }

        if (isset($item['parent_mids'])) {
            $this->parent_mids = $item['parent_mids'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mid', 'settings', 'parent_mids'], 'integer'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        global $_GPC;

        $query = DdAddonsModel::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mid' => $this->mid,
            'settings' => $this->settings,
            'identifie' => $this->module_names,
        ]);

        $parent_mids = $this->parent_mids;
        $query->andFilterWhere(['like', 'identifie', $this->identifie])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'ability', $this->ability])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'logo', $this->logo]);

	    if (isset($parent_mids)) {
            $query->andWhere("FIND_IN_SET($parent_mids,parent_mids)");
        }

        $count = $query->count();
        $pageSize = $_GPC['pageSize'];
        $page = $_GPC['page'];
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        foreach ($list as $key => &$value) {
            $value['logo'] = ImageHelper::tomedia($value['logo']);
        }

        $provider = new ArrayDataProvider([
            'key' => 'mid',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total' => isset($count) ? $count : 0,
            'sort' => [
                'attributes' => [
                    //'member_id',
                ],
                'defaultOrder' => [
                    //'member_id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        return $provider;
    }
}
