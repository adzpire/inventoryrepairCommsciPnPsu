<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;

use kartik\dynagrid\DynaGrid;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dochub\models\InvtRepairSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
.grid-view td {
    white-space: unset;
}
");
?>
<div class="invt-repair-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
        [
            'attribute' => 'status',
            'headerOptions' => [
                'width' => '100px',
            ],
            'format' => 'html',
            'filter' => $searchModel::getItemStatus(),
            'value' => 'statusLabel'
        ],
//            'status',
//            'ir_stID',
//            'ir_tchnID',
//            'ir_date',
        [
            'attribute' => 'ir_date',
            'format' => ['date','long'],
            'headerOptions' => [
                'width' => '150px',
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
        // 'ir_tchndate',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {pdf} {view}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    if($model->status == 0){
                        return Html::a(' '.Html::icon('pencil'), $url, ['data-pjax' => 0, 'title'=>'แก้ไข']);
                    }
                },
                'view' => function ($url, $model, $key) {
                    if($model->status > 0){
                        return Html::a(' '.Html::icon('eye-open'), $url, ['data-pjax' => 0]);
                    }
                },
                /*'pdf' => function ($url, $model, $key) {
                    if(!empty($model->invtRepairDetails)) {
                        return Html::a(' ' . Html::icon('print') . ' ', $url, ['class'=>'btn btn-danger', 'data-pjax' => 0, 'title' => 'พิมพ์', 'target' => '_blank']);
                        }
                    },*/
            ],
            'headerOptions' => [
                'width' => '100px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'จัดการ',
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
		'pjax'=>true,
		'hover'=>true,
		'pager' => [
			'firstPageLabel' => Yii::t('app', 'รายการแรกสุด'),
			'lastPageLabel' => Yii::t('app', 'รายการท้ายสุด'),
		],
		'resizableColumns'=>true,
        'responsiveWrap'=>false,
        'panel'=>[
            'heading'=>'<h3 class="panel-title">'.Html::icon($searchModel::fn()['icon']).' '.Html::encode($this->title).'</h3>',
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
            'after' => false
        ],
        'toolbar' =>  [
            ['content'=>
                Html::a(Html::icon('plus').'แจ้งซ่อมใหม่', ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'เพิ่ม')]).' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagrid}'],
            '{toggleData}',
		],
		
    ],
    'options'=>['id'=>'dynagrid-pp'] // a unique identifier is important
]); ?>

</div>
