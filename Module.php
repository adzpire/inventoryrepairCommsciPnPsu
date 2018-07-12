<?php

namespace backend\modules\ir;

use Yii;
/**
 * ir module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\ir\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::$app->formatter->locale = 'th_TH';
        Yii::$app->formatter->calendar = \IntlDateFormatter::TRADITIONAL;
        if (!isset(\Yii::$app->i18n->translations['tc'])) {
            \Yii::$app->i18n->translations['tc'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@backend/modules/ir/messages',
            ];
        }
		parent::init();

		$this->layout = 'ir';
		$this->params['ModuleVers'] = '1.1';
		$this->params['title'] = 'ระบบแจ้งซ่อมพัสดุ/ครุภัณฑ์';
        $this->params['modulecookies'] = 'irck';
        $this->params['lineprog'] = 'ระบบแจ้งซ่อมฯ';
        // custom initialization code goes here
    }
}
