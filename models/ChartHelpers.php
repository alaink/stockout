<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/11/16
 * Time: 11:37 AM
 */

namespace app\models;
use yii;

use yii\helpers\ArrayHelper;

/**
 * Class ChartHelpers helps in giving records from the database that will be used on the graphs on the dashboard
 * @package app\models
 */
class ChartHelpers
{

    /**
     * get product occurrence to display for dashboard
     */
    public static function getProductOccurrence()
    {

//        SELECT `tickets`.`product_id`, COUNT(`tickets`.`product_id`) AS qty, `products`.`fmcg_id` FROM `tickets`, `products`
// WHERE `products`.`id` = `tickets`.`product_id` AND `products`.`fmcg_id`= 17 GROUP BY `product_id`
        $query = new yii\db\Query();
        $products = $query
            ->select('`tickets`.`product_id`')
            ->addSelect(new yii\db\Expression('COUNT(`tickets`.`product_id`) AS qty'))
            ->addSelect('`products`.`fmcg_id`')
            ->from('`tickets`, `products`')
            ->where('`products`.`id` = `tickets`.`product_id`')
            ->andWhere('`products`.`fmcg_id`= ' . Yii::$app->user->identity->user_profile_id)
            ->groupBy('`tickets`.`product_id`')
            ->all();

        $foo = array();
        foreach ($products as $row)
        {
            array_push($foo, ['name'=>RecordHelpers::getProductName($row['product_id']), 'y'=>$row['qty']]);
        }
//        foreach ($products as $roww)
//        {
//            $roww[0] = self::getProductName($row['product_id']);
//            $roww[1] = $row['qty'];
//            array_push($foo, $roww);
//        }
//        print_r(json_encode($foo, JSON_NUMERIC_CHECK));  exit();

        return json_encode($foo, JSON_NUMERIC_CHECK);
    }

    /**
     * return the tickets by their type (stock, product, other) for dashboard graph
     * @todo retrieve by fmcg_id as in getProductOccurrence
     */
    public static function getTicketsByType()
    {
        $query = new yii\db\Query();
        $tickets = $query
            ->select('`tickets`.`type`')
            ->addSelect(new yii\db\Expression('COUNT(`tickets`.`type`) AS qty'))
            ->addSelect('`products`.`fmcg_id`')
            ->from('`tickets`, `products`')
            ->where('`products`.`id` = `tickets`.`product_id`')
            ->andWhere('`products`.`fmcg_id`= ' . Yii::$app->user->identity->user_profile_id)
            ->groupBy('`tickets`.`type`')
            ->all();

        $data = array();
        foreach ($tickets as $row)
        {
            array_push($data, ['name'=>self::getIssueName($row['type']), 'y'=>$row['qty']]);
        }

        return json_encode($data, JSON_NUMERIC_CHECK);
    }

    public static function getIssueName($id)
    {
        $issue = Issue::findOne(['issue_id' => $id]);
        return $issue->name;
    }
    
    // 30 districts
    public static function getAllDistricts()
    {
        $query = new yii\db\Query();

        $districts = $query
            ->select('`name`')
            ->from('`district`')
            ->orderBy('`province_id`')
            ->all();

        return ($districts);
    }

    public static function weeklyTicketsByTypeQuery()
    {
        /*
         SELECT yearweek(`created_at`) AS `weekno`, SUM(CASE WHEN `type` = 1 THEN 1 ELSE 0 END) AS `type_1`,
                SUM(CASE WHEN `type` = 2 THEN 1 ELSE 0 END) AS `type_2`,
                SUM(CASE WHEN `type` = 3 THEN 1 ELSE 0 END) AS `type_3`
         FROM `tickets` GROUP BY `date` ORDER BY `weekno`
         * */

        $query = new yii\db\Query();

        $tickets = $query
            ->select('YEARWEEK(`created_at`) AS weekno')
            ->addSelect(new yii\db\Expression(' SUM(CASE WHEN `type` = 1 THEN 1 ELSE 0 END) AS type_1'))
            ->addSelect(new yii\db\Expression(' SUM(CASE WHEN `type` = 2 THEN 1 ELSE 0 END) AS type_2'))
            ->addSelect(new yii\db\Expression(' SUM(CASE WHEN `type` = 3 THEN 1 ELSE 0 END) AS type_3'))
            ->from('`tickets`')
            ->groupBy('weekno')
            ->orderBy('weekno')
            ->all();
        
        return $tickets;
    }
    
