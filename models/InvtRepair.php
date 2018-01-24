<?php

namespace backend\modules\ir\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\person\models\Person;
use backend\components\ThaibudgetyearWidget;
/**
 * This is the model class for table "invt_repair".
 *
 
 * @property integer $ir_id
 * @property integer $status
 * @property integer $ir_stID
 * @property integer $ir_code
 * @property integer $ir_tchnID
 * @property string $ir_date
 * @property string $ir_tchndate
 * @property string $ir_shopname
 * @property string $ir_shopcontact
 * @property string $ir_shopdate
 * @property string $ir_shopsuggest
 * @property string $ir_shopsuggestdate
 * @property string $ir_tchnsuggest
 * @property integer $ir_execchoice
 * @property string $ir_execcomment
 * @property integer $ir_execUID
 * @property string $ir_execdate
 * @property string $ir_returncomment
 * @property string $ir_returndatetime
 * @property Person $irSt
 * @property Person $irTchn
 * @property Person $irExecU
 * @property string $ir_note
 * @property InvtRepairDetail[] $invtRepairDetails
 */
class InvtRepair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_repair';
    }

    public static function fn()
    {
        return [
            'code' => 'inventoryrepair',
            'name' => 'แบบแจ้งซ่อมครุภัณฑ์',
            'icon' => 'wrench',
        ];
    }

    public function beforeSave($insert)
    {
        //var_dump($insert);exit();
        //var_dump(parent::beforeSave($insert));
        //var_dump($insert);
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $tmpyearcode = ThaibudgetyearWidget::widget(['date' => $this->ir_date]);
            $short = substr($tmpyearcode,2);
            $tmpsql = self::find()->select('ir_code')->where(['LIKE', 'ir_code', $short.'%', false])->asArray()->all();
            $brndarr = [];
            foreach($tmpsql as $key => $value) {
                $shrt = substr($value['ir_code'],2);
                $shrt = ltrim($shrt, '0');
                array_push($brndarr, $shrt);
            }
            if(empty($brndarr)){
                $invID = '001';
            }else{
                $invID = str_pad(max($brndarr)+1, 3, '0', STR_PAD_LEFT);
            }
//            echo $short.$invID;
            $this->ir_code = $short.$invID;
//            exit();

        }

        return true;
    }

//    public function afterSave($insert, $changedAttributes)
//    {
//        parent::afterSave($insert, $changedAttributes);
//
//        if ($insert) {
//
//            $ssmdl = new FormAutoSession();
//            $ssmdl->fss_fid = $this->ir_id;
//            $ssmdl->fss_type = self::fn()['code'];
//            //$ssmdl->save();
//            if ($ssmdl->save()) {
//            } else {
//                print_r($ssmdl->getErrors());
//                exit;
//            }
//        } else {
//            $ssmdl = FormAutoSession::find()->where(['fss_fid' => $this->ir_id, 'fss_type' => self::fn()['code']])->one();
//            $ssmdl->updated_at = null;
//            $ssmdl->updated_by = null;
//            $ssmdl->save();
//        }
//    }

//    public function beforeDelete()
//    {
//        if (parent::beforeDelete()) {
//
//            $model = FormAutoSession::find()->where(['fss_fid' => $this->ir_id, 'fss_type' => self::fn()['code']])->one();
//            $model->delete();
//            return true;
//        } else {
//            return false;
//        }
//    }

