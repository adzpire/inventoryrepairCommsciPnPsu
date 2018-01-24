<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

use yii\helpers\Url;

use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;

use yii\widgets\Pjax;

use yii\web\View;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepair */
//print_r($invtlist);exit();
$this->params['breadcrumbs'][] = ['label' => $model::fn()['name'], 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ir_id, 'url' => ['view', 'id' => $model->ir_id]];
$this->params['breadcrumbs'][] = 'อัพเดต';


$this->registerCss('
.grid-view td {
    white-space: unset;
}
.cus-border {
    border: 1px solid #ddd;
}
');
?>
<div class="invt-repair-update">

    <div class="panel panel-warning">
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

            <?php echo $this->render('_viewtop', [
                'model' => $model,
            ]); ?>
            <?= GridView::widget([
                //'id' => 'kv-grid-demo',
                'dataProvider'=> $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'ird_ivntID',
                        'label' => $mdlmain->getAttributeLabel('invt_name'),
                        //$model->irdIvnt->attributeLabels()['invt_name'],
                        'value' => 'irdIvnt.shortdetail'
                    ],
                    [
                        'attribute' => 'ird_ivntID',
                        'label' => $mdlmain->getAttributeLabel('invt_code'),
                        'value' => 'irdIvnt.invt_code'
                    ],
//                    [
//                        'attribute' => 'ird_ivntID',
//                        'label' => $mdlmain->getAttributeLabel('invt_locationID'),
//                        'value' => 'irdIvnt.invtLocation.loc_name'
//                    ],
                    'ird_symptom',

                    //'ird_tchnchoice',
                    [
                        'attribute' => 'ird_tchnchoice',
                        'value' => 'statuslabel'
                    ],
//                    'ird_tchncomment',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{changestat}',
                        'buttons' => [
                            'changestat' => function ($url, $model, $key) {
                                return Html::a(Html::icon('info-sign').'สถานะ', ['changestat', 'id'=>$model->ird_ivntID], [
                                    //'value' => Url::to(['changestat', 'id'=>$model->ird_ivntID]),
                                    'class' => '_chngstat btn btn-danger blink_me',
                                    'data-pjax' => 0,
                                ]);
                            },
                        ],
                        'headerOptions' => [
                            'width' => '50px',
                        ],
                        'header' => 'จัดการ',
                    ],
                ],
                'pager' => [
                    'firstPageLabel' => 'รายการแรกสุด',
                    'lastPageLabel' => 'รายการท้ายสุด',
                ],
                'responsive'=>true,
                'hover'=>true,
                'toolbar' => false,
                'panel' => false,
            ]); ?>
            <?php echo $this->render('_viewbottom', [
                'model' => $model,
            ]); ?>
            <div class="col-md-12 form-group text-center">
                <div class="padding-xxs">
                    <div class="text-center">
                        <h4>หมายเหตุ :</h4>
                        <ol>
                            <li class="text-danger">กรุณาตรวจสอบสถานะของอุปกรณ์ ที่ปุ่มด้านบน [สถานะ] ก่อน</li>
                            <li class="text-danger">กดปุ่ม [แจ้งคืน] พร้อมแจ้งให้ ผู้แจ้งซ่อม กด [รับคืน]</li>
                        </ol>
                    </div>
                    <div class="line line-dashed"></div>
                    <?php if(Yii::$app->controller->action->id == 'execprocapprv') {
                        echo Html::submitButton(Html::icon('arrow-left') . ' แจ้งรับคืนหลังร้านซ่อม', ['class' => 'btn btn-lg btn-info', 'name' => 'sendback']);
                    }elseif(Yii::$app->controller->action->id == 'techprocapprv') {
                        echo Html::submitButton(Html::icon('arrow-left') . ' แจ้งรับคืนหลังซ่อมเอง', ['class' => 'btn btn-lg btn-info', 'name' => 'sendback']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>
<?php
Modal::begin([
    'id' => 'modal',
    'header' => 'เพิ่มรายการ',
]);
echo '<div id ="modalcontent"></div>';
Modal::end();
?>
<?php

$this->registerJs("
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

function blinker() {
    $('.blink_me').fadeOut(500);
    $('.blink_me').fadeIn(500);
}

setInterval(blinker, 1000);

$(document).on('click', '._qdetail', function(event){
		event.preventDefault();
		//alert($(this).attr('href'));
		$('.modal-header').text( \"เพิ่มรายการ\" );
		$('#modal').modal('show')
		.find('#modalcontent')
		.load($(this).attr('href'));
			return false;//just to see what data is coming to js
    });

$(document).on('click', '._qeditdetail', function(event){
		event.preventDefault();
        $('.modal-header').text( \"แก้ไขรายการ\" );
		$('#modal').modal('show')
		.find('#modalcontent')
		.load($(this).attr('href'));
			return false;//just to see what data is coming to js
    });

$(document).on('click', '._chngstat', function(event){
    event.preventDefault();
    $('.modal-header').text( \"แก้ไขสถานะ\" );
	$('#modal').modal('show')
	.find('#modalcontent')
	.load($(this).attr('href'));
        return false;
    });
", View::POS_READY);

?>