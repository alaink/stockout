<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property string $fmcg_code
 *
 * @property ActionUndertaken[] $actionUndertakens
 * @property Broadcast[] $broadcasts
 * @property UserProfile $fmcgCode
 * @property Tickets[] $tickets
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $productFile;

    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'fmcg_code'], 'required'],
            [['name', 'fmcg_code'], 'string', 'max' => 255],
            [['fmcg_code'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::className(), 'targetAttribute' => ['fmcg_code' => 'user_code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'fmcg_code' => 'Fmcg Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionUndertakens()
    {
        return $this->hasMany(ActionUndertaken::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBroadcasts()
    {
        return $this->hasMany(Broadcast::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFmcgCode()
    {
        return $this->hasOne(UserProfile::className(), ['user_code' => 'fmcg_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::className(), ['product_id' => 'id']);
    }

    public function uploadAttachment()
    {
        $productFileDir = \Yii::getAlias('@common') . '/uploadedFiles/productFiles/file_' . Yii::$app->user->id . '/';
        if (!is_dir($productFileDir))
            exec(mkdir($productFileDir, 0755, true));


        if ($this->validate()) {
            if (!empty($this->attachment)) {

                $location = preg_replace('/\s+/', '_', $productFileDir . $this->attachment->baseName . '.' . $this->attachment->extension);
                $this->attachment->saveAs($location);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }


    }
}
