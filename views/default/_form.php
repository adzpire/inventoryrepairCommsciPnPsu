<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

use yii\helpers\Url;

use kartik\widgets\DatePicker;
use kartik\widgets\Select2;

use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepair */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-repair-form">

    <?php $form = ActiveForm::begin([
			'layout' => 'horizontal', 
			'id' => 'invt-repair-form',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-md-4',
                    'wrapper' => 'col-sm-8',
                ],
            ],
			//'validateOnChange' => true,
            //'enableAjaxValidation' => true,
			//	'enctype' => 'multipart/form-data'
			]); ?>
    <div class="col-md-12 text-right">
        <h3>แบบแจ้งซ่อมครุภัณฑ์</h3>
        <h4>สำนักงาน คณะวิทยาการสื่อสาร</h4>
    </div>
    <div class="col-md-11 col-md-offset-1">
        <div class="col-md-2"><strong>1. แจ้งซ่อม</strong></div>
        <div class="col-md-6 col-md-offset-4">
            <?php $model->ir_date = ($model->isNewRecord) ? date('Y-m-d') : false ;
            echo $form->field($model, 'ir_date', [
                'horizontalCssClasses' => [
                    'label' => 'col-md-5',
                    'wrapper' => 'col-sm-7',
                ],
            ])->widget(DatePicker::classname(), [
                'language' => 'th',
                'options' => ['placeholder' => 'enterdate'],
                //'value' => date('Y-m-d'),
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'todayBtn' => true,
                ]]) ?>
        </div>
    </div>
    <div class="col-md-11 col-md-offset-1">
        <h4>เรียน คณบดี</h4>
    </div>
    <div class="col-md-11 col-md-offset-1">
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'ir_stID', [
                'horizontalCssClasses' => [
                    'label' => 'col-md-3',
                    'wrapper' => 'col-md-9',
                ],
            ])->label('ข้าพเจ้า')->widget(Select2::classname(), [
                'data' => $staff,
                'options' => ['placeholder' => Yii::t('app', 'ค้นหา/เลือก')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => '
                    function() {
                        var str = $(this).val();
                        console.log(str);
                        $.ajax({
                            url: "' . Url::to(['/dochub/default/posinfo']) . '?id="+str,
                            success: function(data){
                                var json = $.parseJSON(data);
                                //$("#content1").html(tmp[0]);
                                //alert(json);
                                $("._posinfo").html(json[0]);
                                $("._telinfo").html(json[1]);
                            }
                        });
                    }',
                ]
            ]);
            ?>
        </div>
        <div class="col-md-6">
            แจ้งซ่อมครุภัณฑ์/อุปกรณ์ เกิดอาการชำรุดดังรายละเอียดต่อไปนี้
        </div>
    </div>

    <?php // $form->field($model, 'ir_tchnID')->textInput() ?>

    <?php /*$form->field($model, 'ir_tchndate')->widget(DatePicker::classname(), [
					'language' => 'th',
					'options' => ['placeholder' => 'enterdate'],
					'type' => DatePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'autoclose'=>true,
						'format' => 'yyyy-mm-dd'
					]])*/ ?>

    <div class="col-md-12 form-group text-center">
        <h4>ขั้นตอน :</h4>
        <ol>
            <li class="text-danger">กด [บันทึก]</li>
        </ol>
        <?= Html::submitButton($model->isNewRecord ? Html::icon('play') . ' ' . Yii::t('app', 'ต่อไป') : Html::icon('floppy-disk') . ' ' . Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php
        echo ' ' . Html::a(Html::icon('ban-circle') . ' ' . Yii::t('app', 'ยกเลิก'), Yii::$app->request->referrer, ['class' => 'btn btn-warning']);
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
