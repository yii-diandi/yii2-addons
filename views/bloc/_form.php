<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-30 21:44:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-20 22:49:46
 */
use common\helpers\LevelTplHelper;
use common\models\DdRegion;
use yii\helpers\Html;
use common\widgets\MyActiveForm;
use diandi\addons\models\enums\RegisterLevelStatus;
use richardfan\widget\JSRegister;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use function PHPSTORM_META\map;

$region = new DdRegion();
$Helper = new LevelTplHelper([
    'pid' => 'pid',
    'cid' => 'id',
    'title' => 'name',
    'model' => $region,
    'id' => 'id',
]);
/* @var $this yii\web\View */
/* @var $model backend\modules\bloc\models\Bloc */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bloc-form">

    <?php $form = MyActiveForm::begin(); ?>

    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
        <?= $form->field($model, 'business_name')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'pid')->dropDownlist(ArrayHelper::map($parents, 'bloc_id', 'business_name'), [
            'prompt' => ['text' => '所属集团', 'options' => ['value' => 0]],
        ]); ?>

            
        <?= $form->field($model, 'province')->dropDownList($Helper->courseCateMap(), [
            'prompt' => ['text' => '省份', 'options' => ['value' => 0]],
            'label' => '省份',
            'id' => 'classsearch-cocate_id',
        ])->label('省份'); ?>

        <?= $form->field($model, 'city')->dropDownList($Helper->courseMap($model->city), [
            // 'options' => ['5' => ['selected' => true]],
            'prompt' => ['text' => '城市', 'options' => ['value' => 0]],

            'id' => 'classsearch-course_id',
        ])->label('城市 '); ?>

        <?= $form->field($model, 'district')->dropDownList($Helper->courseMap($model->district), [
            // 'options' => ['5' => ['selected' => true]],
            'prompt' => ['text' => '区县', 'options' => ['value' => 0]],

            'id' => 'classsearch-course2_id',
        ])->label('区县'); ?>

        
        <?= $form->field($model, 'register_level')->radioList(RegisterLevelStatus::listData()); ?>


        <?= $form->field($model, 'avg_price')->textInput(); ?>

        <?= $form->field($model, 'recommend')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'special')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'introduction')->textInput(['maxlength' => true]); ?>



    </div>

    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
        <?= $form->field($model, 'open_time')->textInput(['maxlength' => true]); ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]); ?>


        <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'status')->textInput()->hiddenInput(['value'=>intval($model->status)])->label(false); ?>
        
        
        <?= $form->field($model, 'store_id')->dropDownList(ArrayHelper::map($stores,'store_id','name'))->label('主营商户'); ?>
        <?= $form->field($model, 'license_no')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'license_name')->textInput(['maxlength' => true]); ?>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-block']); ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>

<?php JSRegister::begin([
    'id' => 'area',
]); ?>
<script>
    //分类
    $("#classsearch-cocate_id").change(function() {
        var cocateId = $(this).val(); //获取一级目录的值
        console.log(cocateId)
        if (cocateId > 0) {
            getCourse(cocateId, 'classsearch-course_id', '选择城市'); //查询二级目录的方法
        }
    });
    $("#classsearch-course_id").change(function() {
        var cocateId = $(this).val(); //获取一级目录的值

        console.log(cocateId)
        if (cocateId > 0) {
            getCourse(cocateId, 'classsearch-course2_id', '选择地区'); //查询三级目录的方法

        }
    });


    function getCourse(cocateId, ids, initTitle) {
        var href = "<?= Url::to(['/system/index/childcate']); ?>"; //请求的地址
        $.ajax({
            "type": "post",
            "url": href,
            "data": {
                parent_id: cocateId,
                type: "course"
            }, //所需参数和类型
            success: function(d) {
                var htmls = "<option value=\"\">" + initTitle + "</option>";
                $.each(d, function(index, item) {
                    htmls += '<option value="' + item.id + '">' + item.name + '</option>';

                })
                console.log(htmls)
                $("#" + ids).html(htmls); //返回值输出
            }
        });
    }
</script>
<?php JSRegister::end(); ?>