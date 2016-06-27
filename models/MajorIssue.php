<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "major_issue".
 *
 * @property integer $id
 * @property string $name
 *
 * @property SpecificIssue[] $specificIssues
 */
class MajorIssue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'major_issue';
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
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificIssues()
    {
        return $this->hasMany(SpecificIssue::className(), ['major_issue_id' => 'id']);
    }
}
