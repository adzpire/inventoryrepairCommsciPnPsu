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
            'template'=>'{undoproc}',
            'buttons' => [
                'undoproc' => function ($url, $model, $key) {
                    return Html::a(' '.Html::icon('edit'), $url, ['class'=>'btn btn-primary', 'data' => [ 'confirm' => 'ท่านต้องการต้องการแก้ไขข้อมูลใหม่? ผู้มีอำนาจต้องอนุมัติใหม่เช่นกัน', 'method' => 'post',]]);
                },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'แก้ไข',
            'visible' => \Yii::$app->controller->action->id == 'execproc',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{execprocapprv}',
            'buttons' => [
                'execprocapprv' => function ($url, $model, $key) {
                    return Html::a(' '.Html::icon('arrow-left'), $url, ['class'=>'btn btn-success']);
                },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'พัสดุส่งคืน',
            'visible' => \Yii::$app->controller->action->id == 'execproc',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{techprocapprv}',
            'buttons' => [
                'techprocapprv' => function ($url, $model, $key) {
                    if($model->status == 6){
                        return Html::a(' '.Html::icon('circle-arrow-left'), $url, ['class'=>'btn btn-primary']);
                    }
//                    if(!empty($model->invtRepairDetails)) {
//                        return Html::a(' ' . Html::icon('wrench') . ' เทคนิค', $url, ['class'=>'btn btn-default', 'title' => 'เจ้าหน้าที่เทคนิค']);
//                    }
                },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'ช่างส่งคืน',
            'visible' => \Yii::$app->controller->action->id == 'execstaffproc',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{pdf}',
            'buttons' => [
                'pdf' => function ($url, $model, $key) {
                        return Html::a(' ' . Html::icon('print') . ' ', $url, ['class'=>'btn btn-danger', 'data-pjax' => 0, 'title' => 'พิมพ์', 'target' => '_blank']);
                    },
            ],
            'headerOptions' => [
                'width' => '50px',
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
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
    'options'=>['id'=>'dynagrid-irstaffexecproc'] // a unique identifier is important
]); ?>

</div>
