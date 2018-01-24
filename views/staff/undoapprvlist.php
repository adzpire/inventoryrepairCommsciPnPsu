<?php

use yii\bootstrap\Html;
//use kartik\widgets\DatePicker;

use kartik\grid\GridView;

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
                'width' => '30px',
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
            'headerOptions' => [
                'width' => '200px',
            ],

        ],
        [
            'attribute' => 'ir_id',
            'label' => 'ผลการตรวจ',
            'format' => 'html',
            'filter' =>false,
            'enableSorting' =>false,
            'value' => function($data) {
                return $data->choiceList;
            },

        ],
//        'ir_shopsuggest',

        [
            'attribute' => 'ir_shopsuggest',
            'value' => 'ir_shopsuggest',
            'format' => 'html',
        ],
        [
            'attribute' => 'ir_stID',
            'value' => 'irSt.fullname',
            'filter' =>false,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{undoapprv}',
            'buttons' => [
                'undoapprv' => function ($url, $model, $key) {
                    return Html::a(' '.Html::icon('step-backward'), $url, ['class'=>'btn btn-danger']);
                },
            ],
            'contentOptions' => [
                'class'=>'text-center',
            ],
            'header' => 'ส่งกลับ',
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
        'heading'=> Html::icon($searchModel::fn()['icon']).' '.Html::encode($this->title),
    ],
]); ?>
</div>
