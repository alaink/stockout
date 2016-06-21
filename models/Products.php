<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property string $fmcg_id
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

//    public $uploadedFile;

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
            [['name', 'fmcg_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['fmcg_id'], 'integer'],
            [['fmcg_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::className(), 'targetAttribute' => ['fmcg_id' => 'id']],
            //[['uploadedFile'], 'file', 'extensions' => 'xlsx, xls'],
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
            'fmcg_id' => 'Fmcg ID',
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
    public function getFmcgId()
    {
        return $this->hasOne(UserProfile::className(), ['id' => 'fmcg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Tickets::className(), ['product_id' => 'id']);
    }

    public static function importExcel($inputFile)
    {
        //$inputFile = '../uploadedFiles/products_file.xlsx';

        // read the file
        try{
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);
        }catch (Exception $e)
        {
            die('Error');
        }

        // read through the file
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // loop through rows from the file
        for($row = 1; $row <= $highestRow; $row++)
        {
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

            // skip file header
            if ($row == 1)
            {
                continue;
            }

            // create database records
            $product = new Products();
            $product->id = NULL;
            $product->name = $rowData[0][3];  // BRAND
            $product->fmcg_id = Yii::$app->user->identity->user_profile_id;
            $product->category = $rowData[0][1];
            $product->product = $rowData[0][2];
            $product->type_flavor = $rowData[0][4];
            $product->size = $rowData[0][5];
            $product->bar_code = $rowData[0][6];
            $product->save();
        }
    }
}
