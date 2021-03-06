<?php

namespace biz\core\controllers\sales;

use Yii;
use biz\core\components\sales\Sales as ApiSales;

/**
 * Description of PurchaseController
 *
 * @property ApiSales $api
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class SalesController extends \biz\core\base\rest\Controller
{
    /**
     * @inheritdoc
     */
    public $api = 'biz\core\components\sales\Sales';

    public function release($id)
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $model = $this->api->release($id, Yii::$app->getRequest()->getBodyParams());
            if (!$model->hasErrors()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
        return $model;
    }
}