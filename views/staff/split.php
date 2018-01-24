<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\jui\Sortable;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepair */

$this->params['breadcrumbs'][] = ['label' => 'Invt Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
.grid-view td {
    white-space: unset;
}
');
?>
    <div class="invt-repair-view">

        <div class="panel panel-success">
            <div class="panel-heading">
                <span class="panel-title"><?= Html::icon('eye') . ' ' . Html::encode($this->title) ?></span>
            </div>
            <div class="panel-body">
                <?= $this->render('_viewtop', [
                    'model' => $model,
                ]) ?>
                <?php Pjax::begin(['id' => 'detailpjax']); ?>
                <?= GridView::widget([
                    'id' => 'kv-grid-demo',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'ird_id',
                        //'ird_irID',
//            'ird_ivntID',
                        [
                            'attribute' => 'ird_ivntID',
                            'label' => $mdlmain->getAttributeLabel('invt_name'),
                            //$model->irdIvnt->attributeLabels()['invt_name'],
                            'value' => 'irdIvnt.shortdetail'
                        ],
                        [
                            'attribute' => 'ird_ivntID',
                            'label' => $mdlmain->getAttributeLabel('invt_code'),
//                'label' => function ($data) {
//                    return $data->irdIvnt->attributeLabels()['invt_code'];
//                },
//                $model->irdIvnt->attributeLabels()['invt_code'],
                            'value' => 'irdIvnt.invt_code'
                        ],
                        [
                            'attribute' => 'ird_ivntID',
                            'label' => $mdlmain->getAttributeLabel('invt_locationID'),
                            'value' => 'irdIvnt.invtLocation.loc_name'
                        ],
                        'ird_symptom',

                        //'ird_tchnchoice',
                        // 'ird_tchncomment',
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'headerOptions' => [
                                'width' => '50px',
                            ],
                        ],
                    ],
                    'pager' => [
                        'firstPageLabel' => 'รายการแรกสุด',
                        'lastPageLabel' => 'รายการท้ายสุด',
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'toolbar' => false,
                    'panel' => false,
                ]); ?>
                <?php /* adzpire grid tips
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
                ?><?php Pjax::end(); ?>
                <div class="text-center">
                    <?php echo Html::a(Html::icon('duplicate') . ' ' . Yii::t('app', 'แยกรายการ'), ['splitproc', 'id' => $model->ir_id], ['class' => 'btn btn-lg btn-primary', 'id' => 'apprButton', 'data-pjax' => 0]); ?>
                </div>
                <?php
                /*echo Sortable::widget([
                    'items' => [
                        'Item 1',
                        'Item 2',
                    ],
                    'options' => ['id'=>'sortable1', 'class'=>'connectedSortable'],
                    'itemOptions' => ['tag' => 'li'],
                    'clientOptions' => ['cursor' => 'move'],
                ]);

                echo Sortable::widget([
                    'items' => [
                        'Item 1',
                        'Item 2',
                        'Item 3',
                        'Item 4',
                    ],
                    'options' => ['id'=>'sortable2', 'class'=>'connectedSortable'],
                    'itemOptions' => ['tag' => 'li'],
                    'clientOptions' => ['cursor' => 'move'],
                ]);*/
                ?>
            </div>
        </div>
    </div>
<?php

$this->registerJs("
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

$(document).on('click', '#apprButton', function (e) {
    e.preventDefault();
    var HotId = $('#kv-grid-demo').yiiGridView('getSelectedRows');    
    //HotId.length;
    if(HotId.length > 0){
        confirm('ยืนยันการแยกรายการ? แยกไปรายการใหม่ '+HotId.length+' อุปกรณ์');
        $.ajax({
            type: 'POST',
            url : ['splitproc'],
            data : {row_id: HotId, ird: " . $model->ir_id . "},
            success : function(data) {
               alert(data);
                if(data == '') {
                    alert('บันทึกเรียบร้อย');
                    //$.pjax.reload({container:'#apprpjax'});
                }else{
                    alert(data);
                    alert('server error');
                }
            }
        });/**/
    }else{
       alert('empty');
    }
});

", View::POS_READY);/**/

?>