<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 15:15:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 02:28:17
 */
use common\models\DdRegion;
use richardfan\widget\JSRegister;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocStore */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bloc-store-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <?= Html::activeHiddenInput($model, 'bloc_id', array(
        'value' => $bloc_id,
    )); ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    
    <?= $form->field($model, 'category_pid')->dropDownList($Helper->courseCateMap(), [
                    'prompt' => ['text' => '一级分类', 'options' => ['value' => 0]],
                    'label' => '一级分类',
                    'id' => 'classsearch-cocate_id',
                ])->label('一级分类'); ?>
                
    <?= $form->field($model, 'category_id')->dropDownList($Helper->courseMap($model->category_id), [
                        // 'options' => ['5' => ['selected' => true]],
                        'prompt' => ['text' => '二级分类', 'options' => ['value' => 0]],

                        'id' => 'classsearch-course_id',
                    ])->label('二级分类 '); ?>
                    
    <?= $form->field($model, 'lng_lat')->widget('common\widgets\adminlte\Map', [
        'type' => 'amap',
        'secret_key' => Yii::$app->settings->get('Map', 'amapApk'),
    ]); ?>
    
    <?= $form->field($model, 'logo')->widget('common\widgets\webuploader\FileInput', [])->hint('尺寸：500px*500px'); ?>
        
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

    <?= $form->field($model, '地区')->widget(\diandi\region\Region::className(), [
        'model' => $model,
        'url' => \yii\helpers\Url::toRoute(['get-region']),
        'province' => [
            'attribute' => 'province',
            'items' => DdRegion::getRegion(),
            'options' => [
                'class' => 'form-control form-control-inline',
                'prompt' => '选择省份',
            ],
        ],
        'city' => [
            'attribute' => 'city',
            'items' => DdRegion::getRegion($model['province']),
            'options' => [
                'class' => 'form-control form-control-inline',
                'prompt' => '选择城市',
            ],
        ],
        'district' => [
            'attribute' => 'county',
            'items' => DdRegion::getRegion($model['city']),
            'options' => [
                'class' => 'form-control form-control-inline',
                'prompt' => '选择县/区',
            ],
        ],
    ]);
    ?>
    
     
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]); ?>
    
    <?= $form->field($model, 'status')->radioList([
            1 => '审核通过',
            2 => '审核中',
            3 => '审核未通过',
        ]); ?>
        
    <?= $form->field($link, 'label_id')->checkboxList(ArrayHelper::map($labels, 'id','name')); ?>

    </div>

   
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
   <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']); ?>
    </div>
   </div>

    <?php ActiveForm::end(); ?>

</div>

<?php JSRegister::begin([
    'key' => 'cate-store',
]); ?>
<script>
     //分类
     $("#classsearch-cocate_id").change(function() {
            var cocateId = $(this).val(); //获取一级目录的值
            // $("#classsearch-course_id").html("<option value=\"\">选择二级分类</option>");//二级显示目录标签
            console.log(cocateId)
            if (cocateId > 0) {
                getCourse(cocateId); //查询二级目录的方法
            }
        });

        function getCourse(cocateId) {
            $.ajax({
                "type": "post",
                "url": 'childcate',
                "data": {
                    parent_id: cocateId,
                    type: "course"
                }, //所需参数和类型
                success: function(d) {
                    var htmls = '';
                    $.each(d, function(index, item) {
                        htmls += '<option value="' + item.category_id + '">' + item.name + '</option>';

                    })
                    console.log(htmls)
                    $("#classsearch-course_id").html(htmls); //返回值输出
                }
            });
        }
</script>
<?php JSRegister::end(); ?>

