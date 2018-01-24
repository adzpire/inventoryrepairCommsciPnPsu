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
');
?>
<div class="invt-repair-update">

<div class="panel panel-warning">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('edit').' '.Html::encode($this->title) ?></span>
		<?php  /*Html::a( Html::icon('fire').' '.'ลบ', ['delete', 'id' => $model->ir_id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูล?',
                'method' => 'post',
            ],
        ])*/ ?>
		<?php // Html::a( Html::icon('pencil').' '.'สร้างใหม่', ['create'], ['class' => 'btn btn-info panbtn']) ?>
	</div>
	<div class="panel-body">
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
            <h3>แบบแจ้งซ่อมครุภัณฑ์ หมายเลข <strong><u><?php echo $model->ir_code; ?></u></strong></h3>
            <h4>สำนักงาน คณะวิทยาการสื่อสาร</h4>
        </div>
        <div class="col-md-11 col-md-offset-1">
            <div class="col-md-2"><strong>1. แจ้งซ่อม</strong></div>
            <div class="col-md-6 col-md-offset-4">
                <?= $form->field($model, 'ir_date', [
                    'horizontalCssClasses' => [
                        'label' => 'col-md-5',
                        'wrapper' => 'col-sm-7',
                    ],
                ])->widget(DatePicker::classname(), [
                    'language' => 'th',
                    'options' => ['placeholder' => 'enterdate'],
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
//                echo $form->field($model, 'ir_stID')->dropDownList($staff, ['prompt'=>'ค้นหา/เลือก']);
                echo $form->field($model, 'ir_stID', [
                    'horizontalCssClasses' => [
                        'label' => 'col-md-3',
                        'wrapper' => 'col-md-9',
                    ],
                ])->label('ข้าพเจ้า')->widget(Select2::classname(), [
                    'data' => $staff,
                    'options' => ['placeholder' => 'ค้นหา/เลือก'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
//                    'pluginEvents' => [
//                        "change" => '
//                    function() {
//                        var str = $(this).val();
//                        console.log(str);
//                        $.ajax({
//                            url: "' . Url::to(['/dochub/default/posinfo']) . '?id="+str,
//                            success: function(data){
//                                var json = $.parseJSON(data);
//                                //$("#content1").html(tmp[0]);
//                                //alert(json);
//                                $("._posinfo").html(json[0]);
//                                $("._telinfo").html(json[1]);
//                            }
//                        });
//                    }',
//                    ]
                ]);
                ?>
            </div>
            <div class="col-md-6">
                แจ้งซ่อมครุภัณฑ์/อุปกรณ์ เกิดอาการชำรุดดังรายละเอียดต่อไปนี้
            </div>
        </div>

        <div class="col-md-12 form-group text-center">
            <?= Html::submitButton(Html::icon('floppy-disk') . ' ' . Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php
            echo ' ' . Html::a(Html::icon('ban-circle') . ' ' . Yii::t('app', 'ยกเลิก'), Yii::$app->request->referrer, ['class' => 'btn btn-warning']);
            ?>
        <?php Pjax::begin(['id' => 'detailpjax']); ?>
        <?= GridView::widget([
            //'id' => 'kv-grid-demo',
            'dataProvider'=> $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'ird_id',
                //'ird_irID',
//            'ird_ivntID',
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_name'),
                    //$model->irdIvnt->attributeLabels()['invt_name'],
                    'value' => 'irdIvnt.shortdetail'
                ],
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_code'),
//                'label' => function ($data) {
//                    return $data->irdIvnt->attributeLabels()['invt_code'];
//                },
//                $model->irdIvnt->attributeLabels()['invt_code'],
                    'value' => 'irdIvnt.invt_code'
                ],
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_locationID'),
                    'value' => 'irdIvnt.invtLocation.loc_name'
                ],
                'ird_symptom',

                //'ird_tchnchoice',
                // 'ird_tchncomment',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{updatedetail} {deletedetail}',
                    'buttons' => [
                        'updatedetail' => function ($url, $model, $key) {
                            return Html::a(Html::icon('pencil'), $url, [
                                'class' => '_qeditdetail btn btn-default',
                                'data-pjax' => 0,
                            ]);
                        },
//                    'deletedetail' => function ($url, $model, $key) {
//                        return Html::a(Html::icon('trash'), $url, [
//                            'class' => '_qdeletedetail btn btn-danger',
//                            'data-pjax' => 0,
//                        ]);
//                    },
                    ],
                    'headerOptions' => [
                        'width' => '50px',
                    ],
                ],
            ],
            'pager' => [
                'firstPageLabel' => 'รายการแรกสุด',
                'lastPageLabel' => 'รายการท้ายสุด',
            ],
            'responsive'=>true,
            'hover'=>true,
            'toolbar' => false,
            'panel' => [
                'type' => GridView::TYPE_INFO,
                'heading' => Html::icon('th-list') . ' รายการรายละเอียด ',
                'before' => Html::a(Html::icon('list') . ' ' . Yii::t('app', 'เพิ่มรายการ'), ['qadddetail', 'id' => $model->ir_id], ['class' => ($dataProvider->totalCount >0) ? 'btn btn-success _qdetail' : 'btn btn-success _qdetail blink_me', 'data-pjax' => 0]),
                'beforeOptions' => ['class'=>'text-center kv-panel-before'],
            ],
        ]); ?>
        <?php 	 /* adzpire grid tips
		[
				'attribute' => 'id',
				'headerOptions' => [
					'width' => '50px',
				],
			],
		[
		'attribute' => 'we_date',
		'value' => 'we_date',
			'filter' => DatePicker::widget([
					'model'=>$searchModel,
					'attribute'=>'date',
					'language' => 'th',
					'options' => ['placeholder' => Yii::t('app', 'enterdate')],
					'type' => DatePicker::TYPE_COMPONENT_APPEND,
					'pickerButton' =>false,
					//'size' => 'sm',
					//'removeButton' =>false,
					'pluginOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd'
					]
				]),
			//'format' => 'html',
			'format' => ['date']

		],
		[
			'attribute' => 'we_creator',
			'value' => 'weCr.userPro.nameconcatened'
		],
	 */
        ?> <?php Pjax::end(); ?>
        <div class="text-center">
                <?php if($model->status < 1){
                    echo Html::submitButton(Html::icon('lock') . ' รับทราบและปิดการแก้ไข', ['class' => 'btn btn-lg btn-info blink_me', 'name'=>'save&go']);
                } ?>

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
//		alert($(this).attr('href'));
        $('.modal-header').text( \"แก้ไขรายการ\" );
		$('#modal').modal('show')
		.find('#modalcontent')
		.load($(this).attr('href'));
			return false;//just to see what data is coming to js
    });

$(document).on('click', '._qdeletedetail', function(event){
		event.preventDefault();
		if(confirm('sure?')){
            $.get(
                $(this).attr('href')
            ).done(function(result){
                if(result == 1){
                    alert('ลบเรียบร้อย เปลี่ยนสถานะอุปกรณ์เป็นใช้งานได้');
                    $.pjax.reload({container:'#detailpjax'});
                }else{
                    alert(result);
                }
            }).fail(function(result){
                alert('server error');
            });
		}	
        return false;
    });

", View::POS_READY);

?>

