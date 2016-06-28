<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tickets".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property string $subdea_code
 * @property integer $product_quantity
 * @property string $response_time_preference
 * @property string $noticed_at
 * @property string $comments
 * @property integer $status_subdea
 * @property integer $status_fmcg
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $title
 *
 * @property Products $product
 * @property User $user
 */
class Tickets extends \yii\db\ActiveRecord
{
    
    public $status_col;
    public $issue;
    public $sub_issue;

    public $stock_issues = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id', 'product_id', 'product_quantity', 'status_subdea', 'status_fmcg', 'created_by', 'updated_by'], 'integer'],
            [['response_time_preference', 'noticed_at', 'created_at', 'updated_at'], 'safe'],
            [['comments'], 'string'],
            [['subdea_code', 'title'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
//            'product_id' => 'Product ID',
            'product_id' => 'Product Name',
            'subdea_code' => 'Subdea Code',
            'product_quantity' => 'Product Quantity',
            'response_time_preference' => 'Response Time Preference',
            'noticed_at' => 'Noticed At',
            'comments' => 'Comments',
            'status_subdea' => 'Status Subdea',
            'status_fmcg' => 'Status Fmcg',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'title' => 'Title'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    public function getProductName()
    {
        $product = Products::findOne(['id' => $this->product_id]);
        return $product->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public static function getTicketsByStatus($status){
        
        $ticket_status = Yii::$app->request->get('status');
        $user_id = Yii::$app->user->identity->id;

        if($ticket_status == Yii::$app->params['NEW_TICKET']):

            $tickets = Tickets::find()->where([
                $status=> Yii::$app->params['NEW_TICKET'],
                'user_id' => $user_id
            ])->all();

        elseif($ticket_status == Yii::$app->params['PENDING_TICKET']) :

            $tickets = Tickets::find()->where([
                $status=> Yii::$app->params['PENDING_TICKET'], 'user_id' => $user_id])->all();

        elseif($ticket_status == Yii::$app->params['OLD_TICKET']) :

            $tickets = Tickets::find()->where([
                $status=> Yii::$app->params['OLD_TICKET'], 'user_id' => $user_id,])->all();
        else:
            $tickets = Tickets::find()->where([
                $status=> Yii::$app->params['NEW_TICKET'], 'user_id' => $user_id,])->all();

        endif;
        
        return $tickets;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function printStatus($status)
    {
        if($status == Yii::$app->params['NEW_TICKET']){
            return "New";
        }
        elseif ($status == Yii::$app->params['VIEWED_TICKET']){
            return "Viewed";
        }
        elseif ($status == Yii::$app->params['PENDING_TICKET']){
            return "Pending";
        }
        elseif ($status == Yii::$app->params['IN_PROGRESS_TICKET']){
            return "In Progress";
        }
        elseif ($status == Yii::$app->params['RESOLVED_TICKET']){
            return "Resolved";
        }
        elseif ($status == Yii::$app->params['CLOSED_TICKET']){
            return "Closed";
        }
    }
}
