<?php

namespace backend\modules\ir\controllers;

use Yii;
use backend\modules\ir\models\InvtRepair;
use backend\modules\ir\models\InvtRepairSearch;
use backend\modules\ir\models\InvtRepairDetail;
use backend\modules\ir\models\InvtRepairDetailSearch;

use backend\modules\person\models\Person;

use backend\modules\inventory\models\InvtMain;
use backend\modules\inventory\models\InvtStathistory;

use backend\components\AdzpireComponent;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\mpdf\Pdf;

/**
 * InventoryrepairController implements the CRUD actions for InvtRepair model.
 */
class InventoryrepairController extends Controller
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
        ];
    }

    public $moduletitle;
//    public $invtlist;

    public function beforeAction()
    {
        //$this->checkperson = Person::findOne([Yii::$app->user->id]);
        $this->moduletitle = Yii::t('app', Yii::$app->controller->module->params['title']);

//        $attnd = InvtMain::find()->all();
//        $this->invtlist = ArrayHelper::map($attnd, 'id', 'concatened');
        return true;
    }
	 
    /**
     * Lists all InvtRepair models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = InvtRepair::fn()['name'].' - '. $this->moduletitle;
		 
        $searchModel = new InvtRepairSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InvtRepair model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = Yii::t('app', 'ดูรายละเอียด') . ' : ' .$model->ir_id.' - '. $this->moduletitle;
		 
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new InvtRepair model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

    /**
     * Updates an existing InvtRepair model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
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

    /**
     * Deletes an existing InvtRepair model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        AdzpireComponent::succalert('edtflsh', 'ลบรายการเรียบร้อย');

        return $this->redirect(['index']);
    }

    /**
     * Finds the InvtRepair model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvtRepair the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
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
                $sh = new InvtStathistory();
                $sh->invt_ID = $model->ird_ivntID;
                $sh->invt_statID = 3;
                $sh->date = date('Y-m-d');
                $sh->save();
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
            $sh = new InvtStathistory();
            $sh->invt_ID = $model->ird_ivntID;
            $sh->invt_statID = 2;
            $sh->date = date('Y-m-d');
            $sh->save();
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
}
