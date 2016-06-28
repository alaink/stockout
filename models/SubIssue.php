<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_issue".
 *
 * @property integer $sub_issue_id
 * @property integer $issue_id
 * @property string $name
 *
 * @property Issue $issue
 */
class SubIssue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_issue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['issue_id', 'name'], 'required'],
            [['issue_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Issue::className(), 'targetAttribute' => ['issue_id' => 'issue_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sub_issue_id' => 'Sub Issue ID',
            'issue_id' => 'Issue ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssue()
    {
        return $this->hasOne(Issue::className(), ['issue_id' => 'issue_id']);
    }
}
