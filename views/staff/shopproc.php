<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\InvtCheckcommitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
.grid-view td {
    white-space: unset;
}
');
?>
<?php Pjax::begin(['id' => 'shopprocpjax']); ?>
<?= GridView::widget([
    //'id' => 'kv-grid-demo',
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

//            'ir_id',
        [
            'attribute' => 'ir_id',
            'headerOptions' => [
                'width' => '50px',
            ],
        ],
//        [
//            'attribute' => 'status',
//            'headerOptions' => [
//                'width' => '50px',
//            ],
//            'format' => 'html',
//            'filter' => $searchModel::getItemStatus(),
//            'value' => 'statusLabel'
//        ],
//            'status',
//            'ir_stID',
//            'ir_tchnID',
//            'ir_date',
        [
            'attribute' => 'ir_date',
            'format' => ['date','long'],
            'headerOptions' => [
                'width' => '120px',
            ],
        ],
        [
            'attribute' => 'ir_id',
            'label' => 'รายการที่แจ้ง',
//                'headerOptions' => [
//                    'width' => '150px',
//                ],
            'format' => 'html',
            'filter' =>false,
            'enableSorting' =>false,
            'value' => function($data) {
                return $data->itemList;
            },

        ],
        [
            'attribute' => 'ir_id',
            'label' => 'ความเห็นจากเจ้าหน้าที่',
//                'headerOptions' => [
//                    'width' => '150px',
//                ],
            'format' => 'html',
            'filter' =>false,
            'enableSorting' =>false,
            'value' => function($data) {
                return $data->choiceList;
            },
        ],
        [
            'attribute' => 'ir_stID',
            'value' => 'irSt.fullname',
            'filter' =>false,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{shopprocapprv} {shoptchn}',
            'buttons' => [
                'shopprocapprv' => function ($url, $model, $key) {
                    if(Yii::$app->controller->action->id == 'shopproc') {
                        return Html::a(' ' . Html::icon('resize-horizontal'), $url, ['class' => 'btn btn-default', 'title' => 'พัสดุ']);
                    }
                },
                'shoptchn' => function ($url, $model, $key) {
                    if(Yii::$app->controller->action->id == 'shoptechnic') {
                        return Html::a(' ' . Html::icon('comment') . '', $url, ['class' => 'btn btn-primary', 'title' => 'พัสดุ']);
                    }
                },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => (Yii::$app->controller->action->id !== 'shoptechnic') ? 'ร้าน' : 'ช่าง',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{toexec}',
            'buttons' => [
                'toexec' => function ($url, $model, $key) {
                    if(Yii::$app->controller->action->id == 'shopproc') {
                        return Html::a(' ' . Html::icon('comment'), $url, ['class' => 'btn btn-success', 'title' => 'พัสดุ']);
                    }
                },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'เสนอ',
            'visible' => Yii::$app->controller->action->id !== 'shoptechnic',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{note}',
            'buttons' => [
                'note' => function ($url, $model, $key) {
                    if(Yii::$app->controller->action->id == 'shopproc') {
                        return Html::a( Html::icon('info-sign'), $url, ['class' => 'btn btn-primary _qadddetail', 'title' => 'พัสดุ', 'data-pjax' => 0]);
                    }
                },
            ],
            'headerOptions' => [
                'width' => '70px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'ข้อความ',
            'visible' => Yii::$app->controller->action->id !== 'shoptechnic',
        ],
    ],
    'pager' => [
        'firstPageLabel' => 'รายการแรกสุด',
        'lastPageLabel' => 'รายการท้ายสุด',
    ],
    'responsive'=>true,
    'hover'=>true,
    'toolbar'=> [
        ['content'=>
           // Html::a(Html::icon('plus').'สร้างแบบฟอร์มใหม่', ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'เพิ่ม')]).' '.
           // Html::a(Html::icon('info-sign').'แสดงตัวอย่่าง', ['pdf?id=example'], ['class'=>'btn btn-danger', 'title'=>Yii::t('app', 'แสดงตัวอย่่าง'), 'target'=>'_blank']).' '.
            Html::a(Html::icon('repeat'), ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
        ],
        '{toggleData}',
    ],
    'panel'=>[
        'type'=>GridView::TYPE_INFO,
        'heading'=> Html::icon('bitcoin').' '.Html::encode($this->title),
    ],
]); ?>
<?php Pjax::end(); ?>
<?php
Modal::begin([
    'id' => 'modal',
    'header' => 'จดบันทึก',
]);
echo '<div id ="modalcontent"></div>';
Modal::end();
?>
<?php

$this->registerJs("
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$(document).on('click', '._qadddetail', function(event){
		event.preventDefault();
//		alert($(this).attr('href'));
//		$('.modal-header').text( \"เพิ่มรายการ\" );
		$('#modal').modal('show')
		.find('#modalcontent')
		.load($(this).attr('href'));
			return false;//just to see what data is coming to js
    });

", View::POS_READY);

?>
