<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;
use kartik\dynagrid\DynaGrid;
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
<?= DynaGrid::widget([
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
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
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
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
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
            'order'=>DynaGrid::ORDER_FIX_RIGHT,
        ],
    ],	
    'theme'=>'panel-info',
    'showPersonalize'=>true,
	'storage' => 'session',
	'toggleButtonGrid' => [
		'label' => '<span class="glyphicon glyphicon-wrench">ปรับแต่งตาราง</span>'
	],
    'gridOptions'=>[
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        // 'showPageSummary'=>true,
        // 'floatHeader'=>true,
		// 'pjax'=>true,
		'hover'=>true,
		'pager' => [
			'firstPageLabel' => Yii::t('app', 'รายการแรกสุด'),
			'lastPageLabel' => Yii::t('app', 'รายการท้ายสุด'),
		],
		'resizableColumns'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=> Html::icon('comment').' '.Html::encode($this->title),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagrid}'],
            '{toggleData}',
		],
		
    ],
    'options'=>['id'=>'dynagrid-irstaffshopproc'] // a unique identifier is important
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
