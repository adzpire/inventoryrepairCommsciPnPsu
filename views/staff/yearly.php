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
				'template' => '{selinvt}',
				'buttons' => [
					'selinvt' => function ($url, $model, $key) {
						//return Html::a('<i class="glyphicon glyphicon-ok-circle"></i>',$url);
						return Html::a(Html::icon('check'), $url);
					}
				],
				'headerOptions' => [
					'width' => '60px',
				],
				'contentOptions' => [
					'class'=>'text-center',
				],
				'header' => 'เลือก',
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
            'heading'=> Html::icon('bookmark').' '.Html::encode($this->title),
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
    'options'=>['id'=>'dynagrid-irstaffyearly'] // a unique identifier is important
]); ?>
    
</div>
