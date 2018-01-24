<div class="col-md-12 text-right">
    <h3>แบบแจ้งซ่อมครุภัณฑ์ หมายเลข <strong><u><?php echo $model->ir_code; ?></u></strong></h3>
    <h4>สำนักงาน คณะวิทยาการสื่อสาร</h4>
</div>
<div class="col-md-12">
    <h4><span class="glyphicon glyphicon-user"></span> ข้อมูลผู้แจ้งซ่อม</h4>
    <div class="col-md-6 cus-border">
        <h4>ผู้แจ้ง := <u><?php echo $model->irSt->getFullname();  ?></u></h4>
    </div>
    <div class="col-md-6 cus-border">
        <h4>วันที่แจ้ง := <u><?php echo \Yii::$app->formatter->asDate($model->ir_date, "long");  ?></u></h4>
    </div>
</div>
<h4><span class="glyphicon glyphicon-tags"></span> ข้อมูลอุปกรณ์</h4>