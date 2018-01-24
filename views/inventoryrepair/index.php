<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;

use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dochub\models\InvtRepairSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-repair-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
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
                    //$bookTitles = [];
                    $doc = '<ul>';
                    foreach($data->invtRepairDetails as $book) {
                        //$bookTitles[] = $book->irdIvnt->concatened;
                        $doc .= '<li>'.$book->irdIvnt->concatened.'</li>';
                    }
                    $doc .= '</ul>';
//                    return implode(', ', $bookTitles);
                    return $doc;
                },

            ],
            // 'ir_tchndate',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {pdf}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(' '.Html::icon('pencil').' ', $url, ['data-toggle'=>'tooltip', 'title'=>'แก้ไข']);
                    },
                    'pdf' => function ($url, $model, $key) {
                        if(!empty($model->invtRepairDetails)) {
                            return Html::a(' ' . Html::icon('print') . ' ', $url, ['data-toggle' => 'tooltip', 'data-pjax' => 0, 'title' => 'พิมพ์', 'target' => '_blank']);
                        }
},
                ],
                'headerOptions' => [
                    'width' => '70px',
                ],
                'contentOptions' => [
                    'class'=>'text-center',
                ],
                'header' => 'จัดการ',
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
                Html::a(Html::icon('plus').'สร้างแบบฟอร์มใหม่', ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'เพิ่ม')]).' '.
                Html::a(Html::icon('info-sign').'แสดงตัวอย่่าง', ['pdf?id=example'], ['class'=>'btn btn-danger', 'title'=>Yii::t('app', 'แสดงตัวอย่่าง'), 'target'=>'_blank']).' '.
                Html::a(Html::icon('repeat'), ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
            ],
            '{toggleData}',
        ],
		'panel'=>[
			'type'=>GridView::TYPE_INFO,
            'heading'=> Html::icon($searchModel::fn()['icon']).' '.Html::encode($this->title),
        ],
    ]); ?>
<?php 	 /* adzpire grid tips
		[
				'attribute' => 'id',
				'headerOptions' => [
					'width' => '50px',
				],
			],
		[
		'attribute' => 'we_date',
		'value' => 'we_date',
			'filter' => DatePicker::widget([
					'model'=>$searchModel,
					'attribute'=>'date',
					'language' => 'th',
					'options' => ['placeholder' => Yii::t('app', 'enterdate')],
					'type' => DatePicker::TYPE_COMPONENT_APPEND,
					'pickerButton' =>false,
					//'size' => 'sm',
					//'removeButton' =>false,
					'pluginOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd'
					]
				]),
			//'format' => 'html',			
			'format' => ['date']

		],	
		[
			'attribute' => 'we_creator',
			'value' => 'weCr.userPro.nameconcatened'
		],
	 */
 ?> <?php Pjax::end(); ?>	
</div>
