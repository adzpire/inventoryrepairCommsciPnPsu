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
.cus-border {
    border: 1px solid #ddd;
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
        <?php if($model->status == 0){ ?>
        <div class="col-md-11 col-md-offset-1">
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
        </div>
        <?php }else{ ?>
            <div class="col-md-11 col-md-offset-1">
                <h4><span class="glyphicon glyphicon-user"></span> ข้อมูลผู้แจ้งซ่อม</h4>
                <div class="col-md-6 cus-border">
                    <h4>ผู้แจ้ง := <u><?php echo $model->irSt->getFullname();  ?></u></h4>
                </div>
                <div class="col-md-6 cus-border">
                    <h4>วันที่แจ้ง := <u><?php echo \Yii::$app->formatter->asDate($model->ir_date, "long");  ?></u></h4>
                </div>
            </div>
        <?php } ?>
        <?php if($model->status == 2){ ?>
        <div class="col-md-11 col-md-offset-1">
            <h4><span class="glyphicon glyphicon-wrench"></span> ข้อมูลช่างผู้ตรวจ</h4>
            <?php
            echo '<div class="col-md-6 cus-border"><h4>เจ้าหน้าที่ซ่อม := <u>'.$model->irTchn->getFullname().'</u></h4></div>';
            echo '<div class="col-md-6 cus-border"><h4>วันที่เจ้าหน้าที่เช็ค := <u>'.\Yii::$app->formatter->asDate($model->ir_tchndate, "long").'</u></h4></div>';
            ?>
        </div>
        <?php } ?>

            <div class="padding-xxs">
                <div class="line line-dashed"></div>
                <div class="text-center">
                    <h4>ขั้นตอน :</h4>
                    <ol>
                        <?php if($model->status == 0){ ?>
                        <li>ปิดการแก้ไขก่อนเพิ่อไม่ให้ผู้แจ้งแก้ข้อมูล</li>
                        <?php } ?>
                        <li>กรอกการปฏิบัติในแต่ละรายการด้านล่าง <a class="btn btn-danger"><span class="glyphicon glyphicon-pencil"></span></a></li>
                    </ol>
                    <h4>หมายเหตุ :</h4>
                    <ol>
                        <li>ถ้ากรณี <span class="text-danger">ต้องมีการซื้อ/ส่งร้าน</span> ระบบจะแจ้งพัสดุอัตโนมัติหลังจากกรอกการปฏิบัติ [ขอซื้ออะไหล่ทดแทนเพื่อซ่อมเอง] หรือ [ขอส่งซ่อมร้าน]</li>
                        <li>ถ้ากรณี <span class="text-danger">ไม่คุ้มซ่อมหรือ ซ่อมเองโดยไม่ซื้ออะไรเลย</span> ให้กดปุ่มแจ้งผู้มีอำนาจหลังจากกรอกการปฏิบัติ [ซ่อมเองแล้ว] หรือ [ไม่ควรส่งซ่อม]</li>
                    </ol>
                </div>
            </div>
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
//                        'value' => 'irdIvnt.shortdetail'
                    'value' => function ($model) {
                        return $model->irdIvnt->shortdetail.Html::a(Html::icon('info-sign'), ['invtdet', 'id'=>$model->ird_ivntID], [
                                'class' => 'text-primary glyp-size _qdetail',
                                'data-pjax' => 0,
                            ]);
                    },
                    'format' => 'raw',
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
//            [
//                'attribute' => 'ird_ivntID',
//                'label' => $mdlmain->getAttributeLabel('invt_locationID'),
//                'value' => 'irdIvnt.invtLocation.loc_name'
//            ],
                'ird_symptom',

                //'ird_tchnchoice',
                [
                    'attribute' => 'ird_tchnchoice',
                    //'label' => $mdlmain->getAttributeLabel('invt_locationID'),
                    'value' => 'statusLabel'
                ],
                // 'ird_tchncomment',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{updatedetailfull}',
                    'buttons' => [
                        'updatedetailfull' => function ($url, $model, $key) {
                            if($model->irdIr->status < 2){
                                return '<span class="blink_me">ช่างรับทราบก่อน</span>';
                            }else{
                                return Html::a(Html::icon('pencil'), $url, [
                                    'class' => (!isset($model->ird_tchnchoice)) ? '_qeditdetail btn btn-danger blink_me' : '_qeditdetail btn btn-danger',
                                    'data-pjax' => 0,
                                ]);
                            }
                        },
//                    'deletedetail' => function ($url, $model, $key) {
//                        return Html::a(Html::icon('trash'), $url, [
//                            'class' => '_qdeletedetail',
//                            'data-pjax' => 0,
//                        ]);
//                    },
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
            'panel' => [
                'type' => GridView::TYPE_DANGER,
                'heading' => Html::icon('th-list') . 'กรอกการตรวจแต่ละรายการ ',
                'before' => ($model->status < 2) ? '<p>'.Html::a(Html::icon('list') . ' ' . Yii::t('app', 'เพิ่มรายการ'), ['qadddetail', 'id' => $model->ir_id], ['class' => 'btn btn-default _qadddetail','data-pjax' => 0,]).' </p><span class="text-danger">โปรดระวัง ระบบจะเปลี่ยนสถานะรายการอัตโนมัติเมื่อเลือก [ขอซื้ออะไหล่ทดแทนเพื่อซ่อมเอง] หรือ [ขอส่งซ่อมร้าน]</span>' : '<span class="text-danger">โปรดระวัง ระบบจะเปลี่ยนสถานะรายการอัตโนมัติเมื่อเลือก [ขอซื้ออะไหล่ทดแทนเพื่อซ่อมเอง] หรือ [ขอส่งซ่อมร้าน]</span>',
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
        <?php
        echo Html::a(Html::icon('duplicate') . ' ' . Yii::t('app', 'แยกรายการ'), ['split', 'id' => $model->ir_id], ['class' => 'btn btn-lg btn-success', 'data-pjax' => 0,]).' ';
        if($model->status == 0){
            echo Html::submitButton(Html::icon('wrench') . 'ช่างรับทราบและปิดการแก้ไข', ['class' => 'btn btn-lg btn-info blink_me', 'name'=>'save&go']);
        }elseif($model->status == 1){
            echo Html::submitButton(Html::icon('wrench') . 'ช่างรับทราบ', ['class' => 'btn btn-lg btn-primary blink_me', 'name'=>'save&go']);
        }
        //echo Html::submitButton(Html::icon('lock') . ' แจ้งงานพัสดุ(ซื้อ/ส่งร้าน)', ['class' => 'btn btn-lg btn-info', 'name'=>'save&go']);
        ?>
        <?php
        if($model->status == 2){
//            echo Html::submitButton(Html::icon('forward') . ' ช่างแจ้งพัสดุ(ซื้ออะไหล่/ส่งซ่อมร้าน)', ['class' => 'btn btn-lg btn-default',
//                'data' => [
//                    'confirm' => 'ดำเนินการต่อ? กรุณาตรวจสอบว่ากรอกผลตรวจว่าครบทุกรายการหรือไม่',
//                    //'method' => 'post',
//                ]]);
            echo Html::a( Html::icon('forward').' '.' ช่างแจ้งพัสดุ(ซื้ออะไหล่/ส่งซ่อมร้าน)', ['index'], [
                'class' => 'btn btn-lg btn-default',
                'data' => [
                    'confirm' => 'ดำเนินการต่อ? กรุณาตรวจสอบว่ากรอกผลตรวจว่าครบทุกรายการหรือไม่',
                ]]);
            echo ' '.Html::submitButton(Html::icon('level-up') . ' ช่างแจ้งผู้มีอำนาจรับทราบ(ซ่อมเอง/ไม่คุ้มซ่อม)', ['class' => 'btn btn-lg btn-info', 'name'=>'techcomplete',
                    'data' => [
                        'confirm' => 'ดำเนินการต่อ? กรุณาตรวจสอบว่ากรอกผลตรวจว่าครบทุกรายการหรือไม่',
                        //'method' => 'post',
                    ]]);
        }
        ?>
    </div>
        <?php ActiveForm::end(); ?>
	</div>
</div>

</div>
<div class="invt-repair-detail-index">

    <h3><span class="glyphicon glyphicon-hourglass"></span> ข้อมูลประวัติการซ่อมของอุปกรณ์</h3>
    <?php //print_r($searchitemlist[1314]->irdIvnt->shortdetail);exit();
    foreach ($dataProviderlist as $key => $value){
        echo '<h4>'.$searchitemlist[$key]->irdIvnt->shortdetail.' ('.$searchitemlist[$key]->irdIvnt->invt_code.')</h4>';
        echo GridView::widget([
            //'id' => 'kv-grid-demo',
            'dataProvider'=> $value,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                /*            [
                                'attribute' => 'ird_ivntID',
                                'label' => $mdlmain->getAttributeLabel('invt_name'),
                                //$model->irdIvnt->attributeLabels()['invt_name'],
                                'value' => 'irdIvnt.shortdetail'
                            ],*/
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $model->getAttributeLabel('ir_code'),
                    'format' => 'html',
                    'value' => function ($model) {
                        return $model->irdIr->ir_code.' <a class="text-success glyp-size _qrepdetail" href="invtdet?id='.$model->ird_irID.'"><span class="glyphicon glyphicon-info-sign"></span></a>';
                    },
                ],
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $model->getAttributeLabel('ir_stID'),
                    'value' => 'irdIr.irSt.fullname'
                ],
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_locationID'),
                    'value' => 'irdIvnt.invtLocation.loc_name'
                ],
                'ird_symptom',

                //'ird_tchnchoice',
                'ird_tchncomment',
            ],
            'pager' => [
                'firstPageLabel' => 'รายการแรกสุด',
                'lastPageLabel' => 'รายการท้ายสุด',
            ],
            'responsive'=>true,
            'hover'=>true,
            'toolbar' => false,
            'panel' => false,
            //'beforeGrid' => $searchitemlist[$key]->irdIvnt->shortdetail,
        ]);
    }

    ?>
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
    
$(document).on('click', '._qadddetail', function(event){
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

