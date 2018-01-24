<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

use yii\helpers\Url;

use kartik\grid\GridView;

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

    <div class="col-md-12 form-group text-center">
        <div class="text-center">
            <h4>หมายเหตุ :</h4>
            <ol>
                <li>ถ้ากรณี <span class="text-danger">ยังใช้งานไม่ได้</span> ให้ติ้กเลือก [ใช้งานไม่ได้] แล้วกรอกรายละเอียด </li>
                <li class="text-danger">ถ้ากรณี ใช้งานได้ปกติ ให้ปล่อยว่าง กด [รับคืน] ได้เลย</li>
            </ol>
        </div>
        <div class="padding-xxs">
            <div class="line line-dashed"></div>
            <?php echo $form->field($model, 'ir_returncomment', [
                'horizontalCssClasses' => [
                    'label' => 'col-md-3',
                    'wrapper' => 'col-md-9',
                    //'hint' => 'col-md-3',
                ],
                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><input name="return" type="checkbox" aria-label="Checkbox"> ใช้งานไม่ได้</span>{input}</div>',
            ])->textInput(['placeholder' => 'เช่น ยังเปิดเครื่องไม่ได้']); ?>
            <?= Html::submitButton(Html::icon('circle-arrow-left') . ' รับคืน', ['class' => 'btn btn-lg btn-info blink_me', 'name'=>'backapprv']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
        </div></div></div>
<?php

$this->registerJs("
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

function blinker() {
    $('.blink_me').fadeOut(500);
    $('.blink_me').fadeIn(500);
}

setInterval(blinker, 1000);

", View::POS_READY);

?>