<?php
//use Yii;
use yii\helpers\Html;

$checkedbox = '<img width="16" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiBoZWlnaHQ9IjMycHgiIGlkPSLQodC70L7QuV8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnIGlkPSJDaGVja19TcXVhcmUiPjxwYXRoIGQ9Ik0zMCwwSDJDMC44OTUsMCwwLDAuODk1LDAsMnYyOGMwLDEuMTA1LDAuODk1LDIsMiwyaDI4YzEuMTA0LDAsMi0wLjg5NSwyLTJWMkMzMiwwLjg5NSwzMS4xMDQsMCwzMCwweiAgICBNMzAsMzBIMlYyaDI4VjMweiIgZmlsbD0iIzEyMTMxMyIvPjxwYXRoIGQ9Ik0xMi4zMDEsMjIuNjA3YzAuMzgyLDAuMzc5LDEuMDQ0LDAuMzg0LDEuNDI5LDBsMTAuOTk5LTEwLjg5OWMwLjM5NC0wLjM5LDAuMzk0LTEuMDI0LDAtMS40MTQgICBjLTAuMzk0LTAuMzkxLTEuMDM0LTAuMzkxLTEuNDI4LDBMMTMuMDExLDIwLjQ4OGwtNC4yODEtNC4xOTZjLTAuMzk0LTAuMzkxLTEuMDM0LTAuMzkxLTEuNDI4LDBjLTAuMzk1LDAuMzkxLTAuMzk1LDEuMDI0LDAsMS40MTQgICBMMTIuMzAxLDIyLjYwN3oiIGZpbGw9IiMxMjEzMTMiLz48L2c+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PC9zdmc+" >';
$uncheckbox = '<img width="16" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAHUlEQVQ4jWNgYGD4TyGGEGSCUQNGDRg1gNoGkI0BF6E7xdLOry8AAAAASUVORK5CYII=" >';
?>
<!--<style>-->
<!--    .det th {-->
<!--        border: thin solid;-->
<!--        text-align: center;-->
<!--    }-->
<!--    .det td {-->
<!--        border: thin solid;-->
<!--        padding-left: 5px;-->
<!--    }-->
<!--    a {-->
<!--        display: inline-block;-->
<!--        color: #000;-->
<!--        line-height: 18px;-->
<!--        text-decoration: none;-->
<!--        border-bottom: 1px dotted;-->
<!--    }-->
<!--</style>-->
<body>
<div align="center">
    <table align="center" width="650" border="0" style="background-color:#fff;">
        <tr>
            <td align="center">
                <strong>แบบแจ้งซ่อมครุภัณฑ์ สำนักงานคณะวิทยาการสื่อสาร</strong>
            </td>
        </tr>
        <tr>
            <td class="tbhead" align="right">
                <span>
                    <table>
                        <tbody>
                        <tr style="" class="tborder">
                            <td>
                                <p style="padding: 5px 5px 0px 5px;"><strong>เลขที่ใบแจ้งซ่อม <u><?php echo $model->ir_code; ?></u></strong><br></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>1. แจ้งซ่อม</strong>
            </td>
        </tr>
        <tr>
            <td class="tbcontent">
                <p>ผู้แจ้งซ่อม <u><?php echo $model->irSt->getFullname('th'); ?></u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตำแหน่ง <u><?php echo $model->irSt->position->name_th; ?></u> วันที่ <u><?php echo \Yii::$app->formatter->asDate($model->ir_date, "long"); ?></u></p>
                <p>&nbsp;</p>
                <strong>2. รายการอุปกรณ์</strong>
                <table width="100%" class="det">
                    <tr>
                        <th width="31px" align="center">ลำดับที่</th>
                        <th width="150px">ชื่อครุภัณฑ์/อุปกรณ์</th>
                        <th width="70px">รหัสครุภัณฑ์</th>
                        <th width="75px">ประจำสถานที่</th>
                        <th width="150px">อาการที่ชำรุด</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($details as $row) {
                        echo '<tr>';
                        //echo '<td width="31" scope="col">&nbsp;</td>';
                        //echo '<td><div align="left" ><span > &nbsp;'.$row->exminfo_type.'</span></div></td>';
                        echo '<td width="31" align="center">' . $count . '</td>';
                        echo '<td class="style3" width="150px">' . $row->irdIvnt->shortdetail . '</td>';
                        echo '<td align="center">' . $row->irdIvnt->invt_code . '</td>';
                        echo '<td align="center">' . $row->irdLoc->loc_name . '</td>';
                        echo '<td width="150px">' . $row->ird_symptom . '</td>';
                        echo '</tr>';
                        $count++;
                    }
                    ?>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <p>&nbsp;</p>
                <p><strong>3. ความเห็นของผู้ตรวจสอบ</strong></p>
                <?php
                $count = 1;
                foreach ($details as $row) {
                    echo '<p>';
                    //echo '<td width="31" scope="col">&nbsp;</td>';
                    //echo '<td><div align="left" ><span > &nbsp;'.$row->exminfo_type.'</span></div></td>';
                    echo 'รายการที่ ' . $count . ' ผลการตรวจ ';
                    echo '<u>'.$row->getStatusLabel().'</u> ความเห็นเพิ่มเต็ม ';
                    echo (!empty($model->ird_tchncomment)) ? '<u>'.$row->ird_tchncomment.'</u>' : '<u>&nbsp;-&nbsp;</u>';
                    echo '</p>';
                    $count++;
                }
                ?>
                <p>ช่างผู้ตรวจสอบ <u><?php echo $model->irTchn->getFullname('th'); ?></u> วันที่ <u><?php echo \Yii::$app->formatter->asDate($model->ir_tchndate, "long"); ?></u></p>
                <p>&nbsp;</p>
                <p><strong>4. ข้อมูลการแจ้งส่งซ่อม/การจัดซื้ออะไหล่ทดแทน</strong></p>
                <p>ชื่อร้าน/บริษัท <u><?php echo (!empty($model->ir_shopname)) ? $model->ir_shopname : '<u>&nbsp;-&nbsp;</u>'; ?></u></p>
                <p>ติดต่อคุณ <u><?php echo (!empty($model->ir_shopcontact)) ? $model->ir_shopcontact : '<u>&nbsp;-&nbsp;</u>'; ?></u> วันที่ติดต่อ <u><?php echo \Yii::$app->formatter->asDate($model->ir_shopdate, "long"); ?></u></p>
                <p>ข้อมูลพิจารณาการซ่อม</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (!empty($model->ir_shopsuggest)) ? $model->ir_shopsuggest : '<u>&nbsp;-&nbsp;</u>'; ?></p>
                <p>ความเห็นช่างหลังร้านเสนอ/ตรวจเช็ค <u><?php echo (!empty($model->ir_tchnsuggest)) ? $model->ir_tchnsuggest : '<u>&nbsp;-&nbsp;</u>'; ?></u></p>
                <p>&nbsp;</p>
                <p><strong>5. ความเห็นผู้มีอำนาจสั่งการ</strong></p>
                <p>ผลการอนุมัติ <u><strong><?php echo $model->getExecLabel(); ?></strong></u>  ความเห็นเพิ่มเติม <u><?php echo (!empty($model->ir_execcomment)) ? $model->ir_execcomment : '<u>&nbsp;-&nbsp;</u>'; ?></u></p>
                <p>ผู้อนุมัติ <u><?php echo $model->irExecU->getFullname('th'); ?></u> วันที่ <u><?php echo \Yii::$app->formatter->asDate($model->ir_execdate, "long"); ?></u></p>
            </td>
        </tr>
        <?php if(!empty($model->ir_staffreturn)){ ?>
        <tr>
            <td>
                <p>&nbsp;</p>
                <strong>6. การตรวจรับครุภัณฑ์คืน</strong>
                <p>เจ้าหน้าที่ผู้ส่งคืน <u><?php echo $model->irTchn->getFullname('th'); ?></u> วันที่ <u><?php echo \Yii::$app->formatter->asDate($model->ir_staffreturn, "long"); ?></u></p>
                <p>ผู้รับคืน <u><?php echo $model->irSt->getFullname('th'); ?></u> วันที่ <u><?php echo \Yii::$app->formatter->asDate($model->ir_returndatetime, "long"); ?></u> เวลา <u><?php echo (new \DateTime($model->ir_returndatetime))->format('H:i:s'); ?></u></p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รับคืนแล้วปรากฏผลว่า <u><?php echo (!empty($model->ir_returncomment)) ? '<strong>ยังใช้งานไม่ได้</strong> เนื่องจาก '.$model->ir_returncomment : '<strong>ใช้งานได้ปกติ</strong>'; ?></u></p>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>