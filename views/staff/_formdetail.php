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
						'label' => 'col-md-3',
						'wrapper' => 'col-sm-9',
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
    if($model->isNewRecord){
        echo $form->field($model, 'ird_ivntID')->widget(Select2::classname(), [
            'initValueText' => ($model->isNewRecord ? false : $model->irdIvnt->shortdetail),  //set the initial display text
            'options' => ['placeholder' => 'พิมพ์ ชื่อ/ยี่ห้อรุ่น/รหัส 3 ตัวอักษรขึ้นไปเพื่อค้นหา ...'],
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
    }else{
        echo '<div class="form-group"><label class="control-label col-md-3">อุปกรณ์</label><div class="col-sm-9">';
        echo '<p>'.$model->irdIvnt->shortdetail.'</p>';
        echo '</div></div>';
        echo '<div class="form-group"><label class="control-label col-md-3">รหัส</label><div class="col-sm-9">';
        echo '<p>'.$model->irdIvnt->invt_code.'</p>';
        echo '</div></div>';
    }
    ?>

    <?= $form->field($model, 'ird_symptom')->textInput(['maxlength' => true]) ?>

    <?php
    if(Yii::$app->controller->action->id == 'updatedetailfull') {
        //echo $form->field($model, 'ird_tchnchoice')->textInput(['maxlength' => true]);
        echo $form->field($model, 'ird_tchnchoice', [
            'horizontalCssClasses' => [
                'label' => 'col-md-3',
                'wrapper' => 'col-md-6',
                'hint' => 'col-md-3',
            ],
        ])->radioList(
            $model::getTechStatus(),
            ['encode'=>false]
        )->hint('<span class="text-danger">ถ้าเลือกซ่อมเองสถานะพัสดุจะเปลี่ยนเป็นใช้งานได้</span>');
        echo $form->field($model, 'ird_tchncomment')->textInput(['maxlength' => true]);
    }
    ?>

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
		if(result != 0){
			form.trigger('reset');
			$.pjax.reload({container:'#detailpjax'});
			if(result ==1){
                alert('ซ่อมแล้วเปลี่ยนสถานะอุปกรณ์เป็นใช้งานได้');
			}			
			$('#modal').modal('hide');
		}else{
			//alert(result);
		}
	}).fail(function(result){
		alert('server error');
	});
	return false;
});
", View::POS_END);
    ?>
</div>
