<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepairSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-repair-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ir_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'ir_stID') ?>

    <?= $form->field($model, 'ir_tchnID') ?>

    <?= $form->field($model, 'ir_date') ?>

    <?php // echo $form->field($model, 'ir_tchndate') ?>

    <div class="form-group">
        <?= Html::submitButton(Html::icon('search').' '.'Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Html::icon('refresh').' '.'Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
