<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepair */

$this->params['breadcrumbs'][] = ['label' => 'Invt Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invt-repair-view">

<div class="panel panel-success">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('eye').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.'Delete', ['delete', 'id' => $model->ir_id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.'Update', ['update', 'id' => $model->ir_id], ['class' => 'btn btn-primary panbtn']) ?>
	</div>
	<div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
 			[
				'label' => $model->attributeLabels()['ir_id'],
				'value' => $model->ir_id,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['status'],
				'value' => $model->status,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ir_stID'],
				'value' => $model->ir_stID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ir_tchnID'],
				'value' => $model->ir_tchnID,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ir_date'],
				'value' => $model->ir_date,			
				//'format' => ['date', 'long']
			],
     			[
				'label' => $model->attributeLabels()['ir_tchndate'],
				'value' => $model->ir_tchndate,			
				//'format' => ['date', 'long']
			],
    	],
    ]) ?>
	</div>
</div>
</div>