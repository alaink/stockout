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
        /**
       SELECT `tickets`.`product_id`, COUNT(`tickets`.`product_id`) AS qty, `products`.`fmcg_id` FROM `tickets`, `products`
       WHERE `products`.`id` = `tickets`.`product_id` AND `products`.`fmcg_id`= 17 GROUP BY `product_id`
        **/
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
         FROM `tickets` GROUP BY `weekno` ORDER BY `weekno`
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

    /**
     * get the range of weeks that the tickets in the database fall into
     * @return array
     */
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

    public static function formatWeeks()
    {
        $weeks = self::getCurrentWeeksRange();
        $final_weeks = array();

        if($weeks){
            for ($week = min($weeks); $week<= max($weeks); $week++)
            {
                array_push($final_weeks, (string)$week);
            }
        }
        return join($final_weeks, ",");
    }

    /**
     * fill the weeks data into 3 types of tickets, with a week-span of tickets available
     */
    public static function weeklyTicketsByTypeData()
    {
        $weeks = self::getCurrentWeeksRange();
        $tickets = self::weeklyTicketsByTypeQuery();
        $stock = array();
        $product = array();
        $other = array();

        if($weeks){
            $week = min($weeks);
            foreach ($tickets as $row)
            {
                while($week<= max($weeks))
                {
                    //echo $week . ' - ' . $row['weekno'] . ' - ' . $row['type_2'] . '<br/>';
                    if ($row['weekno'] == $week) {
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
        }

        $data = array();
        array_push($data, ["name"=>"Other", "data"=>$other]);
        array_push($data, ["name"=>"Product", "data"=>$product]);
        array_push($data, ["name"=>"Stock", "data"=>$stock]);
        return(json_encode($data, JSON_NUMERIC_CHECK));
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

    public static function distributeData()
    {
        $tickets = self::statusTicketsByRegionQuery();
        $unformated_districts = array();
        $unformated_opened = array();
        $unformated_pending = array();
        $unformated_resolved = array();
        $result = array();

        foreach ($tickets as $row)
        {
            array_push($unformated_districts, $row['district_id']);
            array_push($unformated_opened, $row['opened']);
            array_push($unformated_pending, $row['pending']);
            array_push($unformated_resolved, $row['resolved']);
        }

        array_push($result, $unformated_districts);
        array_push($result, $unformated_opened);
        array_push($result, $unformated_pending);
        array_push($result, $unformated_resolved);
        return ( $result);
    }

    public static function statusTicketsByRegionData()
    {
        $data = self::distributeData();
        
        $unformated_districts = $data[0];
        $unformated_opened = $data[1];
        $unformated_pending = $data[2];
        $unformated_resolved = $data[3];

        $final_opened = array();
        $final_pending = array();
        $final_resolved = array();
        
        for($i = 1; $i <= 30; $i++)
        {
            if(in_array($i, $unformated_districts))
            {
                $key = array_search($i, $unformated_districts);
                array_push($final_opened, $unformated_opened[$key]);
                array_push($final_pending, $unformated_pending[$key]);
                array_push($final_resolved, $unformated_resolved[$key]);
            }
            else{
                array_push($final_opened, 0);
                array_push($final_pending, 0);
                array_push($final_resolved, 0);
            }
        }

        // final formatting
        $result = array();
        array_push($result, ["name"=>"Opened", "data"=>$final_opened, 'color'=>'#ffa366']);
        array_push($result, ['name'=>'Resolved', 'data'=>$final_resolved, 'color'=>'#66ff33']);
        array_push($result, ['name'=>'Pending', 'data'=>$final_pending, 'color'=>'#ff1a1a']);

        return(json_encode($result, JSON_NUMERIC_CHECK));
    }



}