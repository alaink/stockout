<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/20/16
 * Time: 4:12 PM
 */

namespace app\controllers;

use Yii;
use app\models\ActionUndertaken;
use app\models\Tickets;
use app\models\RecordHelpers;
use yii\web\NotFoundHttpException;

class ActionUndertakenController extends \yii\web\Controller
{
    /**
     * open  a view to resolve a ticket
     * @param $id
     * @return string
     */
    public function actionResolve($id)
    {
        $tickets = Tickets::findOne(['id' => $id]);

        $model = new ActionUndertaken();

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->identity->id;
            $model->product_id = $tickets->product_id;
            $model->save();

            RecordHelpers::changeTicketStatus($id, Yii::$app->params['RESOLVED_TICKET']);

            return $this->redirect(['/tickets/index']);//, 'id' => $model->id]);
        } else {
            return $this->render('resolve', [
                'model' => $model,
                'tickets' => $tickets
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = ActionUndertaken::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}