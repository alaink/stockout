<?php

namespace app\controllers;

use app\models\Products;
use yii\base\Exception;

class ProductsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImportExcel()
    {
        $inputFile = '../uploadedFiles/products_file.xlsx';

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
            $product->name = $rowData[0][1];
            $product->fmcg_code = $rowData[0][2];
            $product->save();
        }
        die('okay');
    }

}
