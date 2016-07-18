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
     * generate codes for user-code
     * @param $type 3 first letters of a profile type
     * @param $name of the user/company
     * @param $userId from the login
     */
    public function generateCodes($type, $name)
    {
        if($type == Yii::$app->params['RETAILER']){
            $initialCode = 'RET';
        }elseif($type == Yii::$app->params['SUBDEALER']){
            $initialCode = 'SUB';
        }else{
            $initialCode = 'FMCG';
        }

        $code = $initialCode . '-' . trim(strtoupper(substr($name,0,4)));
        
        return $code;

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

    public function getCurrentTicketStatus($id)
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
    public static function createTicketTitle($issue_id, $POST_VAR, $product_id)
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

            // append product name
            $product = Products::findOne(['id' => $product_id]);
            $title .= "-" . $product->name;
        }
        
        return $title;
    }

    /**
     * return products by bar-code for user as they r creating tickets
     * @todo find a way to avoid doing many queries
     */
    public function getProducts()
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


//        print_r($data);
//        exit(0);
        return $data;
    }

    public function retrieveProductId($bar_code_name)
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

    public static function watever()
    {
//        $tickets = Tickets::find()
//            ->select('id', 'created_at', 'status_fmcg')
//            ->where(('status_fmcg = 1'))
//            ->orWhere('status_fmcg = 3')
//            ->all();

        $query = new Query();
//        @todo do this even for subdealers
        $tickets = $query
            ->select('`id`, `created_at`, `status_fmcg`')
            ->from('`tickets`')
            ->where(('`status_fmcg` = 1 OR `status_fmcg` = 3'))
            ->all();

        foreach ($tickets as $row)
        {
            echo ($row['status_fmcg']) . '<br/>';
        }

    }

    
}