    public static function getCurrentWeeksRange()
    {
        $tickets = self::weeklyTicketsByTypeQuery();
        $weeks = array();

        foreach ($tickets as $row)
        {
            array_push($weeks, $row['weekno']);
        }
        return $weeks;
    }

//    public static function weeklyTicketsByTypeData()
//    {
//        $tickets = self::weeklyTicketsByTypeQuery();
//
//        $stock = array();
//        $products = array();
//        $other = array();
//        $weeks = array();
//
//        foreach ($tickets as $row)
//        {
//            array_push($stock, $row['type_1']);
//            array_push($products, $row['type_2']);
//            array_push($other, $row['type_3']);
//            array_push($weeks, $row['weekno']);
//        }
//
//        return $stock . ';' . $products . ';' . $other . ';' . $weeks;
//    }

    public static function weeklyTicketsByTypeData()
    {
        $weeks = self::getCurrentWeeksRange();
        $tickets = self::weeklyTicketsByTypeQuery();
        $stock = array();
        $product = array();
        $other = array();

        $week = min($weeks);
        foreach ($tickets as $row)
        {
            while($week<= max($weeks))
            {
                echo $week . ' - ' . $row['weekno'] . ' - ' . $row['type_2'] . '<br/>';
                if ($row['weekno'] == $week)
                {
                    array_push($stock, $row['type_1']);
                    array_push($product, $row['type_2']);
                    array_push($other, $row['type_3']);

                    $week++;
                    break;

                }
                else{
                    array_push($stock, 0);
                    array_push($product, 0);
                    array_push($other, 0);
                    $week++;
                }

            }
        }
        return($other );
    }

    public static function statusTicketsByRegionQuery()
    {
        /*
         SELECT          
             `cell`.`district_id`,
             SUM(CASE WHEN `tickets`.`status_fmcg` = 0 THEN 1 ELSE 0 END) AS `opened`,
             SUM(CASE WHEN `tickets`.`status_fmcg` = 2 THEN 1 ELSE 0 END) AS `pending`,
             SUM(CASE WHEN `tickets`.`status_fmcg` = 4 THEN 1 ELSE 0 END) AS `resolved`
        FROM 	`tickets`,
                `products`,
                `user`,
                `user_profile`,
                `cell`
                
        WHERE 	`products`.`id` = `tickets`.`product_id` 
            AND `products`.`fmcg_id`= 17 
            AND `user`.`id` = `tickets`.`user_id`
            AND `user`.`user_profile_id` = `user_profile`.`id`
            AND `cell`.`id` = `user_profile`.`cell_id`
            
        GROUP BY `cell`.`district_id`
        ORDER BY `cell`.`district_id`
         * */

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand('
            SELECT          
             `cell`.`district_id`,
             SUM(CASE WHEN `tickets`.`status_fmcg` = 0 THEN 1 ELSE 0 END) AS `opened`,
             SUM(CASE WHEN `tickets`.`status_fmcg` = 2 THEN 1 ELSE 0 END) AS `pending`,
             SUM(CASE WHEN `tickets`.`status_fmcg` = 4 THEN 1 ELSE 0 END) AS `resolved`
        FROM 	`tickets`,
                `products`,
                `user`,
                `user_profile`,
                `cell`
                
        WHERE 	`products`.`id` = `tickets`.`product_id` 
            AND `products`.`fmcg_id`= 17 
            AND `user`.`id` = `tickets`.`user_id`
            AND `user`.`user_profile_id` = `user_profile`.`id`
            AND `cell`.`id` = `user_profile`.`cell_id`
            
        GROUP BY `cell`.`district_id`
        ORDER BY `cell`.`district_id`
            ');

        $result = $command->queryAll();

        
        return $result;
    }

    public static function statusTicketsByRegionData()
    {
        $tickets = self::statusTicketsByRegionQuery();

        $opened = array();
        $pending = array();
        $resolved = array();


        // 30 districts
        for($i = 1; $i <= 30; $i++)
        {
            foreach ($tickets as $row)
            {
//                //if($i > 1){$row = next($tickets);}
                echo $i . ' - ' . $row['district_id'] . '<br/>';
                if($i == $row['district_id'])
                {
                    array_push($opened, $row['opened']);
                    array_push($pending, $row['pending']);
                    array_push($resolved, $row['resolved']);
                }
                else{
                    array_push($opened, 0);
                    array_push($pending, 0);
                    array_push($resolved, 0);
                }
               // break;

                if($i == $row['district_id']) :
                    array_push($opened, $row['opened']);
//                    array_push($pending, $row['pending']);
//                    array_push($resolved, $row['resolved']);
                endif;

                if($i != $row['district_id']) :
                    array_push($opened, 0);
//                    array_push($pending, 0);
//                    array_push($resolved, 0);
                endif;

            }
            //continue;

        }

//        print_r($opened);
        print_r($pending);
//        print_r($resolved);

        
        
    }
}