<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action_made
 * @property integer $ticket_id
 * @property string $created_at
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action_made', 'ticket_id'], 'required'],
            [['user_id', 'ticket_id'], 'integer'],
            [['created_at'], 'safe'],
            [['action_made'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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
            'action_made' => 'Action Made',
            'ticket_id' => 'Ticket ID',
            'created_at' => 'Created At',
        ];
    }
}
