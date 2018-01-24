<?php
use dosamigos\ckeditor\CKEditor;
?>
<div class="col-md-12">
    <h4><span class="glyphicon glyphicon-wrench"></span> ข้อมูลช่างผู้ตรวจ</h4>
    <?php
    echo '<div class="col-md-6 cus-border"><h4>เจ้าหน้าที่ซ่อม := <u>'.$model->irTchn->getFullname().'</u></h4></div>';
    echo '<div class="col-md-6 cus-border"><h4>วันที่เจ้าหน้าที่เช็ค := <u>'.\Yii::$app->formatter->asDate($model->ir_tchndate, "long").'</u></h4></div>';
    ?>
</div>
<div class="col-md-12">
    <h4><span class="glyphicon glyphicon-bitcoin"></span> ข้อมูลเจ้าหน้าที่พัสดุ <span class="glyphicon glyphicon-resize-horizontal"></span> ร้าน</h4>
    <?php
    if(Yii::$app->controller->action->id == 'shopprocapprv') {
        echo '<div class="col-md-6">';
        echo $form->field($model, 'ir_shopname')->textInput();
        echo '</div>';
    }else{
        echo '<div class="col-md-4 cus-border">';
        echo '<h4>ติดต่อร้าน := <u>'.$model->ir_shopname.'</u></h4></div>';
    }
    ?>
<?php
if(Yii::$app->controller->action->id == 'shopprocapprv') {
    echo '<div class="col-md-6">';
    echo $form->field($model, 'ir_shopcontact')->textInput(['placeholder'=>'เช่น คุณซิส เบอร์ 0815406930']);
    echo '</div>';
}else{
    echo '<div class="col-md-4 cus-border">';
    echo '<h4>ผู้ติดต่อ := <u>'.$model->ir_shopcontact.'</u></h4>';
    echo '</div><div class="col-md-4 cus-border">';
    echo '<h4>วันที่ติดต่อ := <u>'.\Yii::$app->formatter->asDate($model->ir_shopdate, "long").'</u></h4>';
    echo '</div>';
} ?>
</div>
<?php if(isset($model->ir_shopsuggestdate) or $model->status > 5 /**/){
    if(Yii::$app->controller->action->id == 'toexec') {
        echo '<div class="col-md-12">';
        echo $form->field($model, 'ir_shopsuggest')->widget(CKEditor::className(), [
            'preset' => 'basic'
            //'clientOptions' => KCFinder::registered()
        ]);
        echo '</div>';
    }else{
        echo '<div class="col-md-12"><div class="col-md-8 cus-border">';
        echo '<h4>ผลการตรวจเช็ค :=</h4> '.$model->ir_shopsuggest;
        echo '</div>';
        echo '<div class="col-md-4 cus-border">';
        echo '<h4>วันที่บันทึกผลการตรวจ := <u>'.\Yii::$app->formatter->asDate($model->ir_shopsuggestdate, "long").'</u></h4>';
        echo '</div></div>';
    } ?>
<?php } ?>
<?php if($model->status > 5){ ?>
    <div class="col-md-12">
    <h4><span class="glyphicon glyphicon-comment"></span> ข้อมูลการอนุมัติ</h4>

    <div class="col-md-4 cus-border">
        <p>
            <?php echo '<h4>การอนุมัติ := <u>'.$model->execLabel.'</u></h4>'; ?>
        </p>
        <p>
            <?php echo '<h4>ความเห็น := <u>'.$model->ir_execcomment.'</u></h4>'; ?>
        </p>
    </div>
    <div class="col-md-4 cus-border">
        <?php echo '<h4>ผู้อนุมัติ := <u>'.$model->irExecU->getFullname('th').'</u></h4>'; ?></div>
    <div class="col-md-4 cus-border">
        <?php echo '<h4>วันที่อนุมัติ := <u>'.\Yii::$app->formatter->asDate($model->ir_execdate, "long").'</u></h4>'; ?>
    </div>
    </div>
<?php } ?>
<?php if($model->status > 7){ ?>
    <div class="col-md-12">
        <h4><span class="glyphicon glyphicon-download-alt"></span> ข้อมูลการคืน</h4>

        <div class="col-md-6 cus-border">
            <?php echo '<h4>เจ้าหน้าที่ผู้แจ้งคืน := <u>'.$model->irTchn->getFullname('th').'</u></h4>'; ?>
        </div>
        <div class="col-md-6 cus-border">
            <?php echo '<h4>วันที่ := <u>'.\Yii::$app->formatter->asDate($model->ir_staffreturn, "long").'</u></h4>'; ?>
        </div>
        <div class="col-md-6 cus-border">
            <?php echo '<h4>ผู้รับคืน := <u>'.$model->irSt->getFullname('th').'</u></h4>'; ?>
        </div>
        <div class="col-md-6 cus-border">
            <?php echo '<h4>วันที่ := <u>'.\Yii::$app->formatter->asDate($model->ir_returndatetime, "long").'</u> เวลา <u>'.(new \DateTime($model->ir_returndatetime))->format('H:i:s').'</u></h4>'; ?>
        </div>
        <div class="col-md-6 cus-border">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รับคืนแล้วปรากฏผลว่า <u><?php echo (!empty($model->ir_returncomment)) ? '<strong>ยังใช้งานไม่ได้</strong> เนื่องจาก '.$model->ir_returncomment : '<strong>ใช้งานได้ปกติ</strong>'; ?></u></p>
        </div>
    </div>
<?php } ?>
<div class="col-md-12">
    <h4><span class="glyphicon glyphicon-info-sign"></span> ข้อความจากพัสดุ</h4>
    <?php
    echo '<div class="col-md-6 cus-border"><h4>ข้อความ := <u>'.$model->ir_note.'</u></h4></div>';
    ?>
</div>