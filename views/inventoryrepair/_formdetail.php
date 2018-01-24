<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
/*
use kartik\widgets\ActiveForm;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-repair-detail-form">

    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal',
			'id' => 'qadddetail',
			'fieldConfig' => [
				  'horizontalCssClasses' => [
						'label' => 'col-md-4',
						'wrapper' => 'col-sm-8',
				  ],
			 ],
			]); ?>

    <?php
//        echo $form->field($model, 'ird_ivntID')->widget(Select2::classname(), [
//            'data' => $invtlist,
//            'options' => ['placeholder' => 'กรุณาเลือก...'],
//            'pluginOptions' => [
//                'allowClear' => true
//            ],
//        ]);
    ?>

    <?php
    echo $form->field($model, 'ird_ivntID')->widget(Select2::classname(), [
//        'initValueText' => ($model->isNewRecord ? false : $model->IrdIvnt->concatened),  //set the initial display text
        'options' => ['placeholder' => 'พิมพ์ 3 ตัวอักษรขึ้นไปเพื่อค้นหา ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'กำลังค้นหา...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['invtlist']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(ird_ivntID) { return ird_ivntID.text; }'),
            'templateSelection' => new JsExpression('function (ird_ivntID) { return ird_ivntID.text; }'),
        ],
    ]);
    ?>

    <?= $form->field($model, 'ird_symptom')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton(Html::icon('floppy-disk').' '.Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>

	</div>

    <?php ActiveForm::end(); ?>

    <?php
    $this->registerJs("
$('form#qadddetail').on('beforeSubmit', function(event){

	var form = $(this);
	$.post(
		form.attr('action'),
		form.serialize()
	).done(function(result){
		if(result == 1){
			form.trigger('reset');
			$.pjax.reload({container:'#detailpjax'});
			alert('เปลี่ยนสถานะอุปกรณ์เป็นชำรุด');
			$('#modal').modal('hide');
		}else{
			alert(result);
		}
	}).fail(function(result){
		alert('server error');
	});
	return false;
});
", View::POS_END);
    ?>
</div>
