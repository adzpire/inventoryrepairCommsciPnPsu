<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;

use kartik\dynagrid\DynaGrid;
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
               'width' => '50px',
           ],
           'format' => 'html',
           'filter' => $searchModel::getItemStatus(),
           'value' => 'statusLabel',
           'visible'=>false,
       ],
//            'status',
//            'ir_stID',
//            'ir_tchnID',
//            'ir_date',
        [
            'attribute' => 'ir_date',
            'format' => ['date','long'],
            'headerOptions' => [
                'width' => '140px',
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
            'attribute' => 'ir_stID',
            'value' => 'irSt.fullname',
            'filter' =>false,
        ],
        [
            'attribute' => 'ir_tchnID',
            'value' => 'irTchn.fullname',
            'filter' =>false,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{view} {pdf}',
            'buttons' => [
                'pdf' => function ($url, $model, $key) {
                    return Html::a(' ' . Html::icon('print') . ' ', $url, ['class'=>'text-danger', 'data-pjax' => 0, 'title' => 'พิมพ์', 'target' => '_blank']);
                },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'รายละเอียด',
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
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            ['content'=>'{dynagrid}'],
            '{toggleData}',
		],
		
    ],
    'options'=>['id'=>'dynagrid-pp'] // a unique identifier is important
]); ?>

</div>
