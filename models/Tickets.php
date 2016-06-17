<?php

namespace app\models;

use Yii;

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
 *
 * @property Products $product
 * @property User $user
 */
class Tickets extends \yii\db\ActiveRecord
{
    
    public $status_col;
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
            [['user_id'], 'required'],
            [['user_id', 'product_id', 'product_quantity', 'status_subdea', 'status_fmcg', 'created_by', 'updated_by'], 'integer'],
            [['response_time_preference', 'noticed_at', 'created_at', 'updated_at'], 'safe'],
            [['comments'], 'string'],
            [['subdea_code'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'product_id' => 'Product ID',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
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

        if($ticket_status == Yii::$app->params['NEW_TICKET']):

            $tickets = Tickets::find()->where([$status=> Yii::$app->params['NEW_TICKET']])->all();

        elseif($ticket_status == Yii::$app->params['PENDING_TICKET']) :

            $tickets = Tickets::find()->where([$status=> Yii::$app->params['PENDING_TICKET']])->all();

        elseif($ticket_status == Yii::$app->params['OLD_TICKET']) :

            $tickets = Tickets::find()->where([$status=> Yii::$app->params['OLD_TICKET']])->all();
        else:
            $tickets = Tickets::find()->where([$status=> Yii::$app->params['NEW_TICKET']])->all();

        endif;
        
        return $tickets;
    }
}