public $irStName; 
public $irTchnName;
public $irExecUName;
public $invtRepairDetailsName;
/*add rule in [safe]
'irStName', 'irTchnName', 'invtRepairDetailsName', 
join in searh()
$query->joinWith(['irSt', 'irTchn', 'invtRepairDetails', ]);*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'ir_stID', 'ir_tchnID', 'ir_execchoice', 'ir_execUID'], 'integer'],
            [['ir_stID', 'ir_date'], 'required'],
            [['ir_date', 'ir_tchndate', 'ir_shopdate', 'ir_execdate', 'ir_shopsuggestdate', 'ir_note', 'ir_returndatetime'], 'safe'],
            [['ir_shopsuggest', 'ir_note'], 'string'],
            [['ir_code'], 'unique'],
            [['ir_code', 'ir_shopname', 'ir_shopcontact', 'ir_execcomment', 'ir_returncomment', 'ir_tchnsuggest'], 'string', 'max' => 255],
            [['ir_stID'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['ir_stID' => 'user_id']],
            [['ir_tchnID'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['ir_tchnID' => 'user_id']],
            [['ir_execUID'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['ir_execUID' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ir_id' => 'ID',
            'status' => 'สถานะ',
            'ir_stID' => 'ผู้แจ้ง',
            'ir_code' => 'หมายเลข',
            'ir_tchnID' => 'ผู้ตรวจสอบ',
            'ir_date' => 'วันที่แจ้งซ่อม',
            'ir_tchndate' => 'วันที่รายงานผล',
            'ir_shopname' => 'ร้าน/บริษัท',
            'ir_shopcontact' => 'ผู้ติดต่อ',
            'ir_shopdate' => 'วันที่ติดต่อ',
            'ir_shopsuggest' => 'ตรวจของร้าน-ความเห็น',
            'ir_shopsuggestdate' => 'ตรวจของร้าน-วันที่',
            'ir_tchnsuggest' => 'ความเห็นช่างหลังร้านตรวจ/เสนอ',
            'ir_execchoice' => 'การอนุมัติ',
            'ir_execcomment' => 'ความเห็น-การไม่อนุมัติ',
            'ir_execUID' => 'ผู้อนุมัติ',
            'ir_execdate' => 'วันที่อนุมัติ',
            'ir_returncomment' => 'ความเห็น-รับคืน',
            'ir_returndatetime' => 'วันที่-รับคืน',
            'ir_note' => 'ข้อความ',
        ];
    }

    public function getItemrepairs($itemid)
    {
        //return $this->hasMany(InvtRepairDetail::className(), ['ird_irID' => 'ir_id']);
        return $this->hasMany(InvtRepairDetail::className(), ['ird_irID' => 'ir_id'])
            ->where('ird_ivntID = :itemid', [':itemid' => $itemid])
            ->orderBy('ir_id');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIrSt()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'ir_stID']);
		
			/*
			$dataProvider->sort->attributes['irStName'] = [
				'asc' => ['person.name' => SORT_ASC],
				'desc' => ['person.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'person.name', $this->irStName])
			->orFilterWhere(['like', 'person.name1', $this->irStName])
						in grid
			[
				'attribute' => 'irStName',
				'value' => 'irSt.name',
				'label' => $searchModel->attributeLabels()['ir_stID'],
				'filter' => \Person::irStList,
			],
			*/
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIrTchn()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'ir_tchnID']);
		
			/*
			$dataProvider->sort->attributes['irTchnName'] = [
				'asc' => ['person.name' => SORT_ASC],
				'desc' => ['person.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'person.name', $this->irTchnName])
			->orFilterWhere(['like', 'person.name1', $this->irTchnName])
						in grid
			[
				'attribute' => 'irTchnName',
				'value' => 'irTchn.name',
				'label' => $searchModel->attributeLabels()['ir_tchnID'],
				'filter' => \Person::irTchnList,
			],
			*/
    }

    public function getIrExecU()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'ir_execUID']);

        /*
        $dataProvider->sort->attributes['irExecUName'] = [
            'asc' => ['person.name' => SORT_ASC],
            'desc' => ['person.name' => SORT_DESC],
        ];

        ->andFilterWhere(['like', 'person.name', $this->irExecUName])
        ->orFilterWhere(['like', 'person.name1', $this->irExecUName])
                    in grid
        [
            'attribute' => 'irExecUName',
            'value' => 'irExecU.name',
            'label' => $searchModel->attributeLabels()['ir_execUID'],
            'filter' => \Person::irExecUList,
        ],
        */
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtRepairDetails()
    {
        return $this->hasMany(InvtRepairDetail::className(), ['ird_irID' => 'ir_id']);
		
			/*
			$dataProvider->sort->attributes['invtRepairDetailsName'] = [
				'asc' => ['invt_repair.name' => SORT_ASC],
				'desc' => ['invt_repair.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'invt_repair.name', $this->invtRepairDetailsName])
			->orFilterWhere(['like', 'invt_repair.name1', $this->invtRepairDetailsName])
						in grid
			[
				'attribute' => 'invtRepairDetailsName',
				'value' => 'invtRepairDetails.name',
				'label' => $searchModel->attributeLabels()['ir_id'],
				'filter' => \InvtRepairDetail::invtRepairDetailsList,
			],
			*/
    }

