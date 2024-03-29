<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/13/16
 * Time: 10:42 AM
 */

namespace app\models;
use yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class RecordHelpers
{
    public static function userHas($model_name)
    {
        $connection = \Yii::$app->db;

        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_name WHERE user_id=:userid";
        $command = $connection->createCommand($sql);
        $command->bindValue(":userid", $userid);
        $result = $command->queryOne();
        if ($result == null) {
            return false;
        } else {
            return $result['id'];
        }
    }

    /**
     * returns the ticket status column to fetch from
     */
    public static function getTicketStatusCol()
    {
        $profile_type = self::getProfileType();


        if($profile_type == Yii::$app->params['SUBDEALER']){
            $status_col = 'status_subdea';
        }else{
            $status_col = 'status_fmcg';
        }

        return $status_col;
    }

    public static function getProductName($product_id)
    {
        $product = Products::findOne(['id' => $product_id]);
        return $product->name;
    }

    /**
     * returns the profile type of a user
     * @return int
     */
    public static function getProfileType()
    {
//        $user = User::findOne(Yii::$app->user->identity->id);
//        $user_profile = UserProfile::findOne(['id' => $user->user_profile_id]);

        $user_profile = UserProfile::findOne(Yii::$app->user->identity->user_profile_id);
        $profile_type = $user_profile->profile_type_id;

        return $profile_type;
    }

    /**
     * @param $id of the model
     * @param $newStatus
     */
    public static function changeTicketStatus($id, $newStatus)
    {
        //get either status_fmcg or status_subdealers
        $status_col = self::getTicketStatusCol();

        $ticket = Tickets::findOne(['id' => $id]);

        if($newStatus == Yii::$app->params['VIEWED_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['VIEWED_TICKET'];
            $ticket->save();
        }
        else if($newStatus == Yii::$app->params['PENDING_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['PENDING_TICKET'];
            $ticket->save();
        }
        else if($newStatus == Yii::$app->params['IN_PROGRESS_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['IN_PROGRESS_TICKET'];
            $ticket->save();
        }
        else if($newStatus == Yii::$app->params['RESOLVED_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['RESOLVED_TICKET'];
            $ticket->save();
        }
        else// if($newStatus == Yii::$app->params['CLOSED_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['CLOSED_TICKET'];
            $ticket->save();
        }
    }

    public static function getCurrentTicketStatus($id)
    {
        $status_col = self::getTicketStatusCol();

        $ticket = Tickets::findOne(['id' => $id]);
        $currentTicketStatus = $ticket->$status_col;

        return $currentTicketStatus;
    }

    /**
     * creates a history of every action made on a ticket
     * @param $ticket_id
     * @param $action_name
     */
    public static function createHistory($ticket_id, $action_name)
    {
        $user_id = Yii::$app->user->identity->id;

        $history = new History();

        $history->user_id = $user_id;
        $history->action_made = $action_name;
        $history->ticket_id = $ticket_id;

        $history->save();
    }

    /**
     * get sub issues from id of main issue
     * @param $id
     */
    public static function getSubIssues($id)
    {
        $sub_issues = SubIssue::find()
            ->where(['issue_id' => $id])
            ->all();

        $data = ArrayHelper::map($sub_issues, 'sub_issue_id', 'name');

        return $data;
    }

//    public static function createTicketTitle($issue_id, $sub_issue, $product_id)
    public static function createTicketTitle($issue_id, $POST_VAR)
    {
        $title = '';

        // append issue
        if ($issue_id == Yii::$app->params['STOCK_ISSUE']) {
            $title .= 'STOCK';
        }elseif ($issue_id == Yii::$app->params['PRODUCT_ISSUE']){
            $title .= 'PRODUCT';
        }else{
            $title .= 'OTHER';
        }


        if($issue_id != Yii::$app->params['OTHER_ISSUE']) {

            // append sub issue
            $sub_issue = $POST_VAR['sub_issue'];
            if ($sub_issue == Yii::$app->params['Running Out']) {
                $title .= '-RunningOut';
            } elseif ($sub_issue == Yii::$app->params['Out of Stock']) {
                $title .= '-OutOfStock';
            } elseif ($sub_issue == Yii::$app->params['Need New Product']) {
                $title .= '-NewProduct';
            } elseif ($sub_issue == Yii::$app->params['Product Expired']) {
                $title .= '-Expired';
            } elseif ($sub_issue == Yii::$app->params['Product Damaged']) {
                $title .= '-Damaged';
            }

//            // append product name
//            $product = Products::findOne(['id' => $product_id]);
//            $title .= "-" . $product->name;
        }

        return $title;
    }

    /**
     * return products by bar-code for user as they r creating tickets
     * @todo find a way to avoid doing many queries
     */
    public static function getProducts()
    {
        $bar_codes = Products::find()
            ->select('bar_code')->column();

        $names = Products::find()
            ->select('name')->column();

        $flavors = Products::find()
            ->select('type_flavor')->column();

        $data = array();
        for($i=0; $i< count($bar_codes); $i++)
        {
            $data[] = $bar_codes[$i] . " - " . $names[$i] . " - " .$flavors[$i];
        }

//        ****************

//        $fdata = Products::find()->where(['fmcg_id' => 17])->all();
//
//        $data = array();
//        foreach ($fdata as $foo)
//        {
//            $data[] = $foo->bar_code . " - " . $foo->name . " - " .$foo->type_flavor;
//        }


//        print_r(json_encode($data));
//        exit(0);
        return $data;
    }

    public static function retrieveProductId($bar_code_name)
    {
        $dd = explode(" ", $bar_code_name);
        $bar_code =  $dd[0];

        $product = Products::findOne(['bar_code' => $bar_code]);

        return $product->id;
    }

    public static function getDistricts()
    {
        return ArrayHelper::map(District::find()->orderBy('name')->all(), 'id', 'name');
    }

    public static function getSectors($district_id)
    {
        return Sector::find()->where(['district_id' => $district_id])->select(['id', 'name'])->orderBy('name')->asArray()->all();
    }

    public static function getCells($sector_id)
    {
        return Cell::find()->where(['sector_id' => $sector_id])->select(['id', 'name'])->orderBy('name')->asArray()->all();
    }

    /**
     * get user's profile from their profile's id.
     * @param $id
     * @return array|bool
     */
    public static function getProfile($id)
    {
        $query = new yii\db\Query();

        $profile = $query
            ->select('`name`, `tel_address`, `cell_id`')
            ->from('`user_profile`')
            ->where('`id` = ' . $id)
            ->one();

        return $profile;
    }

    public static function getFmcgs()
    {
        $profiles= UserProfile::find()
            ->where(['profile_type_id' => 3])
            -> all();

        $fmcgs = ArrayHelper::map($profiles, 'id', 'name');

        return $fmcgs;
    }

    // get all the fmcgs that approved logged-in subdealer
    public static function getMyFmcgs()
    {
        /*
         SELECT `partners`.`from_id`, `user_profile`.`name` 
        FROM `partners`, `user_profile` 
        WHERE `partners`.`to_id` = 21 AND `partners`.`confirmed` = 1 AND `partners`.`from_id` = `user_profile`.`id`
         */
        $query = new yii\db\Query();

        $myFMCGs = $query
            ->select('`partners`.`from_id`, `user_profile`.`name`')
            ->from('`partners`, `user_profile` ')
            ->where('`partners`.`to_id` = ' . Yii::$app->user->identity->user_profile_id)
            ->andWhere('`partners`.`confirmed` = 1')
            ->andWhere('`partners`.`from_id` = `user_profile`.`id`')
            ->all();

        $myFMCGs = ArrayHelper::map($myFMCGs, 'from_id', 'name');

        return $myFMCGs;
    }

    public static function ticketsByFmcgByDistrict($fmcg, $ticketStatus)
    {
        $query = new yii\db\Query();

        $currentUserDistrict = $query
            ->select(' `cell`.`district_id`')
            ->from('`user_profile`, `cell`')
            ->where('`user_profile`.`id` =' . Yii::$app->user->identity->user_profile_id)
            ->andWhere('`user_profile`.`cell_id` = `cell`.`id`')
            ->one();

        /*
         SELECT `tickets`.*
        FROM `tickets`, `user`, `user_profile`, `cell`, `products`
        WHERE `tickets`.`user_id` = `user`.`id`
            AND `user`.`user_profile_id` = `user_profile`.`id`
            AND `user_profile`.`cell_id` = `cell`.`id`
            AND `cell`.`district_id` = 1
            AND `tickets`.`product_id` = `products`.`id`
            AND `products`.`fmcg_id` = 17
         */
        if($ticketStatus == null):
            $tickets = $query
                ->select('`tickets`.*')
                ->from('`tickets`, `user`, `user_profile`, `cell`, `products` ')
                ->where('`tickets`.`product_id` = `products`.`id`')
                ->andWhere('`products`.`fmcg_id` = ' . $fmcg)
                ->andWhere('`tickets`.`user_id` = `user`.`id`')
                ->andWhere('`user`.`user_profile_id` = `user_profile`.`id`')
                ->andWhere('`user_profile`.`cell_id` = `cell`.`id`')
                ->andWhere('`cell`.`district_id` = ' . $currentUserDistrict['district_id']);
        //->all();
        else:
            $tickets = $query
                ->select('`tickets`.*')
                ->from('`tickets`, `user`, `user_profile`, `cell`, `products` ')
                ->where('`tickets`.`product_id` = `products`.`id`')
                ->andWhere('`products`.`fmcg_id` = ' . $fmcg)
                ->andWhere('`tickets`.`status_fmcg` = ' . $ticketStatus)    // get the status from the actual fmcg
                ->andWhere('`tickets`.`user_id` = `user`.`id`')
                ->andWhere('`user`.`user_profile_id` = `user_profile`.`id`')
                ->andWhere('`user_profile`.`cell_id` = `cell`.`id`')
                ->andWhere('`cell`.`district_id` = ' . $currentUserDistrict['district_id']);
            //->all();
        endif;

        return $tickets;
    }

    public static function ticketsForFmcg($ticketStatus)
    {
        $query = new yii\db\Query();

        if($ticketStatus == null):
            $tickets = $query
                ->select('`tickets`.*')
                ->from('`tickets`, `products`')
                ->where('`products`.`id` = `tickets`.`product_id`')
                ->andWhere('`products`.`fmcg_id`= ' . Yii::$app->user->identity->user_profile_id)
                ->orderBy(['created_at' => SORT_DESC]);

        else:
            $tickets = $query
                ->select('`tickets`.*')
                ->from('`tickets`, `products`')
                ->where('`products`.`id` = `tickets`.`product_id`')
                ->andWhere('`tickets`.`status_fmcg` = ' . $ticketStatus)
                ->andWhere('`products`.`fmcg_id`= ' . Yii::$app->user->identity->user_profile_id);
        endif;

        return $tickets;
    }

    public static function getDistrictName($id)
    {
        $district = District::find()->select('name')->where(['id' => $id])->one();

        return $district->name;
    }

    public static function getSectorName($id)
    {
        $sector = Sector::find()->select('name')->where(['id' => $id])->one();

        return $sector->name;
    }
    
    public static function getCellName($id)
    {
        $cell = Cell::find()->select('name')->where(['id' => $id])->one();

        return $cell->name;
    }

    public static function getDistrict_Sector_FromCell($id)
    {
        $location = Cell::find()->select(['district_id', 'sector_id'])->where(['id' => $id])->one();

        return($location);
    }


}