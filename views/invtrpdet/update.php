<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepairDetail */

$this->params['breadcrumbs'][] = ['label' => 'Invt Repair Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ird_id, 'url' => ['view', 'id' => $model->ird_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="invt-repair-detail-update">

<div class="panel panel-warning">
	<div class="panel-heading">
		<span class="panel-title"><?= Html::icon('edit').' '.Html::encode($this->title) ?></span>
		<?= Html::a( Html::icon('fire').' '.'ลบ', ['delete', 'id' => $model->ird_id], [
            'class' => 'btn btn-danger panbtn',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูล?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a( Html::icon('pencil').' '.'สร้างใหม่', ['create'], ['class' => 'btn btn-info panbtn']) ?>
	</div>
	<div class="panel-body">
	<?= $this->render('_form', [
	  'model' => $model,
	]) ?>
	</div>
</div>

</div>
