<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepairDetail */

$this->params['breadcrumbs'][] = ['label' => 'Invt Repair Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-repair-detail-view">

<div class="panel panel-success">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('eye').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.'Delete', ['delete', 'id' => $model->ird_id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.'Update', ['update', 'id' => $model->ird_id], ['class' => 'btn btn-primary panbtn']) ?>
	</div>
	<div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
 			[
				'label' => $model->attributeLabels()['ird_id'],
				'value' => $model->ird_id,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ird_irID'],
				'value' => $model->ird_irID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ird_ivntID'],
				'value' => $model->ird_ivntID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ird_symptom'],
				'value' => $model->ird_symptom,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ird_tchnchoice'],
				'value' => $model->ird_tchnchoice,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ird_tchncomment'],
				'value' => $model->ird_tchncomment,			
				//'format' => ['date', 'long']
			],
    	],
    ]) ?>
	</div>
</div>
</div>