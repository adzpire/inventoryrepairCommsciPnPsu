<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dochub\models\InvtRepairDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invt-repair-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ird_id') ?>

    <?= $form->field($model, 'ird_irID') ?>

    <?= $form->field($model, 'ird_ivntID') ?>

    <?= $form->field($model, 'ird_symptom') ?>

    <?= $form->field($model, 'ird_tchnchoice') ?>

    <?php // echo $form->field($model, 'ird_tchncomment') ?>

    <div class="form-group">
        <?= Html::submitButton(Html::icon('search').' '.'Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Html::icon('refresh').' '.'Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
