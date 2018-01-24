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
        <h4>รายการข้อมูลพัสดุ/ครุภัณฑ์ที่แจ้ง</h4>
        <?= GridView::widget([
            //'id' => 'kv-grid-demo',
            'dataProvider'=> $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_name'),
                    //$model->irdIvnt->attributeLabels()['invt_name'],
//                        'value' => 'irdIvnt.shortdetail'
                    'value' => function ($model) {
                        return $model->irdIvnt->shortdetail.' <a class="text-primary glyp-size _qdetail" href="invtdet?id='.$model->ird_ivntID.'"><span class="glyphicon glyphicon-info-sign"></span></a>';
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_code'),
                    'value' => 'irdIvnt.invt_code'
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
        ]); ?>
        <?php echo $this->render('_viewbottom', [
            'model' => $model,
            'form' => $form,
        ]); ?>

        <div class="line line-dashed"></div>
        <div class="text-center">
            <h4>ขั้นตอน :</h4>
            <ol>
                <?php
                if(Yii::$app->controller->action->id == 'shopprocapprv'){
                    echo '<li>กรอกข้อมูลร้าน >> [บันทึก]</li>';
                }elseif(Yii::$app->controller->action->id == 'toexec') {
                    echo '<li>กรอกข้อมูลรายละเอียด ผลการดำเนินงานกับร้าน กดปุ่ม <span class="text-danger">[บันทึก]</span> อย่างเดียวก่อน หรือ <span class="text-danger">[บันทึกและเสนอผู้มีอำนาจ]</span> ทันที </li>';
                }
                ?>
            </ol>
        </div>
        <div class="text-center">

            <?php
                echo Html::submitButton(Html::icon('floppy-disk') . ' ' . Yii::t('app', 'บันทึก'), ['class' => (Yii::$app->controller->action->id == 'shopprocapprv') ? 'btn btn-success blink_me' : 'btn btn-success']);
                echo ' ' . Html::a(Html::icon('ban-circle') . ' ' . Yii::t('app', 'ยกเลิก'), Yii::$app->request->referrer, ['class' => 'btn btn-warning']);

                if(Yii::$app->controller->action->id == 'toexec') {
                    echo ' ' .Html::submitButton(Html::icon('arrow-right') . ' บันทึกและเสนอให้ผู้มีอำนาจลงความเห็น', ['class' => 'btn btn-info blink_me', 'name'=>'save&go', 'value'=>'save&go']);
                } ?>
        </div>

        <?php ActiveForm::end(); ?>
	</div>
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