public function getInvtRepairList(){
		return ArrayHelper::map(self::find()->all(), 'id', 'title');
	}
//    public static function getDetailshort($id){
//        $tmp = InvtRepairDetail::find()->where(['ird_irID' => $id])->asArray()->all();
//        return $tmp;
//        //return ArrayHelper::map(self::find()->all(), 'id', 'title');
//    }
    public function getChoice($id){
//        $customers = InvtRepairDetail::findAll($id);
        //echo $this->ir_id;
//        print_r($customers);
        //exit();
//        return $customers;
        return InvtRepairDetail::find()->where(['ird_irID' => $id])->asArray()->all();
//        return ArrayHelper::getValue($this->getItemChoice(),$this->ird_irID);
    }

public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'แจ้ง'),
                1 => Yii::t('app', 'พัสดุทราบ'),
                2 => Yii::t('app', 'เจ้าหน้าที่กำลังตรวจซ่อม'),
                3 => Yii::t('app', 'ขอจัดซื้ออะไหล่เพื่อซ่อมเอง'),
                4 => Yii::t('app', 'ขอส่งร้านซ่อม'),
                5 => Yii::t('app', 'เสนอผู้มีอำนาจอนุมัติ'),
                6 => Yii::t('app', 'ดำเนินการหลังอนุมัติ'),
                7 => Yii::t('app', 'รอรับคืน'),
                8 => Yii::t('app', 'ดำเนินการเรียบร้อย'),
            ],
            'execapprv'=>[
                0 => Yii::t('app', 'ไม่อนุมัติ'),
                1 => Yii::t('app', 'อนุมัติ'),
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case 0 :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case 2 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 3 :
                $str = '<span class="label label-danger">' . $status . '</span>';
                break;
            case 4 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 5 :
                $str = '<span class="label label-info">' . $status . '</span>';
                break;
            case 6 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 7 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public function getExecLabel() {
        $status = ArrayHelper::getValue($this->getItemExecapprv(), $this->ir_execchoice);
        $status = ($this->ir_execchoice === NULL) ? ArrayHelper::getValue($this->getItemExecapprv(), 0) : $status;
        switch ($this->ir_execchoice) {
            /*case 0 :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case 2 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 3 :
                $str = '<span class="label label-danger">' . $status . '</span>';
                break;
            case 4 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 5 :
                $str = '<span class="label label-info">' . $status . '</span>';
                break;
            case 6 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 7 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;*/
            default :
                $str = $status;
                break;
        }

        return $str;
    }
    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public static function getItemExecapprv() {
       return self::itemsAlias('execapprv');
    }

    public function getItemList()
    {
        $data = $this->invtRepairDetails;
        $doc = '<ul>';
        foreach($data as $book) {
            $doc .= '<li>'.$book->irdIvnt->concatened.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

    public function getChoiceList()
    {
        $data = $this->invtRepairDetails;
        $doc = '<ul>';
        foreach($data as $book) {
            $doc .= '<li>'.$book->getStatusLabel().'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }
}
