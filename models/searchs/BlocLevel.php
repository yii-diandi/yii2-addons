<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-02-24 09:56:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 18:51:02
 */


namespace diandi\addons\models\searchs;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use diandi\addons\models\BlocLevel as BlocLevelModel;
use yii\data\Pagination;


/**
 * BlocLevel represents the model behind the search form of `diandi\addons\models\BlocLevel`.
 */
class BlocLevel extends BlocLevelModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bloc_id', 'global_bloc_id', 'level_num'], 'integer'],
            [['name', 'thumb', 'extra', 'create_time', 'update_time'], 'safe'],
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
        $query = BlocLevelModel::find();

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'level_num' => $this->level_num,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time]);
        
        $count = $query->count();
        $pageSize   =\Yii::$app->request->input('pageSize',10);
        $page       = \Yii::$app->request->input('page',1);
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
            $value['thumb'] = ImageHelper::tomedia($value['thumb']); 
           $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
           $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        } 
            

        $provider = new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total'=> isset($count) ? $count : 0,
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
            ]
        ]);
        
        return $provider;
        
    }
}
