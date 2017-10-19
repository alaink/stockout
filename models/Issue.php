<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue".
 *
 * @property integer $issue_id
 * @property string $name
 *
 * @property SubIssue[] $subIssues
 */
class Issue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'issue_id' => 'Issue ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubIssues()
    {
        return $this->hasMany(SubIssue::className(), ['issue_id' => 'issue_id']);
    }
}
