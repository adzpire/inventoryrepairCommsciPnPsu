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
            <td class="tbhead" align="right">
                <span>
                    <table>
                        <tbody>
                        <tr style="" class="tborder">
                            <td>
                                <p style="padding: 5px 5px 0px 5px;">แบบแจ้งซ่อมครุภัณฑ์ <strong>หมายเลข <u><?php echo $model->ir_code; ?></u></strong><br>สำนักงานคณะวิทยาการสื่อสาร</p>
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
            <td align="right">
                <p class="pright">วันที่ <u><?php echo \Yii::$app->formatter->asDate($model->ir_date, "long"); ?></u></p>
            </td>
        </tr>
        <tr>
            <td class="tbcontent">
                <p><strong>เรียน</strong> คณบดี</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยครุภัณฑ์/อุปกรณ์ ประจำห้องแจ้งซ่อมครุภัณฑ์/อุปกรณ์ เกิดอาการชำรุดดังรายละเอียดต่อไปนี้</p>
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
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณา</p>
            </td>
        </tr>
        <tr>
            <td align="right">
                <p>ลงชื่อ (ตัวบรรจง)  <u><?php echo $model->irSt->getFullname('th'); ?></u> ผู้แจ้งซ่อม</p>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td width="50%" valign="top">
                            <strong>2. ความเห็นของผู้ตรวจสอบ</strong>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;ได้ตรวจสอบอาการที่ชำรุดของคณุภัณฑ์ดังกล่าว ข้างต้นแล้ว ขอรายงานผลการตรวจสอบ ดังนี้
                            </p>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;จัดซ่อมแล้ว พร้อมใช้งาน สำหรับรายการที่ .....</p>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;ขอจัดซื้ออะไหล่ทดแทน สำหรับรายการที่ .....<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; คือ .....................................................................
                            </p>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;ขออนุมัติส่งซ่อม สำหรับรายการที่ .....<br/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เนื่องจาก ................................................................
                            </p>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;ไม่ควรซ่อมเพราะไม่คุ้มค่าซ่อม สำหรับรายการที่ .....</p>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p align="center">
                                            ลงชื่อ ............................... ผู้ตรวจสอบ
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p align="center">
                                            ......../.............../........
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <strong>2. ความเห็นเบื้องต้นของรองคณบดีฝ่ายเทคโนโลยี สารสนเทศและกิจการพิเศษ</strong>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;ทราบ</p>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;มอบงานพัสดุดำเนินการซ่อม</p>
                            <p><?php echo $uncheckbox; ?> &nbsp;&nbsp;อื่นๆ ...............................................................</p>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p>
                                            ลงชื่อ ................................
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p>
                                            ......../.............../........
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <strong>4. การดำเนินการสำหรับเจ้าหน้าที่พัสดุ</strong>
                            <strong><a href="">การส่งซ่อม/การจัดซื้ออะไหล่ทดแทน</a></strong>
                            <p>
                                4.1 โทรแจ้งร้าน/บริษัท .................................<br/>
                                ติดต่อคุณ ........................................ โทร ............... <br/>
                                เมื่อวันที่ .......... เดือน ............ พ.ศ. .......................
                            </p>
                        </td>
                        <td width="50%" valign="top">
                            <p>4.2 เมื่อวันที่ .......... เดือน ............ พ.ศ. ...............</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;ช่างมาตรวจเช็ค&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;รับเครื่องไปซ่อม</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;อื่นๆ (ระบุ) .......................................</p>
                            <p>4.3 ผลการตรวจเช็ค(แนบรายงานการตรวจเช็คของบริษัทหรือ ระบุ)..........................................................................</p>
                            <p>..............................................................................</p>
                            <strong><a href="">การอนุมัติส่งซ่อม/การอนุมัติจัดซื้ออะไหล่ทดแทน</a></strong>
                            <p>เรียน รองคณบดีฝ่ายเทคโนโลยีสารสนเทศและกิจการพิเศษ</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;เพื่อโปรดพิจารณาอนุมัติ</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;การจัดซ่อมครูภัณฑ์รายการที่ .......... ตามใบเสนอ ราคาที่แนบมานี้</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;การจัดอะไหล่ทดแทนรายการที่ .......... จำนวนเงิน ประมาณการราคา ............. บาท</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;ไม่ควรซ่อมรายการดังกล่าว เนื่องจากไม่คุ้มซ่อม</p>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p>
                                            ลงชื่อ ................................ เจ้าหน้าที่พัสดุ
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p>
                                            ......../.............../........
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <strong>5. การอนุมัติ</strong>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;ทราบ ดำเนินการตามเสนอ</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;อนุมัติการจัดซ่อม/การจัดซื้ออะไหล่ทดแทน</p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;ไม่อนุมัติ เนื่องจาก ..............................................</p>
                            <p>................................................................................</p>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p>
                                            ลงชื่อ ................................ ผู้อนุมัติ
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table align="center">
                                <tr>
                                    <td>
                                        <p>
                                            ......../.............../........
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

    </table>
</div>
<pagebreak />
<div>
    <p align="center">- 2 -</p>

    <table>
        <tr>
            <td>
                <strong>6. การตรวจรับครุภัณฑ์คืน</strong>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;ตรวจรับคืนครุภัณฑ์รายการที่ ................. เรียบร้อยแล้ว</p>
                <p>รับคืนวันที่ .......... เดือน ............... พ.ศ. .............. เวลา ............ น. และได้ตรวจเช็คสภาพอุปกรณ์ที่รับคืนแล้วปรากฏผลดังนี้</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;ใช้งานได้ตามปกติ</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uncheckbox; ?> &nbsp;&nbsp;ยังใช้งานไม่ได้ เนื่องจาก ..........................................................................................................................................</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;..........................................................................................................................................................................</p>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" valign="top">
                <table align="center">
                    <tr>
                        <td>
                            <p>ลงชื่อ ................................ ผู้ส่งคืน</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>(...............................)</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top">
                <table align="center">
                    <tr>
                        <td>
                            <p>ลงชื่อ ................................ เจ้าหน้าที่ผู้รับคืน</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>(...............................)</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>