<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/21/16
 * Time: 2:43 PM
 */

namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $uploadedFile;

    public function rules()
    {
        return [
            [['uploadedFile'], 'file', 'skipOnEmpty' => false ],//, 'extensions' => 'xlsx, xls'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->uploadedFile->saveAs('uploads/' . $this->uploadedFile->baseName . '.' . $this->uploadedFile->extension);
            return true;
        } else {
            return false;
        }
    }
}