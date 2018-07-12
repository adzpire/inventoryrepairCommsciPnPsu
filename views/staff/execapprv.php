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
.glyp-size {
    font-size: 20px;
    vertical-align: middle;
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
                        'attribute' => 'ird_ivntLoc',
                        // 'label' => $data->getAttributeLabel('ird_ivntLoc'),
                        'value' => 'irdLoc.loc_name'
                    ],          
                    'ird_symptom',

                    //'ird_tchnchoice',
                    [
                        'attribute' => 'ird_tchnchoice',
                        'value' => 'statuslabel'
                    ],
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
                'summary' => false,
                //'beforeHeader' => 'test',
            ]); ?>
            <?php echo $this->render('_viewbottom', [
                'model' => $model,
                'form' => $form,
            ]); ?>
    <div class="col-md-12 form-group text-center">
        <div class="padding-xxs">
            <div class="line line-dashed"></div>
            <div class="text-center">
                <h4>หมายเหตุ :</h4>
                <ol>
                    <li>ถ้ากรณี <span class="text-danger">ไม่อนุมัติ</span> ต้องกรอกความเห็นด้วย</li>
                </ol>
            </div>
            <?= $form->field($model, 'ir_execcomment')->textInput(['maxlength' => true]) ?>
            <?= Html::submitButton(Html::icon('play') . ' ทราบ/อนุมัติ', ['class' => 'btn btn-lg btn-info', 'name'=>'apprv']) ?>
            <?= Html::submitButton(Html::icon('stop') . ' ไม่อนุมัติ', ['class' => 'btn btn-lg btn-danger', 'name'=>'notapprv', 'data' => [ 'confirm' => 'ท่านต้องการไม่อนุมัตืใช่หรือไม่? กรุณาลงความเห็นการไม่อนุมัติด้วย', ],]) ?>
            <?= Html::submitButton(Html::icon('backward') . ' คืนพัสดุแก้ไข', ['class' => 'btn btn-lg btn-warning', 'name'=>'sendback',]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
        </div></div></div>
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

<?php
Modal::begin([
    'id' => 'modal',
    'header' => 'รายละเอียดอุปกรณ์',
]);
echo '<div id ="modalcontent"></div>';
Modal::end();
?>
<?php

$this->registerJs("
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$(document).on('click', '._qdetail', function(event){
		event.preventDefault();
		//alert($(this).attr('href'));		
		$('#modal').modal('show')
		.find('#modalcontent')
		.load($(this).attr('href'));
			return false;//just to see what data is coming to js
    });

", View::POS_READY);

?>
