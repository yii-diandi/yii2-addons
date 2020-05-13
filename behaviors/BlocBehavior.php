<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-12 12:36:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:30:52
 */

namespace diandi\addons\behaviors;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * Trait MerchantBehavior.
 */
trait BlocBehavior
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $bloc_id = Yii::$app->service->commonGlobalsService->getBloc_id();
        $store_id = Yii::$app->service->commonGlobalsService->getStore_id();
        
        // 后台用户使用
        if (Yii::$app->user->identity->bloc_id) {
            $bloc_id = Yii::$app->user->identity->bloc_id;
        }

        if (Yii::$app->user->identity->store_id) {
            $store_id = Yii::$app->user->identity->store_id;
        }
        
        $attributes =self::attributes();
        if(in_array('bloc_id',$attributes)){
            // 集团id
            $behaviors[] = [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['bloc_id'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['bloc_id'],
                ],
                'value' => !empty($bloc_id) ? $bloc_id : 0,
            ];
        }
        
        if(in_array('store_id',$attributes)){
            // 门店id
            $behaviors[] = [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['store_id'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['store_id'],
                ],
                'value' => !empty($store_id) ? $store_id : 0,
            ];
        }
      

        return $behaviors;
    }
}
