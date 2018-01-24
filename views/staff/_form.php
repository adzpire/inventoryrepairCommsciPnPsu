<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
/*
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
*/
/* @var $this yii\web\View */
/* @var $model backend\modules\inventory\models\InvtCheck */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-check-form">

    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal',
			'id' => 'noteform',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-md-3',
                    'wrapper' => 'col-sm-9',
                ],
            ],
			//'validateOnChange' => true,
            //'enableAjaxValidation' => true,
			//	'enctype' => 'multipart/form-data'
			]); ?>
    <div class="form-group">
        <label class="control-label col-md-3" for="invtrepair-ir_note">ผู้แจ้งซ่อม</label>
        <div class="col-sm-9">
            <?php echo $model->irSt->fullname; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3" for="invtrepair-ir_note">อุปกรณ์ที่แจ้ง</label>
        <div class="col-sm-9">
            <?php echo $model->itemList; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3" for="invtrepair-ir_note">ร้าน/บริษัท</label>
        <div class="col-sm-9">
            <?php echo $model->ir_shopname; ?>
        </div>
    </div>
    <?= $form->field($model, 'ir_note')->textarea(['rows' => 2]) ?>

<?php 		/* adzpire form tips
		$form->field($model, 'wu_tel', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]);
		//file field
				echo $form->field($model, 'file',[
		'addon' => [
       
'append' => !empty($model->wt_image) ? [
			'content'=> Html::a( Html::icon('download').' '.Yii::t('app', 'download'), Url::to('@backend/web/'.$model->wt_image), ['class' => 'btn btn-success', 'target' => '_blank']), 'asButton'=>true] : false
    ]])->widget(FileInput::classname(), [
			//'options' => ['accept' => 'image/*'],
			'pluginOptions' => [
				'showPreview' => false,
				'showCaption' => true,
				'showRemove' => true,
				'initialCaption'=> $model->isNewRecord ? '' : $model->wt_image,
				'showUpload' => false
			]
]);
		*/
 ?>     <div class="form-group text-center">
        <?= Html::submitButton(Html::icon('floppy-disk').' '.Yii::t('app', 'บันทึก'), ['class' => 'btn btn-primary']) ?>

	</div>

    <?php ActiveForm::end(); ?>
	<?php
	$this->registerJs("
$('form#noteform').on('beforeSubmit', function(event){

	var form = $(this);
	$.post(
		form.attr('action'),
		form.serialize()
	).done(function(result){
		if(result == 1){
			form.trigger('reset');
			$.pjax.reload({container:'#shopprocpjax'});
			alert('".Yii::t('app', 'แก้ไขข้อมูลเรียบร้อย')."');
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
