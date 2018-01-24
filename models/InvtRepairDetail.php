<?php

namespace backend\modules\ir\models;

use backend\modules\location\models\MainLocation;
use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\inventory\models\InvtMain;
/**
 * This is the model class for table "invt_repair_detail".
 *
 
 * @property integer $ird_id
 * @property integer $ird_irID
 * @property integer $ird_ivntID
 * @property integer $ird_ivntLoc
 * @property string $ird_symptom
 * @property integer $ird_tchnchoice
 * @property string $ird_tchncomment
 * @property InvtRepair $irdIr
 * @property InvtMain $irdIvnt
 */
class InvtRepairDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_repair_detail';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->ird_tchnchoice == 0){
                $mdl = InvtMain::findOne($this->ird_ivntID);
                $mdl->invt_statID = 2;
                if (!$mdl->save(false)) {
                    print_r($mdl->getErrors());
                }
            }elseif($this->ird_tchnchoice == 1){
                $mdl = InvtRepair::findOne($this->ird_irID);
                $mdl->status = 3;
                if (!$mdl->save(false)) {
                    print_r($mdl->getErrors());
                }
            }elseif($this->ird_tchnchoice == 2){
                $mdl = InvtRepair::findOne($this->ird_irID);
                $mdl->status = 4;
                if (!$mdl->save(false)) {
                    print_r($mdl->getErrors());
                }
            }
            return true;
        } else {
            return false;
        }
    }
public $irdIrName; 
public $irdIvntName; 
/*add rule in [safe]
'irdIrName', 'irdIvntName', 
join in searh()
$query->joinWith(['irdIr', 'irdIvnt', ]);*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ird_irID', 'ird_ivntID', 'ird_ivntLoc', 'ird_symptom'], 'required'],
            [['ird_irID', 'ird_ivntID', 'ird_ivntLoc', 'ird_tchnchoice'], 'integer'],
            [['ird_symptom', 'ird_tchncomment'], 'string', 'max' => 255],
            [['ird_irID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtRepair::className(), 'targetAttribute' => ['ird_irID' => 'ir_id']],
            [['ird_ivntID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtMain::className(), 'targetAttribute' => ['ird_ivntID' => 'id']],
            [['ird_ivntLoc'], 'exist', 'skipOnError' => true, 'targetClass' => MainLocation::className(), 'targetAttribute' => ['ird_ivntLoc' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ird_id' => 'ID',
            'ird_irID' => 'repairID',
            'ird_ivntID' => 'สิ่งของ',
            'ird_ivntLoc' => 'สถานที่',
            'ird_symptom' => 'อาการชำรุดที่แจ้ง',
            'ird_tchnchoice' => 'ผลตรวจจากช่างซ่อม',
            'ird_tchncomment' => 'ความเห็นจากช่างซ่อม',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIrdIr()
    {
        return $this->hasOne(InvtRepair::className(), ['ir_id' => 'ird_irID']);
		
			/*
			$dataProvider->sort->attributes['irdIrName'] = [
				'asc' => ['invt_repair.name' => SORT_ASC],
				'desc' => ['invt_repair.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'invt_repair.name', $this->irdIrName])
			->orFilterWhere(['like', 'invt_repair.name1', $this->irdIrName])
						in grid
			[
				'attribute' => 'irdIrName',
				'value' => 'irdIr.name',
				'label' => $searchModel->attributeLabels()['ird_irID'],
				'filter' => \InvtRepair::irdIrList,
			],
			*/
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIrdIvnt()
    {
        return $this->hasOne(InvtMain::className(), ['id' => 'ird_ivntID']);
		
			/*
			$dataProvider->sort->attributes['irdIvntName'] = [
				'asc' => ['invt_main.name' => SORT_ASC],
				'desc' => ['invt_main.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'invt_main.name', $this->irdIvntName])
			->orFilterWhere(['like', 'invt_main.name1', $this->irdIvntName])
						in grid
			[
				'attribute' => 'irdIvntName',
				'value' => 'irdIvnt.name',
				'label' => $searchModel->attributeLabels()['ird_ivntID'],
				'filter' => \InvtMain::irdIvntList,
			],
			*/
    }

    public function getIrdLoc()
    {
        return $this->hasOne(MainLocation::className(), ['id' => 'ird_ivntLoc']);
    }

public function getInvtRepairDetailList(){
		return ArrayHelper::map(self::find()->all(), 'id', 'title');
	}

    public function getHospitalName(){
        return @$this->irdIvnt->attributeLabels()['invt_name'];
    }

public static function itemsAlias($key) {
        $items = [
            'techstatus'=>[
                0 => 'ซ่อมเองแล้ว พร้อมใช้งาน',
                1 => 'ขออนุมัติซื้ออะไหล่ทดแทนเพื่อซ่อมเอง',
                2 => 'ขออนุมัติส่งซ่อมร้าน',
                3 => 'ไม่ควรส่งซ่อม เพราะไม่คุ้มซ่อม',
            ],
//            'statusCondition'=>[
//                1 => Yii::t('app', 'อนุมัติ'),
//                0 => Yii::t('app', 'ไม่อนุมัติ'),
//            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getTechStatus(), $this->ird_tchnchoice);
        //$status = ($this->ird_tchnchoice === NULL) ? ArrayHelper::getValue($this->getTechStatus(), 0) : $status;
        switch ($this->ird_tchnchoice) {
//            case 0 :
//            case NULL :
//                $str = '<span class="label label-warning">' . $status . '</span>';
//                break;
//            case 1 :
//                $str = '<span class="label label-primary">' . $status . '</span>';
//                break;
//            case 2 :
//                $str = '<span class="label label-success">' . $status . '</span>';
//                break;
//            case 3 :
//                $str = '<span class="label label-danger">' . $status . '</span>';
//                break;
//            case 4 :
//                $str = '<span class="label label-succes">' . $status . '</span>';
//                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public static function getTechStatus() {
        return self::itemsAlias('techstatus');
    }
    /*
       public static function getItemStatusConsider() {
           return self::itemsAlias('statusCondition');
       }
   */
}
