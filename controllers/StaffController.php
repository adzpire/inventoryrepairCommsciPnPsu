<?php

namespace backend\modules\ir\controllers;

use Yii;
use backend\modules\ir\models\InvtRepair;
use backend\modules\ir\models\StaffSendBackSearch;
use backend\modules\ir\models\InvtRepairDetail;
use backend\modules\ir\models\InvtRepairDetailSearch;
use backend\modules\ir\models\IRSpareSearch;
use backend\modules\ir\models\IRExecSearch;
use backend\modules\ir\models\IRAfterExecSearch;
use backend\modules\ir\models\IRStaffSearch;
use backend\modules\ir\models\IRInvtstaffSearch;
use backend\modules\ir\models\StaffWaitExecSearch;
use backend\modules\ir\models\StaffCompleteSearch;
use backend\modules\ir\models\ExecprocessSearch;
use frontend\modules\linenotify\models\Linetoken;
use frontend\modules\linenotify\models\Linetokenprogram;
use backend\modules\person\models\Person;

use backend\modules\inventory\models\InvtMain;
use backend\modules\inventory\models\InvtStatus;

use backend\components\AdzpireComponent;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use kartik\mpdf\Pdf;

/**
 * Default controller for the `ir` module
 */
class StaffController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'updatedetailfull', 'invtapprv', 'techapprv', 'shopprocapprv'],
                'rules' => [
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return date('d-m') === '31-10';
                        }
                    ],
                    [
                        'actions' => ['invtapprv'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $mdl = $this->findModel(Yii::$app->request->get('id'));
                            if ($mdl->status < 2) {
                                return true;
                            } else {
                                return false;
                            }
                            //return date('d-m') === '31-10';
                        }
                    ],
                    [
                        'actions' => ['techapprv', 'shopprocapprv'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $mdl = $this->findModel(Yii::$app->request->get('id'));
                            if ($mdl->status < 5) {
                                return true;
                            } else {
                                return false;
                            }
                            //return date('d-m') === '31-10';
                        }
                    ],
                    [
                        'actions' => ['updatedetailfull'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $detmdl = $this->findModeldetail(Yii::$app->request->get('id'));
                            $mdl = $this->findModel($detmdl->ird_irID);
                            if ($mdl->status < 6) {
                                return true;
                            } else {
                                return false;
                            }
                            //return date('d-m') === '31-10';
                        }
                    ],
                ],
            ],
        ];
    }

    public $moduletitle;
    public $lineprog;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->moduletitle = Yii::t('app', Yii::$app->controller->module->params['title']);
            $this->lineprog = Linetokenprogram::findOne(2);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        Yii::$app->view->title = 'รับทราบ - '. $this->moduletitle;

        $searchModel = new IRInvtstaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTechindex()
    {

        Yii::$app->view->title = 'รับทราบ - '. $this->moduletitle;

        $searchModel = new IRStaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        Yii::$app->view->title = Yii::t('app', 'ดูรายละเอียด') . ' : ' . $model->ir_id . ' - ' . $this->moduletitle;
        $mdlmain = new InvtMain();
        $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'mdlmain' => $mdlmain,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->view->title = Yii::t('app', 'สร้างใหม่') .' - '. $this->moduletitle;

        $model = new InvtRepair();

        /* if enable ajax validate
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }*/

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                AdzpireComponent::succalert('addflsh', 'เพิ่มรายการใหม่เรียบร้อย');
                return $this->redirect(['update', 'id' => $model->ir_id]);
            }else{
                AdzpireComponent::dangalert('addflsh', 'เพิ่มรายการไม่ได้');
            }
            print_r($model->getErrors());
            exit;
        }else{
            $qstaff = Person::getPersonList();

            return $this->render('create', [
                'model' => $model,
                'staff' => $qstaff,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'ปรับปรุงรายการ '.$model::fn()['name'].': ' . $model->ir_id.' - '. $this->moduletitle;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['update', 'id' => $model->ir_id]);
            }else{
                AdzpireComponent::dangalert('addflsh', 'ปรับปรุงรายการไม่ได้');
            }
            print_r($model->getErrors());
            exit;
        }else{
            $qstaff = Person::getPersonList();

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;

            return $this->render('update', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'staff' => $qstaff,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if(empty($model->invtRepairDetails)){
            $model->delete();
            AdzpireComponent::succalert('delflsh', 'ลบรายการเรียบร้อย');
        }else{
            AdzpireComponent::dangalert('delflsh', 'ลบรายการไม่ได้เพราะยังมีรายการอุปกรณ์');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = InvtRepair::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ต้องการ.');
        }
    }

    protected function findModeldetail($id)
    {
        if (($model = InvtRepairDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ต้องการ.');
        }
    }

    protected function findInvtModel($id)
    {
        if (($model = InvtMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ต้องการ.');
        }
    }

    public function actionQadddetail($id)
    {
        $model = new InvtRepairDetail();

        if ($model->load(Yii::$app->request->post())) {

            $model->ird_irID = $id;
            $tmpinvt = InvtMain::findOne(Yii::$app->request->post()['InvtRepairDetail']['ird_ivntID']);
            $model->ird_ivntLoc = $tmpinvt->invt_locationID;

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
//              --
                $tmpinvt->invt_statID = 3;
                $tmpinvt->save(false);
//              --
//                $sh = new InvtStathistory();
//                $sh->invt_ID = $model->ird_ivntID;
//                $sh->invt_statID = 3;
//                $sh->date = date('Y-m-d');
//                $sh->save();
//              --
                $transaction->commit();

                echo 1;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

//            if ($model->save()) {
//                echo 1;
//            } else {
//                print_r($model->getErrors());
//            }

        } else {
            return $this->renderAjax('_formdetail', [
                'model' => $model,
//                'invtlist' => $this->invtlist,
            ]);
        }
    }

    public function actionUpdatedetail($id)
    {
        $model = $this->findModeldetail($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                echo 1;
            } else {
                print_r($model->getErrors());
            }

        } else {
            return $this->renderAjax('_formdetail', [
                'model' => $model,
//                'invtlist' => $this->invtlist,
            ]);
        }
    }

    public function actionNote($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save(false)) {
                echo 1;
            } else {
                print_r($model->getErrors());
            }

        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatedetailfull($id)
    {
        $model = $this->findModeldetail($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                if($model->ird_tchnchoice == 0){
                    echo 1;
                }elseif($model->ird_tchnchoice == 1){
                    echo 2;
                }elseif($model->ird_tchnchoice == 2){
                    echo 3;
                }elseif($model->ird_tchnchoice == 3){
                    echo 4;
                }else{
                    echo 0;
                }
            } else {
                print_r($model->getErrors());
            }
        } else {
            return $this->renderAjax('_formdetail', [
                'model' => $model,
//                'invtlist' => $this->invtlist,
            ]);
        }
    }

    public function actionDeletedetail($id)
    {
        $model = $this->findModeldetail($id);
        $tmpinvt = InvtMain::findOne($model->ird_ivntID);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->delete();
//              --
            $tmpinvt->invt_statID = 2;
            $tmpinvt->save(false);
//              --
//            $sh = new InvtStathistory();
//            $sh->invt_ID = $model->ird_ivntID;
//            $sh->invt_statID = 2;
//            $sh->date = date('Y-m-d');
//            $sh->save();
//              --
            $transaction->commit();

            echo 1;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
//        if ($this->findModeldetail($id)->delete()) {
//            echo 1;
//        } else {
//            print_r($this->findModeldetail($id)->getErrors());
//        }
    }

    /*************
     * select2 ajax
     ************/
    public function actionInvtlist($q = null, $id = null) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query;

            //$query->select('id, concat(invt_name, \' \', invt_brand, \' \', invt_code) AS text')
            //$quotes = Quote::find()->select(['id', new \yii\db\Expression("CONCAT(`name`, ' model id: ', `id`) as name")])->all();
            $query->select(['id', new \yii\db\Expression("CONCAT(`invt_name`, ' brand: ', `invt_brand`, ' code: ', `invt_code`) as text")])
                ->from('invt_main')
                ->where(['like', 'invt_name', $q])
                ->orWhere(['like', 'invt_code', $q])
                ->orWhere(['like', 'invt_detail', $q])
                ->orWhere(['like', 'invt_occupyby', $q])
                ->orWhere(['like', 'invt_brand', $q]);
            //->limit(20)
            $command = $query->createCommand();
            $data = $command->queryAll();
            //print_r($data);exit();
            $out['results'] = array_values($data);
//            $out['results'] = ['id' => $id, 'text' => $data['invt_name'].' ('.$data['invt_brand'].' '.$data['invt_code'].')'];
        }
        elseif ($id > 0) {
            //$out['results'] = ['id' => $id, 'text' => InvtMain::find($id)->invt_name];
            //InvtMain::findOne($id);
            $out['results'] = ['id' => $id, 'text' => InvtMain::find($id)->invt_name];
        }
        return $out;
    }

    public function actionPdf($id)
    {
        $model = ($id == 'example') ?$this->findModel(0) : $this->findModel($id);

//        $intmdl = MainIntercom::find()
//            ->where(['staff_id' => $model->libaid_stid])
//            ->one();
        if(!empty($model->invtRepairDetails)) {
            $details = InvtRepairDetail::findAll([
                'ird_irID' => $model->ir_id,
            ]);
        }else{
            return $this->redirect(['update', 'id' => $model->ir_id]);
        }

//        return $this->render('print', [
//            'model' => $model,
//            'details' => $details,
//        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $this->renderPartial('print', [
                'model' => $model,
                'details' => $details,
            ]),
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'options' => [
                'title' => 'แบบขออนุมัติจัดซื้อครุภัณฑ์นอกแผนการจัดซื้อประจําปี',
                'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
            ],
            'cssInline' => '
                body {
                    margin-top: 10px;
                    margin-bottom: 10px;
                    font-size: 20px;
                    line-height: 22px;
                    font-family: "sarabun";
                }
                .pagebreak { page-break-before: always; }
                .tbhead {
                    border-top-style: none;
                    border-right-style: none;
                    border-bottom-style: none;
                    border-left-style: none;
                }
                .tbhead {
                    border-top-style: none;
                    border-right-style: none;
                    border-bottom-style: none;
                    border-left-style: none;
                }
                .tborder {
                    border: thin solid #000;
                }
                /*.tbcontent {
                    border: thin solid #000;
                    vertical-align: top;
                    padding-left: 5px;
                }*/
                .det th {
                    border: thin solid;
                    text-align: center;
                }
                .det td {
                    border: thin solid;
                    padding-left: 5px;
                }
                u {
                    border-bottom: 1px dotted #000;
                    text-decoration: none;
                }
                a {
                    text-decoration: underline;
                    color: black;
                }
                .style6{
                  font-size: 30px;
                }
                .style5{
                  font-size: 25px;
                }
                .style4{
                  font-size: 20px;
                }
                .style3{
                  font-size: 15px;
                }
                .fixpos {
                    position: absolute;
                    right: 300px;
                }
                .indnt {
                    text-indent: 2em;
                }
                @media print {
                    .noprint {
                        display: none;
                    }
                }
            ',
            'methods' => [
                //'SetHeader' => ['Generated By: Krajee Pdf Component||Generated On: ' . date("r")],
                //'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionInvtapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'พัสดุรับทราบรายการ '.$model::fn()['name'].': ' . $model->ir_id.' - '. $this->moduletitle;

        if ($model->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['save&go']))
            {
                $model->status = 1;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'รับทราบรายการเรียบร้อย');
                return $this->redirect(['index']);
            }
            if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['update', 'id' => $model->ir_id]);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
            }
            print_r($model->getErrors());
            exit;
        }else{
            $qstaff = Person::getPersonList();

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;

            return $this->render('invtapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'staff' => $qstaff,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionTechapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'เจ้าหน้าที่ดำเนินการ '.$model::fn()['name'].': ' . $model->ir_id.' - '. $this->moduletitle;

        if (Yii::$app->request->post()) {
            if(isset(Yii::$app->request->post()['save&go']))
            {
                $model->status = 2;
                $model->ir_tchnID = Yii::$app->user->id;
                $model->ir_tchndate = date('Y-m-d');
                $model->save(false);

                AdzpireComponent::linenotify($this->lineprog->id, "\n** ".$this->lineprog->token." **\n -- ช่างรับทราบและกำลังซ่อม -- **\n อ่านเพิ่มเติม: http://www.comm-sci.pn.psu.ac.th/".Url::to(['view', 'id'=> $model->ir_id]), $model->ir_stID);

                AdzpireComponent::succalert('edtflsh', 'รับทราบรายการเรียบร้อย');
                return $this->redirect(['techapprv', 'id' => $model->ir_id]);
            }
            if(isset(Yii::$app->request->post()['techcomplete']))
            {
                $model->status = 5;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'แจ้งผู้มีอำนาจแล้ว');
                return $this->redirect(['index']);
            }
            if($model->load(Yii::$app->request->post()) and $model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['update', 'id' => $model->ir_id]);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
                print_r($model->getErrors());
                exit();
            }

        }else{
            $qstaff = Person::getPersonList();

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;
            $detmdl = InvtRepairDetail::find()->where(['ird_irID' => $model->ir_id])->all();
            $count = 1;
            foreach ($detmdl as $key => $value){
                //echo $key.' -> '.$value->ird_ivntID;
                $searchitem[$value->ird_ivntID] = new InvtRepairDetailSearch(['ird_ivntID' => $value->ird_ivntID]);
                //$searchitem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID] = $searchitem[$value->ird_ivntID]->search(Yii::$app->request->queryParams);
                $dataProvideritem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID]->sort = false;

                $count++;
            }/**/
            //print_r($dataProvideritem);
            //exit();

            return $this->render('techapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'staff' => $qstaff,
                'dataProvider' => $dataProvider,
                'dataProviderlist' => $dataProvideritem,
                'searchitemlist' => $searchitem,
//                'dataProvideritemfirst' => $dataProvideritemfirst,
//                'dataProvideritemsecond' => isset($dataProvideritemsecond) ? $dataProvideritemsecond : false,
//                '$dataProvideritemthird' => isset($dataProvideritemthird) ? $dataProvideritemthird : false,
            ]);
        }
    }

    public function actionSplit($id)
    {

        Yii::$app->view->title = 'แยกรายการ - '. $this->moduletitle;

        $model = $this->findModel($id);
        $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;
        $mdlmain = new InvtMain();

        return $this->render('split', [
            'model' => $model,
            'mdlmain' => $mdlmain,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSplitproc()
    {
        $obj = $this->findModel(Yii::$app->request->post()['ird']);
        $clone = new InvtRepair();
        $clone->attributes = $obj->attributes;
        $clone->ir_code = null;

        if($clone->save()){
            foreach (Yii::$app->request->post()['row_id'] as $key => $value){
                $det = $this->findModeldetail($value);
                $det->ird_irID = $clone->ir_id;
                $det->save();
            }
            return $this->redirect(['techapprv', 'id' => $clone->ir_id]);
        }else{
            return $this->redirect(['index']);
        }
    }

    public function actionShopproc()
    {

        Yii::$app->view->title = 'พัสดุ<->ร้าน - '. $this->moduletitle;

        $searchModel = new IRSpareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('shopproc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShoptechnic()
    {

        Yii::$app->view->title = 'ความเห็นช่างหลังร้านตรวจสอบ - '. $this->moduletitle;

        $searchModel = new IRSpareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('shopproc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShopprocapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'ดำเนินการร้าน<->พัสดุ '.$model::fn()['name'].': ' . $model->ir_id.' - '. $this->moduletitle;

        if ($model->load(Yii::$app->request->post())) {
            $model->ir_shopdate = date('Y-m-d');

            if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['shopproc']);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
            }
            print_r($model->getErrors());
            exit;
        }else{
            //$qstaff = Person::getPersonList();

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;

            $detmdl = InvtRepairDetail::find()->where(['ird_irID' => $model->ir_id])->all();
            foreach ($detmdl as $key => $value){
                $searchitem[$value->ird_ivntID] = new InvtRepairDetailSearch(['ird_ivntID' => $value->ird_ivntID]);
                $dataProvideritem[$value->ird_ivntID] = $searchitem[$value->ird_ivntID]->search(Yii::$app->request->queryParams);
                $dataProvideritem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID]->sort = false;
            }
            return $this->render('shopprocapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
                'dataProviderlist' => $dataProvideritem,
                'searchitemlist' => $searchitem,
            ]);
        }
    }

    public function actionToexec($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'รายงานผลของร้าน - '. $this->moduletitle;

        if ($model->load(Yii::$app->request->post())) {

            $model->ir_shopsuggestdate = date('Y-m-d');
            if(isset(Yii::$app->request->post()['save&go']))
            {
                //echo 'bbb';
                $model->status = 5;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'เสนอผู้มีอำนาจเรียบร้อย');
                return $this->redirect(['shopproc']);
            }

            if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['shopproc']);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
            }
            print_r($model->getErrors());
            exit;
        }else{

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;
            $detmdl = InvtRepairDetail::find()->where(['ird_irID' => $model->ir_id])->all();
            foreach ($detmdl as $key => $value){
                $searchitem[$value->ird_ivntID] = new InvtRepairDetailSearch(['ird_ivntID' => $value->ird_ivntID]);
                $dataProvideritem[$value->ird_ivntID] = $searchitem[$value->ird_ivntID]->search(Yii::$app->request->queryParams);
                $dataProvideritem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID]->sort = false;
            }
            return $this->render('shopprocapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
                'dataProviderlist' => $dataProvideritem,
                'searchitemlist' => $searchitem,
            ]);
        }
    }
    public function actionWaitexec()
    {

        Yii::$app->view->title = 'รออนุมัติ - '. $this->moduletitle;

        $searchModel = new StaffWaitExecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('waitexec', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionExecproc()
    {

        Yii::$app->view->title = 'หลังอนุมัติ - '. $this->moduletitle;

        $searchModel = new IRAfterExecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('execproc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExecstaffproc()
    {

        Yii::$app->view->title = 'หลังอนุมัติ - '. $this->moduletitle;

        $searchModel = new IRAfterExecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('execproc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShoptchn($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'ความเห็นช่างหลังร้านตรวจ/เสนอ - '. $this->moduletitle;
        //print_r(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post())) {
            //echo 'test';exit();
            if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['shopproc']);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
            }
            print_r($model->getErrors());
            exit;
        }else{

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;
            $detmdl = InvtRepairDetail::find()->where(['ird_irID' => $model->ir_id])->all();
            foreach ($detmdl as $key => $value){
                $searchitem[$value->ird_ivntID] = new InvtRepairDetailSearch(['ird_ivntID' => $value->ird_ivntID]);
                $dataProvideritem[$value->ird_ivntID] = $searchitem[$value->ird_ivntID]->search(Yii::$app->request->queryParams);
                $dataProvideritem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID]->sort = false;
            }
            return $this->render('shopprocapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
                'dataProviderlist' => $dataProvideritem,
                'searchitemlist' => $searchitem,
            ]);
        }
    }

    public function actionExecprocapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'รายงานผลของร้าน - '. $this->moduletitle;
        //print_r(Yii::$app->request->post());
        if (Yii::$app->request->post()) {
            //echo 'test';exit();
            if(isset(Yii::$app->request->post()['sendback']))
            {
                $model->status = 7;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'แจ้งรับคืนแล้ว');
                return $this->redirect(['execproc']);
            }
            print_r($model->getErrors());
            exit;
        }else{

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;

            return $this->render('execprocapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionSendproc()
    {

        Yii::$app->view->title = 'แจ้งรับแล้วแต่ผู้แจ้งยังไม่รับ - '. $this->moduletitle;

        $searchModel = new StaffSendBackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sendproc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAll()
    {

        Yii::$app->view->title = 'รายการดำเนินการแล้วเสร็จ - '. $this->moduletitle;

        $searchModel = new StaffCompleteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInprocess()
    {

        Yii::$app->view->title = 'รายการที่กำลังดำเนินการ - '. $this->moduletitle;

        $searchModel = new ExecprocessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('inprocess', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTechprocapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'รายงานผลของร้าน - '. $this->moduletitle;
        //print_r(Yii::$app->request->post());
        if (Yii::$app->request->post()) {
            //echo 'test';exit();
            if(isset(Yii::$app->request->post()['sendback']))
            {
                $model->status = 7;
                $model->ir_staffreturn = date('Y-m-d H:i:s');
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'แจ้งรับคืนแล้ว');
                return $this->redirect(['execstaffproc']);
            }
            print_r($model->getErrors());
            exit;
        }else{

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;

            return $this->render('execprocapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionExec()
    {

        Yii::$app->view->title = 'ผู้มีอำนาจอนุมัติ - '. $this->moduletitle;

        $searchModel = new IRExecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('exec', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUndoapprvlist()
    {

        Yii::$app->view->title = 'รายการตีกลับพัสดุ - '. $this->moduletitle;

        $searchModel = new IRAfterExecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('undoapprvlist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionExecapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'ดำเนินการอนุมัติ - '. $this->moduletitle;
        
        if ($model->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['sendback']))
            {
                $model->status = 4;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'ดำเนินการเรียบร้อย');
                return $this->redirect(['exec']);
            }
            $model->ir_execUID = Yii::$app->user->id;
            $model->ir_execdate = date('Y-m-d');
            $model->status = 6;
            if(isset(Yii::$app->request->post()['apprv']))
            {
                $model->ir_execchoice = 1;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'ดำเนินการเรียบร้อย');
                return $this->redirect(['exec']);
            }elseif(isset(Yii::$app->request->post()['notapprv']))
            {
                $model->ir_execchoice = 0;
                $model->save(false);
                AdzpireComponent::succalert('edtflsh', 'ดำเนินการเรียบร้อย');
                return $this->redirect(['exec']);
            }
            print_r($model->getErrors());
            exit;
        }else{

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;
            $detmdl = InvtRepairDetail::find()->where(['ird_irID' => $model->ir_id])->all();
            foreach ($detmdl as $key => $value){
                $searchitem[$value->ird_ivntID] = new InvtRepairDetailSearch(['ird_ivntID' => $value->ird_ivntID]);
                $dataProvideritem[$value->ird_ivntID] = $searchitem[$value->ird_ivntID]->search(Yii::$app->request->queryParams);
                $dataProvideritem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID]->sort = false;
            }
            return $this->render('execapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
                'dataProviderlist' => $dataProvideritem,
                'searchitemlist' => $searchitem,
            ]);
        }
    }

    public function actionUndoapprv($id)
    {
        $model = $this->findModel($id);
        $mdlmain = new InvtMain();

        Yii::$app->view->title = 'ดำเนินการตีกลับ - '. $this->moduletitle;


            if(isset(Yii::$app->request->post()['undoapprv']))
            {
                $model->ir_execUID = NULL;
                $model->ir_execdate = NULL;
                $model->status = 4;
                $model->ir_execchoice = NULL;
                if($model->save(false)){
                    AdzpireComponent::succalert('edtflsh', 'ตีกลับพัสดุเรียบร้อย');
                    return $this->redirect(['exec']);
                }
                print_r($model->getErrors());
                exit;
        }else{

            $searchModel = new InvtRepairDetailSearch(['ird_irID' => $model->ir_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = false;
            $detmdl = InvtRepairDetail::find()->where(['ird_irID' => $model->ir_id])->all();
            foreach ($detmdl as $key => $value){
                $searchitem[$value->ird_ivntID] = new InvtRepairDetailSearch(['ird_ivntID' => $value->ird_ivntID]);
                $dataProvideritem[$value->ird_ivntID] = $searchitem[$value->ird_ivntID]->search(Yii::$app->request->queryParams);
                $dataProvideritem[$value->ird_ivntID]->query->andWhere(['!=', 'ird_irID', $model->ir_id]);
                $dataProvideritem[$value->ird_ivntID]->sort = false;
            }
            return $this->render('undoapprv', [
                'model' => $model,
                'mdlmain' => $mdlmain,
                'dataProvider' => $dataProvider,
                'dataProviderlist' => $dataProvideritem,
                'searchitemlist' => $searchitem,
            ]);
        }
    }

    public function actionInvtdet($id)
    {
        $model = $this->findInvtModel($id);

        return $this->renderPartial('_qdetail', [
            'model' => $model,
        ]);

    }
    public function actionUndoproc($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
                $model->status = 3;
                $model->ir_execchoice = NULL;
                $model->ir_execcomment = NULL;
                $model->ir_execUID = NULL;
                $model->ir_execdate = NULL;
                if($model->save(false)){
                    AdzpireComponent::succalert('edtflsh', 'ดำเนินการเรียบร้อย');
                    return $this->redirect(['staff/toexec', 'id' => $model->ir_id]);
                }else{
                    print_r($model->getErrors());
                    exit;
                }   
        }else{
            return $this->redirect(['staff']);
        }

    }
    public function actionChangestat($id)
    {

        $model = $this->findInvtModel($id);
        //$model->invt_ID = $model->id;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
//                if(isset($model->oldstat) && $model->invt_statID != $model->oldstat) {
//
//                    $sh = new InvtStathistory();
//                    $sh->invt_ID = $model->id;
//                    $sh->invt_statID = $model->invt_statID;
//                    $sh->date = date('Y-m-d');
//
//                    if ($sh->save()) {
//                        Yii::$app->getSession()->setFlash('addlochisflsh', [
//                            'type' => 'success',
//                            'duration' => 4000,
//                            'icon' => 'glyphicon glyphicon-ok-circle',
//                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะใหม่เรียบร้อย'),
//                        ]);
//                    } else {
//                        Yii::$app->getSession()->setFlash('addlochisflsh', [
//                            'type' => 'danger',
//                            'duration' => 4000,
//                            'icon' => 'glyphicon glyphicon-ok-circle',
//                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะใหม่ไม่ได้'),
//                        ]);
//                    }
//                }
                echo 1;
            }else{
                echo 0;
            }

        }else{
            $qstat = InvtStatus::find()->all();
            $statsarray = ArrayHelper::map($qstat, 'id', 'invt_sname');

            return $this->renderAjax('changestatus', [
                'model' => $model,
                'statsarray' => $statsarray,
            ]);
        }
    }
}
