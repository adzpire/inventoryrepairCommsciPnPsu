<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;

use kartik\dynagrid\DynaGrid;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\inventory\models\InvtCheckcommitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-checkcommit-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= DynaGrid::widget([
    'columns' => [
		//['class' => 'yii\grid\SerialColumn'],

		[
			'attribute' => 'id',
			'headerOptions' => [
				'width' => '60px',
			],
		],
		[
			'attribute' => 'userName',
			'value' => 'user.fullname',
			'label' => $searchModel->attributeLabels()['user_id'],
		],
		'position',
		'year',
		//'created_at',
		// 'created_by',
		// 'updated_at',
		// 'updated_by',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{unchange}',
				'buttons' => [
					'unchange' => function ($url, $model, $key) {
						//return Html::a('<i class="glyphicon glyphicon-ok-circle"></i>',$url);
						return Html::a(' '.Html::icon('resize-small').' ', $url);
					},
				],
				'headerOptions' => [
					'width' => '80px',
				],
				'contentOptions' => [
					'class'=>'text-center',
				],
				'header' => 'ไม่เปลี่ยน',
			],
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{change}',
			'buttons' => [
				'change' => function ($url, $model, $key) {
					return Html::a(' '.Html::icon('transfer').' ', $url);
				}
			],
			'headerOptions' => [
				'width' => '60px',
			],
			'contentOptions' => [
				'class'=>'text-center',
			],
			'header' => 'เปลี่ยน',
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
            'heading'=> Html::icon('ok-circle').' '.Html::encode($this->title),
            // 'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
            'after' => false
        ],
        'toolbar' =>  [            
            ['content'=>'{dynagrid}'],
		],
		
    ],
    'options'=>['id'=>'dynagrid-irstaffapprlist'] // a unique identifier is important
]); ?>	
</div>
