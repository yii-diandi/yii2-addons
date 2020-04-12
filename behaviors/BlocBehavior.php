<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-12 12:36:38
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-04-12 13:16:47
 */

namespace diandi\addons\behaviors;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * Trait MerchantBehavior
 * @package common\components
 */
trait BlocBehavior
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $bloc_id = Yii::$app->service->commonGlobalsService->getBloc_id();
        $store_id = Yii::$app->service->commonGlobalsService->getStore_id();
        // 集团id
        $behaviors[] = [
            'class' => BlameableBehavior::class,
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['bloc_id'],
            ],
            'value' => !empty($bloc_id) ? $bloc_id : 0,
        ];
        // 门店id
        $behaviors[] = [
            'class' => BlameableBehavior::class,
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['store_id'],
            ],
            'value' => !empty($store_id) ? $store_id : 0,
        ];

        return $behaviors;
    }
}
