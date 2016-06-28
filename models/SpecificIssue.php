<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specific_issue".
 *
 * @property integer $id
 * @property integer $major_issue_id
 * @property string $name
 *
 * @property MajorIssue $majorIssue
 */
class SpecificIssue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'specific_issue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['major_issue_id', 'name'], 'required'],
            [['major_issue_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['major_issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => MajorIssue::className(), 'targetAttribute' => ['major_issue_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'major_issue_id' => 'Major Issue ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMajorIssue()
    {
        return $this->hasOne(MajorIssue::className(), ['id' => 'major_issue_id']);
    }
}
