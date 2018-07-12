<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepair */

?>
<div class="invt-repair-create">

    <div class="panel panel-primary">
		<div class="panel-heading">
			<span class="panel-title"><?= Html::icon('edit').' '.Html::encode($this->title) ?></span>
		</div>
		<div class="panel-body">

			<?php $form = ActiveForm::begin([
			'layout' => 'horizontal', 
			'id' => 'invt-repair-form',
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
				<label class="control-label col-sm-3">ผู้แจ้ง</label>
				<div class="col-sm-9">
					<p><?php echo Yii::$app->user->identity->profile->fullname; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">วันที่แจ้ง</label>
				<div class="col-sm-9">
					<p><?php echo Yii::$app->formatter->asDate(date('Y-m-d'), "long"); ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">อุปกรณ์ (รหัส, ที่อยู่ปัจจุบัน)</label>
				<div class="col-sm-9">
					<p><?php echo $invt->concatened; ?></p>
				</div>
			</div>

			<?= $form->field($detailmdl, 'ird_symptom')->textInput(['maxlength' => true, 'placeholder' => 'เช่น เครื่องเปิดไม่ติด, โปรแกรมใช้งานไม่ได้']) ?>

			<div class="col-md-12 form-group text-center">
				<?= Html::submitButton( Html::icon('play') . ' แจ้งซ่อม ', ['class' =>'btn btn-success']) ?>
				<?php
				echo ' ' . Html::a(Html::icon('ban-circle') . ' ' . Yii::t('app', 'ยกเลิก'), Yii::$app->request->referrer, ['class' => 'btn btn-warning']);
				?>
			</div>
			<?php ActiveForm::end(); ?>
    	
		</div>
	</div>

</div>
