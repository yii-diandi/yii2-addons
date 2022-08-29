<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-30 22:40:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-29 11:46:39
 */

namespace diandi\addons\models;

use common\helpers\ArrayHelper;
use common\helpers\HashidsHelper;
use common\models\DdRegion;
use diandi\region\Region;

/**
 * This is the model class for table "diandi_bloc".
 *
 * @property int    $bloc_id
 * @property string $business_name   公司名称
 * @property int    $pid             上级商户
 * @property string $category
 * @property string $province        省份
 * @property string $city            城市
 * @property string $district        区县
 * @property string $address         具体地址
 * @property string $longitude       经度
 * @property string $latitude        纬度
 * @property string $telephone       电话
 * @property string $photo_list
 * @property int    $avg_price
 * @property string $recommend       介绍
 * @property string $special         特色
 * @property string $introduction    详细介绍
 * @property string $open_time       开业时间
 * @property int    $location_id
 * @property int    $status          1 审核通过 2 审核中 3审核未通过
 * @property int    $source          1为系统门店，2为微信门店
 * @property string $message
 * @property string $sosomap_poi_uid 腾讯地图标注id
 * @property string $license_no      营业执照注册号或组织机构代码
 * @property string $license_name    营业执照名称
 * @property string $other_files     其他文件
 * @property string $audit_id        审核单id
 * @property int    $on_show         微信后台设置的展示状态 1:展示；2:未展示
 */
class Bloc extends \yii\db\ActiveRecord
{
    public $extra = [];

    public function __construct($item = null)
    {
        if (!empty($item['extras'])) {
            $extra = [];
            foreach ($item['extras'] as $key => $value) {
                $extra[$value] = '';
                $pas[] = 'extra[' . $value . ']';
            }
            $this->extra = $extra;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc}}';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['business_name', 'province', 'city', 'district', 'address', 'longitude', 'latitude', 'telephone', 'avg_price', 'recommend', 'special', 'introduction', 'open_time', 'status'], 'required'],
            ['status', 'default', 'value' => 2],
            ['is_group', 'default', 'value' => 0],
            ['register_level', 'default', 'value' => 0],
            [['pid', 'avg_price', 'status', 'store_id', 'register_level', 'group_bloc_id', 'is_group', 'level_num'], 'integer'],
            [['other_files'], 'string'],
            [['business_name', 'address', 'open_time', 'sosomap_poi_uid','invitation_code','invitation_code'], 'string', 'max' => 50],
            [['category', 'recommend', 'special', 'introduction'], 'string', 'max' => 255],
            [['province', 'city', 'district', 'longitude', 'latitude'], 'string', 'max' => 15],
            [['telephone'], 'string', 'max' => 20],
            [['license_no'], 'string', 'max' => 30],
            [['extra'], 'safe'],
            [['is_group'], 'checkGroup'],
            [['license_name'], 'string', 'max' => 100],
        ];
    }

    
        /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            empty($this->invitation_code) && Bloc::updateAll(['invitation_code' => HashidsHelper::encode($this->bloc_id)], ['bloc_id' => $this->bloc_id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->extra = serialize($this->extra);
            //字段
            if (!is_numeric($this->is_group)) {
                $list = ['非集团' => 0, '集团' => 1];
                $this->is_group = $list[$this->is_group];
            }

            if ($this->is_group == 1) {
                $this->group_bloc_id = $this->bloc_id;
                // 更新所有的子集
                $this->getChildList($this->bloc_id);
            } else {
                // 获取上级的集团
                $group_bloc_id = $this->find()->where(['pid' => $this->bloc_id])->select('group_bloc_id')->scalar();
                $this->group_bloc_id = $group_bloc_id ? $group_bloc_id : 0;
            }

            if (empty($this->group_bloc_id)) {
                $this->group_bloc_id = 0;
            }
            return true;
        } else {
            return false;
        }
    }


    public function getChildList($pid)
    {
        $parents = $this->find()->asArray()->all();

        $parentBloc =  ArrayHelper::itemsMerge($parents, 0, "bloc_id", 'pid', 'child');
        foreach ($parentBloc as $key => $value) {
            if ($value['bloc_id'] == $pid) {
                $childList[] = $value;
            }
        }

        $bloc_ids = self::getChilds($childList, 'bloc_id');

        return $this->updateAll([
            'group_bloc_id' => $this->group_bloc_id
        ], [
            'bloc_id' => $bloc_ids
        ]);
    }

    public static function getChilds(array $items, $field)
    {
        $arr = [];
        foreach ($items as $v) {
            $arr[] = $v[$field];
            if ($v['child']) {
                $arr = array_merge(self::getChilds($v['child'], $field), $arr);
            }
        }

        return $arr;
    }

    function checkGroup($attribute, $params)
    {
        $pid = $this->pid;
        if (!empty($pid) && $this->is_group == 1) {
            $this->addError($attribute, "只能将一级公司设置为集团");
        }
    }

    public function getArea()
    {
        return $this->hasOne(DdRegion::className(), ['id' => 'district']);
    }

    public function extraFields()
    {
        return $this->extra;
    }


    public function getStore()
    {
        return $this->hasMany(BlocStore::className(), ['bloc_id' => 'bloc_id']);
    }

    public function getUserBloc()
    {
        return $this->hasMany(UserBloc::className(), ['bloc_id' => 'bloc_id']);
    }


    public function getParent()
    {
        return $this->hasOne(Bloc::className(), ['bloc_id' => 'pid'])->from(Bloc::tableName() . ' parent');
    }

    public function getGlobal()
    {
        return $this->hasOne(Bloc::className(), ['bloc_id' => 'group_bloc_id'])->from(Bloc::tableName() . ' global');
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bloc_id' => '公司ID',
            'business_name' => '公司名称',
            'group_bloc_id' => '所属集团',
            'pid' => '上级公司',
            'category' => '分类',
            'province' => '省份',
            'city' => '城市',
            'district' => '区县',
            'address' => '具体地址',
            'longitude' => '经度',
            'latitude' => '纬度',
            'telephone' => '电话',
            'avg_price' => '平均消费',
            'recommend' => '介绍',
            'level_num' => '等级',
            'special' => '特色',
            'introduction' => '详细介绍',
            'open_time' => '开业时间',
            'status' => '审核状态',
            'register_level' => '注册级别',
            'is_group' => '是否是集团',
            'sosomap_poi_uid' => '腾讯地图标注id',
            'license_no' => '营业执照注册号',
            'license_name' => '营业执照名称',
            'other_files' => '其他文件',
        ];
    }
}
