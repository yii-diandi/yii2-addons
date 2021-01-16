<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 16:05:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 02:09:07
 */

namespace diandi\addons\models;

/**
 * This is the model class for table "dd_diandi_store".
 *
 * @property int         $store_id    商户id
 * @property string|null $name        门店名称
 * @property int|null    $bloc_id     关联公司
 * @property string|null $province    省份
 * @property string|null $city        城市
 * @property string|null $address     详细地址
 * @property string|null $county      区县
 * @property string|null $mobile      联系电话
 * @property string|null $create_time
 * @property string|null $update_time
 * @property int|null    $status      '0:待审核','1:已通过','3:已拉黑'
 * @property string|null $lng_lat     经纬度
 */
class BlocStore extends \yii\db\ActiveRecord
{
    public function __construct($item = null)
    {
        if ($item['extras']) {
            $extra = [];
            foreach ($item['extras'] as $key => $value) {
                $extra[$value] = '';
                $pas[] = 'extra['.$value.']';
            }
            $this->extra = $extra;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_store}}';
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->extra = serialize($this->extra);

            if (is_array($this->lng_lat)) {
                $this->latitude = $this->lng_lat['lat'];
                $this->longitude = $this->lng_lat['lng'];
                $this->lng_lat = json_encode($this->lng_lat);
               
            }

            return true;
        } else {
            return false;
        }
    }

    public function extraFields()
    {
        return $this->extra;
    }

    public function getBloc()
    {
        return $this->hasOne(Bloc::className(), ['bloc_id' => 'bloc_id']);
    }

    public function getLabel()
    {
        return $this->hasMany(StoreLabelLink::className(), ['store_id' => 'store_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'status','category_id','category_pid'], 'integer'],
            ['bloc_id', 'compare', 'compareValue' => 0, 'operator' => '!='],
            [['name', 'logo', 'address','longitude', 'latitude'], 'string', 'max' => 255],
            [['province', 'city', 'county'], 'string', 'max' => 10],
            [['mobile'], 'string', 'max' => 11],
            [['lng_lat'], 'string'],
            [['extra'], 'safe'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'store_id' => '商户id',
            'name' => '商户名称',
            'extra' => '扩展资料',
            'logo' => '商户LOGO',
            'category_id' => '二级分类',
            'category_pid' => '一级分类',
            'bloc_id' => '关联公司',
            'province' => '省份',
            'city' => '城市',
            'address' => '详细地址',
            'county' => '区县',
            'mobile' => '联系电话',
            'create_time' => '添加时间',
            'update_time' => 'Update Time',
            'status' => '审核状态',
            'lng_lat' => '经纬度',
            'latitude' => '维度',
            'longitude' => '经度'
        ];
    }
}
