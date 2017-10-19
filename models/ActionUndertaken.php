<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "action_undertaken".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $product_delivered
 * @property integer $product_picked
 * @property integer $pickup_underway
 * @property integer $delivery_underway
 * @property integer $stock_ordered
 *
 * @property User $user
 * @property Products $product
 */
class ActionUndertaken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action_undertaken';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'product_delivered', 'product_picked', 'pickup_underway', 'delivery_underway', 'stock_ordered'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'product_delivered' => 'Product Delivered',
            'product_picked' => 'Product Picked',
            'pickup_underway' => 'Pickup Underway',
            'delivery_underway' => 'Delivery Underway',
            'stock_ordered' => 'Stock Ordered',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
