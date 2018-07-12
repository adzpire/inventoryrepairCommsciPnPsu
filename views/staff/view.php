<?php

use yii\bootstrap\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepair */

$this->params['breadcrumbs'][] = ['label' => 'Invt Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
.grid-view td {
    white-space: unset;
}
.cus-border {
    border: 1px solid #ddd;
}
');
?>
<div class="invt-repair-view">

<div class="panel panel-success">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('eye').' '.Html::encode($this->title) ?></span>
		<?php /*Html::a( Html::icon('fire').' '.'Delete', ['delete', 'id' => $model->ir_id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
		<?php // Html::a( Html::icon('pencil').' '.'Update', ['update', 'id' => $model->ir_id], ['class' => 'btn btn-primary panbtn']) ?>
	</div>
	<div class="panel-body">
        <?php echo $this->render('_viewtop', [
            'model' => $model,
        ]); ?>
        <?= GridView::widget([
            //'id' => 'kv-grid-demo',
            'dataProvider'=> $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_name'),
                    //$model->irdIvnt->attributeLabels()['invt_name'],
                    'value' => 'irdIvnt.shortdetail'
                ],
                [
                    'attribute' => 'ird_ivntID',
                    'label' => $mdlmain->getAttributeLabel('invt_code'),
                    'value' => 'irdIvnt.invt_code'
                ],
                [
                    'attribute' => 'ird_ivntLoc',
                    // 'label' => $data->getAttributeLabel('ird_ivntLoc'),
                    'value' => 'irdLoc.loc_name'
                ],
                'ird_symptom',

                [
                    'attribute' => 'ird_tchnchoice',
                    'value' => 'statuslabel'
                ],
                'ird_tchncomment',
            ],
            'pager' => [
                'firstPageLabel' => 'รายการแรกสุด',
                'lastPageLabel' => 'รายการท้ายสุด',
            ],
            'responsive'=>true,
            'hover'=>true,
            'toolbar' => false,
            'panel' => false,
        ]); ?>
        <?php echo $this->render('_viewbottom', [
            'model' => $model,
            'form' => $form,
        ]); ?>
	</div>
</div>
</div>