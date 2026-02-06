<?php

/**

 * CodeIgniter

 *

 * An open source application development framework for PHP

 *

 * This content is released under the MIT License (MIT)

 *

 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology

 *

 * Permission is hereby granted, free of charge, to any person obtaining a copy

 * of this software and associated documentation files (the "Software"), to deal

 * in the Software without restriction, including without limitation the rights

 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell

 * copies of the Software, and to permit persons to whom the Software is

 * furnished to do so, subject to the following conditions:

 *

 * The above copyright notice and this permission notice shall be included in

 * all copies or substantial portions of the Software.

 *

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR

 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,

 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE

 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER

 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,

 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN

 * THE SOFTWARE.

 *

 * @package	CodeIgniter

 * @author	EllisLab Dev Team

 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)

 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)

 * @license	http://opensource.org/licenses/MIT	MIT License

 * @link	https://codeigniter.com

 * @since	Version 1.0.0

 * @filesource

 */

defined('BASEPATH') or exit('No direct script access allowed');



// ------------------------------------------------------------------------



if (! function_exists('get_starlinegame_times')) {

    function get_starlinegame_times($gid)
    {

        //get main CodeIgniter object

        $ci = &get_instance();

        //load databse library

        $ci->load->database();

        //get data from database

        $query = $ci->db->get_where('starline_chart_time', array('game_id' => $gid, 'status' => 1));

        if ($query->num_rows() > 0) {

            return $query->result();

            /*$result = $query->row_array();

           return $result;*/
        } else {

            return false;
        }
    }
}



if (! function_exists('get_starlinegameallresult_result')) {

    function get_starlinegameallresult_result($gid)
    {

        //get main CodeIgniter object



        $ci = &get_instance();

        //load databse library

        $ci->load->database();

        //get data from database



        $query = $ci->db->get_where('starline_games_result', 'id=' . $gid);

        if ($query->num_rows() > 0) {

            return $query->result();

            /*$result = $query->row_array();

           return $result;*/
        } else {

            return false;
        }
    }
}





if (! function_exists('get_matka_result')) {

    function get_matka_result($dt, $gname)
    {

        //get main CodeIgniter object

        $ci = &get_instance();

        //load databse library

        $ci->load->database();

        //get data from database

        $query = $ci->db->get_where('matka_game_result', array('result_date' => $dt, 'game_name' => $gname));

        if ($query->num_rows() > 0) {

            //return $query->result();

            $result = $query->row_array();

            return $result;
        } else {

            return false;
        }
    }
}





function pr($array = '')
{

    echo '<pre style="background:yellow;">';

    print_r($array);

    echo "</pre>";
}



function AddUpdateTable($table = '', $key = '', $val = '', $data = array(), $action = "")
{
    $CI = &get_instance();

    if ($val) {
        $query = "UPDATE " . $table . " SET";
        $values = array();
        foreach ($data as $name => $value) {
            $value = "'" . $value . "'";
            $query .= " " . $name . " = " . $value . ",";
            $values[$name] = $value;
        }
        $query = substr($query, 0, -1);
        $query .= " where " . $key . "= '" . $val . "' ;";
        $sth = $CI->db->query($query, array($values));


        // return $query;
        return $val;
    } else if ($action != "updateonly") {
        $fields = array_keys($data);
        $values = array_values($data);
        $buildFields = '';
        if (is_array($fields)) {
            foreach ($fields as $key => $field) {
                if ($key == 0) {
                    $buildFields .= $field;
                } else {
                    $buildFields .= ', ' . $field;
                }
            }
        } else {
            $buildFields .= $fields;
        }
        $buildValues = '';
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $value = "'" . $value . "'";
                if ($key == 0) {
                    $buildValues .= $value;
                } else {
                    $buildValues .= ', ' . $value;
                }
            }
        } else {
            $buildValues .= "" . $values . "";
        }
        // return "INSERT INTO " . $table . "(" . $buildFields . ") VALUES (" . $buildValues . ")";
        $prepareInsert = $CI->db->query("INSERT INTO " . $table . "(" . $buildFields . ") VALUES (" . $buildValues . ")");
        // return $prepareInsert;
        // return $prepareInsert;
        return $prepareInsert;
        // return $CI->db->insert_id();
    }
}

function newAddUpdateTable($table = '', $key = '', $val = '', $data = array(), $action = "")
{
    $CI = &get_instance();

    if ($val) {
        $query = "UPDATE " . $table . " SET";
        $values = array();
        foreach ($data as $name => $value) {
            $value = "'" . $value . "'";
            $query .= " " . $name . " = " . $value . ",";
            $values[$name] = $value;
        }
        $query = substr($query, 0, -1);
        $query .= " where " . $key . "= '" . $val . "' ;";
        $sth = $CI->db->query($query, array($values));
        // return $query;
        return $val;
    } else if ($action != "updateonly") {
        $fields = array_keys($data[0]);
        $values = array_values($data);
        $buildFields = '';
        if (is_array($fields)) {
            foreach ($fields as $key => $field) {
                if ($key == 0) {
                    $buildFields .= $field;
                } else {
                    $buildFields .= ', ' . $field;
                }
            }
        } else {
            $buildFields .= $fields;
        }
        $buildValues = '';
        if (is_array($values)) {
            foreach ($values as $vs) {
                $buildValues .= "(";
                $lData = '';
                foreach ($vs as $key => $value) {
                    $lData .= "'" . $value . "',";
                }
                $buildValues .= substr($lData, 0, -1) . "),";
            }
        } else {
            $buildValues .= "" . $values . "";
        }
        // return "INSERT INTO " . $table . "(" . $buildFields . ") VALUES " . substr($buildValues, 0, -1);
        // $prepareInsert = $CI->db->query("INSERT INTO " . $table . "(" . $buildFields . ") VALUES (" . $buildValues . ")");
        $prepareInsert = $CI->db->query("INSERT INTO " . $table . "(" . $buildFields . ") VALUES " . substr($buildValues, 0, -1));
        // return $prepareInsert;
        // return $prepareInsert;
        return $prepareInsert;
        // return $CI->db->insert_id();
    }
}

function testAddUpdateTable($table = '', $key = '', $val = '', $data = array(), $action = "")
{
    $CI = &get_instance();

    if ($val) {
        $query = "UPDATE " . $table . " SET";
        $values = array();
        foreach ($data as $name => $value) {
            $value = "'" . $value . "'";
            $query .= " " . $name . " = " . $value . ",";
            $values[$name] = $value;
        }
        $query = substr($query, 0, -1);
        $query .= " where " . $key . "= '" . $val . "' ;";
        $sth = $CI->db->query($query, array($values));


        return $query;
        // return $val;

    } else if ($action != "updateonly") {
        $fields = array_keys($data);
        $values = array_values($data);
        $buildFields = '';
        if (is_array($fields)) {
            foreach ($fields as $key => $field) {
                if ($key == 0) {
                    $buildFields .= $field;
                } else {
                    $buildFields .= ', ' . $field;
                }
            }
        } else {
            $buildFields .= $fields;
        }
        $buildValues = '';
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $value = "'" . $value . "'";
                if ($key == 0) {
                    $buildValues .= $value;
                } else {
                    $buildValues .= ', ' . $value;
                }
            }
        } else {
            $buildValues .= "" . $values . "";
        }
        // return "INSERT INTO " . $table . "(" . $buildFields . ") VALUES (" . $buildValues . ")";
        $prepareInsert = $CI->db->query("INSERT INTO " . $table . "(" . $buildFields . ") VALUES (" . $buildValues . ")");
        // return $prepareInsert;
        // return $prepareInsert;
        return $prepareInsert;
        // return $CI->db->insert_id();
    }
}

function getRecordById($table_name = '', $key = '', $value = '')
{

    $CI = &get_instance();

    try {

        $stmt = $CI->db->query("SELECT * FROM {$table_name} WHERE {$key} = ?", [$value]);

        $row = $stmt->row_array();

        return $row;
    } catch (PDOException $e) {

        echo $e->getMessage();
    }

    return 0;
}
function getRecordByIdGTL($table_name = '', $key = '', $value = '')
{

    $CI = &get_instance();

    try {
        $sql = "SELECT {$table_name}.id, starline_bazar.bazar_name, {$table_name}.game_name, {$table_name}.priority, {$table_name}.status FROM {$table_name} INNER JOIN starline_bazar ON {$table_name}.id = starline_bazar.id WHERE {$table_name}.{$key} = ?";
        $stmt = $CI->db->query($sql, [$value]);

        $row = $stmt->row_array();

        return $row;
    } catch (PDOException $e) {

        echo $e->getMessage();
    }

    return 0;
}


function deleteRecord($table = '', $key = '', $value = '')
{

    $CI = &get_instance();

    $stmt = $CI->db->query("DELETE FROM {$table} WHERE {$key} = ?", [$value]);

    /*

    // Second DB Connection

    $otherdb2 = $CI->load->database('db2', TRUE);

    $sth2 = $otherdb2->query("DELETE FROM " . $table . " where " . $key . " = ". "'".$value."'");



    // Third DB Connection

    $otherdb3 = $CI->load->database('db3', TRUE);

    $sth3 = $otherdb3->query("DELETE FROM " . $table . " where " . $key . " = ". "'".$value."'");

   // return 1;



      // forth DB Connection

    $otherdb4 = $CI->load->database('db4', TRUE);

    $sth4 = $otherdb4->query("DELETE FROM " . $table . " where " . $key . " = ". "'".$value."'");

    //return 1;



      // fifth DB Connection

    $otherdb5 = $CI->load->database('db5', TRUE);

    $sth5 = $otherdb5->query("DELETE FROM " . $table . " where " . $key . " = ". "'".$value."'");    */

    return 1;
}



function getAllcustomeRecordById($table_name = '', $key = '', $value = '', $fieldarray = '')
{



    $CI = &get_instance();


    foreach ($fieldarray as $item2 => $value2) {

        $query .= "$value2, ";
    }



    $query = rtrim($query, ', ');



    try {

        $stmt = $CI->db->query("SELECT  {$query} FROM {$table_name} WHERE {$key} = ?", [$value]);

        //pr($stmt);exit;

        $row = $stmt->result_array();

        //pr($row);exit;

        return $row;
    } catch (PDOException $e) {

        echo $e->getMessage();
    }
}

/*---------------------------------- Multicurl start ------------------------------*/
function requestForMultiClient($urls, $postData)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $responses = array();
    foreach ($urls as $index => $url) {
        $res = $CI->httpclient->post($url, $postData[$index]);
        $responses[] = $res['body'];
    }
    return $responses;
}
/*---------------------------------- For Test ------------------------------*/
function requestForClientTest($url, $data)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post($url, $data);
    if ($res['error']) {
        echo "cURL Error #:" . $res['error'];
        return $res['error'];
    }
    return $res['body'];
}

/*---------------------------------- Get Balance Start ------------------------------*/
function requestForClient($url, $data)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post($url, $data);
    return $res['body'];
}
/*---------------------------------- Get Balance End ------------------------------*/
function setalmentWorli($id)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $url = 'https://matka.livedealersol.com/api/ClientData/GameHistoryByGameId?gameId=' . $id;
    $res = $CI->httpclient->get($url);
    return $res['body'];
}
/*---------------------------------- Place Bet Start ------------------------------*/
function requestForBalance($data)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post('https://node.dpbosses.live/notifyUserWithStatus', $data, array('content-type: application/json'));
    if ($res['error']) {
        echo "cURL Error #:" . $res['error'];
    }
}
/*---------------------------------- Bet Balance End ------------------------------*/
/*---------------------------------- Result Update Start ------------------------------*/
function notifyUserWithResult($data)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post('https://node.dpbosses.live/notifyUserWithResult', $data, array('content-type: application/json'));
    if ($res['error']) {
        echo "cURL Error #:" . $res['error'];
    }
}
/*---------------------------------- Result Update End ------------------------------*/
/*---------------------------------- getStrimingResult Start ------------------------------*/
function getStrimingResult($data)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $url = "https://matka.livedealersol.com/api/ClientData/GameResultByToken?token=" . $data;
    $res = $CI->httpclient->get($url);
    return $res['body'];
}
/*---------------------------------- getStrimingResult End ------------------------------*/
/*---------------------------------- Get User Detail Start ------------------------------*/
function getUserDetail($url)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->get($url);
    return $res['body'];
}
/*---------------------------------- Get User Detail End ------------------------------*/
/*---------------------------------- Get User Detail Start ------------------------------*/
function sendResultErrorLog($url, $log)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post($url, array('log' => $log));
    return $res['body'];
}
/*---------------------------------- Get User Detail End ------------------------------*/
/*---------------------------------- send Result to dpboss Start ------------------------------*/
function sendResultDpboss($data, $url)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post($url, $data);
    return $res['body'];
}
/*---------------------------------- send Result to dpboss End ------------------------------*/

/*---------------------------------- send Result to dpboss new project Start ------------------------------*/
function sendResultDpbossNewProject($data, $url)
{
    $CI = &get_instance();
    $CI->load->library('HttpClient');
    $res = $CI->httpclient->post($url, $data, array('Content-Type: application/json'));
    return $res['body'];
}
/*---------------------------------- send Result to dpboss new project End ------------------------------*/
function getWinnersClose($id)
{
    $CI = &get_instance();
    $model = $CI->db->query("SELECT result_date,bazar_name,close,jodi,open FROM regular_bazar_result WHERE id='" . $id . "' AND status='A'")->row_array();
    $cwinid = array();
    if (!empty($model)) {
        $resultdate = "result_date = '" . $model['result_date'] . "'";

        //------------------------------------------------Single Digits----------------------------------------------//

        $query1 = "SELECT id FROM regular_bazar_games WHERE " . $resultdate . " AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND (game_type = 'Close' || game_type = 'Jodi') AND game IN ('" . $model['close'] . "','" . $model['jodi'] . "','" . $model['jodi'][1] . "')";
        $single_digit = $CI->db->query($query1)->result_array();
        //------------------------------------------------Full Sangam-------------------------------------------//$single_digit = $CI->db->query($query1)->result_array();
        $query14 = "SELECT id FROM regular_bazar_games WHERE " . $resultdate . " AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game_type = 'FULL SANGAM' AND game = '" . $model['open'] . "-" . $model['close'] . "'";
        $fullSangam = $CI->db->query($query14)->result_array();
        //------------------------------------------------Half Sangam-------------------------------------------//
        $half1 = $model['open'] . '-' . $model['jodi'][1];
        $half2 = $model['jodi'][0] . '-' . $model['close'];
        // if($model['bazar_name']==15){
        //     echo$half1.'=>'.$half2;die();  
        // }
        $query15 = "SELECT id FROM regular_bazar_games WHERE " . $resultdate . " AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game_type = 'HALF SANGAM' AND (game = '" . $half1 . "' || game = '" . $half2 . "')";
        $halfSangam = $CI->db->query($query15)->result_array();
        //-----------------------------------------------------------------------------------------------------------//

        // $result_date = "u.result_date = '".$model['result_date']."'";

        // $newArray = array_merge($single_digit, $single_patti, $double_patti, $triple_patti, $jodi, $fullSangam,$halfSangam);
        $newArray = array_merge($single_digit, $fullSangam, $halfSangam);
        foreach ($newArray as $cwinr) {
            $cwinid[] = $cwinr['id'];
        }
    } else {
        $cwinid = $cwinid;
    }

    return $cwinid;
}

function getWinnersOpen($id)
{
    $CI = &get_instance();
    $model = $CI->db->query("SELECT open,jodi,result_date,bazar_name FROM regular_bazar_result WHERE id='" . $id . "'")->row_array();
    $owinid = array();
    if (!empty($model)) {
        $query1 = "SELECT id FROM regular_bazar_games WHERE result_date = '" . $model['result_date'] . "' AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game_type = 'Open' AND game IN ('" . $model['open'] . "','" . $model['jodi'][0] . "')";
        $single_digit = $CI->db->query($query1)->result_array();

        $OnewArray = $single_digit;
        foreach ($OnewArray as $owinr) {
            $owinid[] = $owinr['id'];
        }
    } else {
        $owinid = $owinid;
    }

    return $owinid;
}


function updateAllLose($table, $con, $feilds)
{
    $CI = &get_instance();
    $query = "UPDATE " . $table . " SET";
    $values = array();
    foreach ($feilds as $name => $value) {
        $value = "'" . $value . "'";
        $query .= " " . $name . " = " . $value . ",";
        $values[$name] = $value;
    }
    $query = substr($query, 0, -1);
    $query .= $con;
    // return $query;
    $sth = $CI->db->query($query);
    return $sth;
}


function getWinnersStar($id)
{
    $CI = &get_instance();
    $model = $CI->db->query("SELECT * FROM starline_bazar_result WHERE id='" . $id . "'")->row_array();
    $owinid = array();
    if (!empty($model)) {
        // $query1 = "SELECT id FROM starline_bazar_game WHERE result_date = '".$model['result_date']."' AND bazar_name = '".$model['bazar_name']."' AND status = 'P' AND game_name = '2' AND game = '".$model['result_akda']."' AND time='".$model['time']."'";
        // $single_digit = $CI->db->query($query1)->result_array();

        //------------------------------------------------Single Patti----------------------------------------------//
        // $arr1=["1","3","4","5","6","7","8","35"];
        // $query2 = "SELECT id FROM starline_bazar_game WHERE result_date = '".$model['result_date']."' AND bazar_name = '".$model['bazar_name']."' AND status = 'P' AND game_name IN ('".implode("','",$arr1)."') AND game = '".$model['result_patti']."' AND time='".$model['time']."'";
        // echo '<pre>';print_r($single_patti);die();
        $query2 = "SELECT id FROM starline_bazar_game WHERE result_date = '" . $model['result_date'] . "' AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game IN ('" . $model['result_patti'] . "','" . $model['result_akda'] . "') AND time='" . $model['time'] . "'";
        $single_patti = $CI->db->query($query2)->result_array();
        // $OnewArray = array_merge($single_digit, $single_patti);
        $OnewArray = $single_patti;
        foreach ($OnewArray as $owinr) {
            $owinid[] = $owinr['id'];
        }
    } else {
        $owinid = $owinid;
    }
    return $owinid;
}

function getWinnersKing($id)
{
    $CI = &get_instance();
    $model = $CI->db->query("SELECT  * FROM king_bazar_result WHERE id='" . $id . "'")->row_array();
    $owinid = array();
    if (!empty($model)) {
        $query1 = "SELECT id FROM king_bazar_game WHERE result_date = '" . $model['result_date'] . "' AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game_name = '3' AND game = '" . $model['result'] . "'";
        $jodi = $CI->db->query($query1)->result_array();

        // //------------------------------------------------Single Digit Left----------------------------------------------//
        $query2 = "SELECT id FROM king_bazar_game WHERE result_date = '" . $model['result_date'] . "' AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game_name = '1' AND game = '" . $model['result'][0] . "'";
        $digit1 = $CI->db->query($query2)->result_array();

        // //------------------------------------------------Single Digit Right----------------------------------------------//
        $query3 = "SELECT id FROM king_bazar_game WHERE result_date = '" . $model['result_date'] . "' AND bazar_name = '" . $model['bazar_name'] . "' AND status = 'P' AND game_name = '2' AND game = '" . $model['result'][1] . "'";
        // $query3 = "SELECT id FROM king_bazar_game WHERE result_date = '".$model['result_date']."' AND bazar_name = '".$model['bazar_name']."' AND status = 'P' AND game IN ('".$model['result'][0]."','".$model['result'][1]."','".$model['result']."')";
        $digit2 = $CI->db->query($query3)->result_array();

        $OnewArray = array_merge($jodi, $digit1, $digit2);
        // $OnewArray = $digit2;
        foreach ($OnewArray as $owinr) {
            $owinid[] = $owinr['id'];
        }
    } else {
        $owinid = $owinid;
    }
    return $owinid;
}


function getPanaList($type)
{
    $arr['SINGLEPATTI'] = [
        '120',
        '123',
        '124',
        '125',
        '126',
        '127',
        '128',
        '129',
        '130',
        '134',
        '135',
        '136',
        '137',
        '138',
        '139',
        '140',
        '145',
        '146',
        '147',
        '148',
        '149',
        '150',
        '156',
        '157',
        '158',
        '159',
        '160',
        '167',
        '168',
        '169',
        '170',
        '178',
        '179',
        '180',
        '189',
        '190',
        '230',
        '234',
        '235',
        '236',
        '237',
        '238',
        '239',
        '240',
        '245',
        '246',
        '247',
        '248',
        '249',
        '250',
        '256',
        '257',
        '258',
        '259',
        '260',
        '267',
        '268',
        '269',
        '270',
        '278',
        '279',
        '280',
        '289',
        '290',
        '340',
        '345',
        '346',
        '347',
        '348',
        '349',
        '350',
        '356',
        '357',
        '358',
        '359',
        '360',
        '367',
        '368',
        '369',
        '370',
        '378',
        '379',
        '380',
        '389',
        '390',
        '450',
        '456',
        '457',
        '458',
        '459',
        '460',
        '467',
        '468',
        '469',
        '470',
        '478',
        '479',
        '480',
        '489',
        '490',
        '560',
        '567',
        '568',
        '569',
        '570',
        '578',
        '579',
        '580',
        '589',
        '590',
        '670',
        '678',
        '679',
        '680',
        '689',
        '690',
        '780',
        '789',
        '790',
        '890'
    ];
    $arr['DOUBLEPATTI'] = [
        '100',
        '110',
        '112',
        '113',
        '114',
        '115',
        '116',
        '117',
        '118',
        '119',
        '122',
        '133',
        '144',
        '155',
        '166',
        '177',
        '188',
        '199',
        '200',
        '220',
        '223',
        '224',
        '225',
        '226',
        '227',
        '228',
        '229',
        '233',
        '244',
        '255',
        '266',
        '277',
        '288',
        '299',
        '300',
        '330',
        '334',
        '335',
        '336',
        '337',
        '338',
        '339',
        '344',
        '355',
        '366',
        '377',
        '388',
        '399',
        '400',
        '440',
        '445',
        '446',
        '447',
        '448',
        '449',
        '455',
        '466',
        '477',
        '488',
        '499',
        '500',
        '550',
        '556',
        '557',
        '558',
        '559',
        '566',
        '577',
        '588',
        '599',
        '600',
        '660',
        '667',
        '668',
        '669',
        '677',
        '688',
        '699',
        '700',
        '770',
        '778',
        '779',
        '788',
        '799',
        '800',
        '880',
        '889',
        '899',
        '900',
        '990'
    ];
    $arr['TRIPLEPATTI'] = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
    return $arr[$type];
}


function getPanaListAdmin($type)
{
    $arr['SINGLEPATTI']['1'] = ['137', '146', '236', '245', '290', '380', '470', '489', '560', '579', '678', '128'];
    $arr['SINGLEPATTI']['2'] = ['570', '237', '480', '156', '390', '147', '679', '345', '138', '589', '246', '129'];
    $arr['SINGLEPATTI']['3'] = ['580', '238', '490', '157', '346', '148', '689', '256', '139', '670', '247', '120'];
    $arr['SINGLEPATTI']['4'] = ['590', '239', '347', '158', '789', '257', '149', '680', '248', '130', '167', '356'];
    $arr['SINGLEPATTI']['5'] = ['456', '249', '357', '230', '348', '168', '780', '159', '690', '258', '140', '267'];
    $arr['SINGLEPATTI']['6'] = ['367', '240', '358', '349', '169', '790', '268', '150', '457', '259', '123', '178'];
    $arr['SINGLEPATTI']['7'] = ['458', '269', '368', '250', '359', '179', '890', '340', '160', '467', '278', '124'];
    $arr['SINGLEPATTI']['8'] = ['459', '260', '189', '369', '170', '567', '350', '134', '468', '125', '279', '378'];
    $arr['SINGLEPATTI']['9'] = ['469', '234', '450', '270', '379', '180', '568', '360', '135', '478', '289', '126'];
    $arr['SINGLEPATTI']['0'] = ['479', '280', '460', '190', '389', '145', '578', '370', '136', '569', '127', '235'];

    $arr['DOUBLEPATTI']['1'] = ['100', '335', '344', '119', '399', '155', '588', '227', '669'];
    $arr['DOUBLEPATTI']['2'] = ['200', '336', '499', '110', '660', '228', '688', '255', '778'];
    $arr['DOUBLEPATTI']['3'] = ['300', '355', '445', '166', '599', '229', '779', '337', '788'];
    $arr['DOUBLEPATTI']['4'] = ['400', '338', '446', '112', '455', '220', '699', '266', '770'];
    $arr['DOUBLEPATTI']['5'] = ['500', '339', '366', '113', '447', '122', '799', '177', '889'];
    $arr['DOUBLEPATTI']['6'] = ['600', '448', '466', '114', '556', '277', '880', '330', '899'];
    $arr['DOUBLEPATTI']['7'] = ['700', '223', '377', '115', '449', '133', '557', '188', '566'];
    $arr['DOUBLEPATTI']['8'] = ['800', '288', '440', '116', '477', '224', '558', '233', '990'];
    $arr['DOUBLEPATTI']['9'] = ['900', '225', '388', '117', '559', '144', '577', '199', '667'];
    $arr['DOUBLEPATTI']['0'] = ['226', '668', '488', '118', '334', '299', '550', '244', '677'];


    $arr['TRIPLEPATTI']['1'] = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
    // $arr['TRIPLEPATTI']['2']=['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
    return $arr[$type];
}


function transactionID($a, $b)
{
    $length = rand($a, $b);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


function checkPending($tbl, $id, $rd, $con)
{
    $CI = &get_instance();
    $query = "SELECT id FROM " . $tbl . " WHERE result_date = '" . $rd . "' AND bazar_name = '" . $id . "' AND status = 'P'" . $con;
    //   if($tbl=='starline_bazar_game' && $id=='3'&&$rd=='2024-07-29' && $con==' AND time="57"'){
    //     echo '<pre>';print_r($query);die();
    //   }
    $digit = $CI->db->query($query)->result_array();

    return $digit;
}

function getPana()
{
    return ['120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890', '100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990', '000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
}

function getPanaSpAndDp()
{
    return ['120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890', '100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990'];
}

function getJodi()
{
    return ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99", "00"];
}

function updateWalletStar($d)
{
    // die('working');
    $CI = get_instance();
    $CI->load->model('Common_model');
    $CI->load->model('ManageMatkaallgames_Model');
    if (isset($d)) {
        $lC = 0;
        $fbC = 0;
        $com = $CI->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
        $clinetC = array();
        foreach ($com as $c) {
            // if($c['client_id']=='2'){
            // 	$lC=$c['commission'];
            // }else if($c['client_id']=='4'){
            // 	$fbC=$c['commission'];
            // }
            $clinetC[$c['client_id']] = $c['commission'];
        }
        $cCR = $CI->Common_model->getData('client', '', 'id,currancy_rate', '', '', '', '', '');
        $cR = array();
        foreach ($cCR as $ek) {
            $cR[$ek['id']] = $ek['currancy_rate'];
        }
        foreach ($d as $data) {
            // echo '<pre>work';
            // print_r($d);
            // die();
            $con = ' INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id WHERE starline_bazar_game.id="' . $data . '"';
            $feilds = 'starline_bazar_game.exchange_rate,starline_bazar_game.partner_id, starline_bazar_game.customer_id, starline_bazar_game.bazar_name, starline_bazar_game.game_name, starline_bazar_game.result_date, starline_bazar_game.time, starline_bazar_game.point, starline_bazar_time.time as timeId';

            $bet = $CI->Common_model->getData('starline_bazar_game', $con, $feilds, '', '', 'One', '', '');
            // echo '<pre>';
            // print_r($data);
            // die();
            $commission = $clinetC[$bet['partner_id']];
            // if($bet['partner_id']=='2'){
            // 	$commission=$lC;
            // }
            // if($bet['partner_id']=='4'){
            // 	$commission=$fbC;
            // }
            $rate = $CI->Common_model->getData('starline_bhav', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_name="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');

            $addResult['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
            $addResult['winning_point'] = ($bet['point'] * $rate['rate']) - $addResult['commission'];
            $addResult['winning_in_rs'] = $addResult['winning_point'] * (double)$bet['exchange_rate'];
            $addResult['commission_in_rs'] = $addResult['commission'] * (double)$bet['exchange_rate'];
            $addResult['status'] = 'W';

            $updateresultid = AddUpdateTable('starline_bazar_game', 'id', $data, $addResult);
        }

        $con = " WHERE result_date='" . $bet['result_date'] . "' AND status='P' AND bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";
        $field['status'] = "L";
        $updateresultLose = updateAllLose('starline_bazar_game', $con, $field);

        /*--------------------- Setel Market Start --------------------------*/
        $con1 = " INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.result_date='" . $bet['result_date'] . "' AND starline_bazar_game.bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";


        $arrLossPartner = $CI->Common_model->getData('starline_bazar_game', $con1, 'DISTINCT starline_bazar_game.partner_id,client.end_point_url', '', '', '', '', '');
        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        foreach ($arrLossPartner as $l) {

            $con = " WHERE result_date='" . $bet['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";

            if ($l['partner_id'] == '2' || $l['partner_id'] == '5') {
                $con .= ' AND status="W"';
                $arrReq['result_date'] = $bet['result_date'];
                $arrReq['bazar_id'] = $bet['bazar_name'];
                $arrReq['time'] = $bet['timeId'];
            }
            $arrLossBet = $CI->Common_model->getData('starline_bazar_game', $con, 'transaction_id,winning_point,status,commission,customer_id', '', '', '', '', '');
            $arrReq['code'] = '601';
            $arrReq['rec'] = json_encode($arrLossBet);
            $arrReq['market'] = 'Starline Bazar';
            $arrReq['market_code'] = '401';
            // if($l['partner_id']=='2'){
            //     responseLog($cArr);
            // }
            // $req = requestForClient($l['end_point_url'],$arrReq);
            $multiUrl[$multiI] = $l['end_point_url'];
            $multiData[$multiI] = $arrReq;
            $multiI++;
        }
        $req = requestForMultiClient($multiUrl, $multiData);
        responseLog($req);
        responseLog($multiData);
        responseLog($multiUrl);
        /*--------------------- Setel Market End --------------------------*/

        $arr = [
            'status' => 200,
            'message' => 'Wallet Updated Successfully!'
        ];
    } else {
        $arr = [
            'status' => 400,
            'message' => 'Somthing Went Wrong'
        ];
    }
    die(json_encode($arr));
}


function updateWalletKing($d)
{
    $CI = get_instance();
    $CI->load->model('Common_model');
    $CI->load->model('ManageMatkaallgames_Model');
    if (isset($d)) {
        $lC = 0;
        $fbC = 0;
        $com = $CI->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
        $clinetC = array();
        foreach ($com as $c) {
            $clinetC[$c['client_id']] = $c['commission'];
        }
        $cCR = $CI->Common_model->getData('client', '', 'id,currancy_rate', '', '', '', '', '');
        $cR = array();
        foreach ($cCR as $ek) {
            $cR[$ek['id']] = $ek['currancy_rate'];
        }
        foreach ($d as $data) {

            $bet = $CI->Common_model->getData('king_bazar_game', ' WHERE id="' . $data . '"', 'exchange_rate,transaction_id,bazar_name,game_name,result_date,point,partner_id', '', '', 'One', '', '');
            
            $commission = $clinetC[$bet['partner_id']];
            $rate = $CI->Common_model->getData('king_bazar_rate', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_type="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');


            $addResult['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
            $addResult['winning_point'] = ($bet['point'] * $rate['rate']) - $addResult['commission'];
            $addResult['winning_in_rs'] = $addResult['winning_point'] * (double)$bet['exchange_rate'];
            $addResult['commission_in_rs'] = $addResult['commission'] * (double)$bet['exchange_rate'];

            $addResult['status'] = 'W';
            $updateresultid = AddUpdateTable('king_bazar_game', 'id', $data, $addResult);
        }

        $con = " WHERE result_date='" . $bet['result_date'] . "' AND status='P' AND bazar_name='" . $bet['bazar_name'] . "'";
        $field['status'] = "L";

        $updateresultLose = updateAllLose('king_bazar_game', $con, $field);

        /*--------------------- Setel Market Loss Start --------------------------*/
        $con1 = " INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.result_date='" . $bet['result_date'] . "' AND king_bazar_game.bazar_name='" . $bet['bazar_name'] . "'";


        $arrLossPartner = $CI->Common_model->getData('king_bazar_game', $con1, 'DISTINCT king_bazar_game.partner_id,client.end_point_url', '', '', '', '', '');

        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        foreach ($arrLossPartner as $l) {
            $con2 = " WHERE result_date='" . $bet['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bet['bazar_name'] . "'";
            if ($l['partner_id'] == '2' || $l['partner_id'] == '5') {
                $con2 .= ' AND status="W"';
                $arrReq['result_date'] = $bet['result_date'];
                $arrReq['bazar_id'] = $bet['bazar_name'];
            }
            $arrLossBet = $CI->Common_model->getData('king_bazar_game', $con2, 'transaction_id,winning_point,status,commission,customer_id', '', '', '', '', '');
            $arrReq['code'] = '601';
            $arrReq['rec'] = json_encode($arrLossBet);
            $arrReq['market'] = 'King Bazar';
            $arrReq['market_code'] = '501';
            
            // $req = requestForClient($l['end_point_url'],$arrReq);
           
            $multiUrl[$multiI] = $l['end_point_url'];
            $multiData[$multiI] = $arrReq;
            $multiI++;
        }
        $req = requestForMultiClient($multiUrl, $multiData);
        responseLog($req);
        responseLog($multiData);
        responseLog($multiUrl);
        /*--------------------- Setel Market Loss End --------------------------*/

        $arr = [
            'status' => 200,
            'message' => 'Wallet Updated Successfully!'
        ];
    } else {
        $arr = [
            'status' => 400,
            'message' => 'Somthing Went Wrong'
        ];
    }
    die(json_encode($arr));
}


function updateResponceLog($req, $file, $code)
{
    $path = $_SERVER['DOCUMENT_ROOT'] . "/supportTeam/application/logs/" . $file . "_responce_log.txt";
    $file = fopen($path, "a+");
    fwrite($file, "\n" . $code);
    fwrite($file, "\n" . $req);
    fclose($file);
    return true;
}

function updatePendingKing($data)
{
    $CI = get_instance();
    $CI->load->model('Common_model');
    $conMy = ' WHERE id IN ("' . implode('","', array_column($data['ids'], 'id')) . '")';
    $fieldMy['status'] = "L";

    $con1 = ' INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.id IN ("' . implode('","', array_column($data['ids'], 'id')) . '")';
    $CI->load->model('Common_model');
    $arrLoss = $CI->Common_model->getData('king_bazar_game', $con1, 'DISTINCT king_bazar_game.partner_id,client.end_point_url', '', '', '', '', '');
    $result = $CI->Common_model->getData('king_bazar_result', ' WHERE id="' . $data['res']['id'] . '"', '', '', '', 'One', '', '');

    // return json_encode($result);
    $con = " WHERE result_date='" . $result['result_date'] . "' AND bazar_name='" . $result['bazar_name'] . "' AND status='P'";

    $updateresultLose = updateAllLose('king_bazar_game', $con, $fieldMy);
    // return json_encode($updateresultLose);
    $multiUrl = [];
    $multiData = [];
    $multiI = 0;
    foreach ($arrLoss as $l) {
        if ($l['partner_id'] == '2' || $l['partner_id'] == '5') {
            $arrReq['result_date'] = $result['result_date'];
            $arrReq['bazar_id'] = $result['bazar_name'];
        }
        $con = " WHERE result_date='" . $result['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $result['bazar_name'] . "' AND status='L'";
        $arrLossBet = $CI->Common_model->getData('king_bazar_game', $con, 'transaction_id,status,winning_point,commission,customer_id', '', '', '', '', '');
        $arrReq['code'] = '601';
        $arrReq['rec'] = json_encode($arrLossBet);
        $arrReq['market'] = 'King Bazar';
        $arrReq['market_code'] = '501';
        // $r = requestForClient($l['end_point_url'],$arrReq);
        $multiUrl[$multiI] = $l['end_point_url'];
        $multiData[$multiI] = $arrReq;
        $multiI++;
    }
    $req = requestForMultiClient($multiUrl, $multiData);

    responseLog($req);
    responseLog($multiUrl);
    return json_encode(['status' => 200, 'massage' => 'Bets Updated.']);
}


function updatePendingStar($data)
{
    $CI = get_instance();
    $CI->load->model('Common_model');
    $conMy = ' WHERE id IN ("' . implode('","', array_column($data['ids'], 'id')) . '")';
    $fieldMy['status'] = "L";
    $con1 = ' INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.id IN ("' . implode('","', array_column($data['ids'], 'id')) . '")';
    $arrLoss = $CI->Common_model->getData('starline_bazar_game', $con1, 'DISTINCT starline_bazar_game.partner_id,client.end_point_url', '', '', '', '', '');
    $result = $CI->Common_model->getData('starline_bazar_result', ' WHERE id="' . $data['res']['id'] . '"', '', '', '', 'One', '', '');
    $con = " WHERE result_date='" . $result['result_date'] . "' AND bazar_name='" . $result['bazar_name'] . "' AND status='P'";
    $updateresultLose = updateAllLose('starline_bazar_game', $conMy, $fieldMy);
    $multiUrl = [];
    $multiData = [];
    $multiI = 0;
    foreach ($arrLoss as $l) {
        if ($l['partner_id'] == '2' || $l['partner_id'] == '5') {
            $arrReq['result_date'] = $result['result_date'];
            $arrReq['bazar_id'] = $result['bazar_name'];
            $arrReq['time'] = $result['time'];
        }
        $con = " WHERE result_date='" . $result['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $result['bazar_name'] . "' AND status='L' AND time='" . $result['time'] . "'";
        $arrLossBet = $CI->Common_model->getData('starline_bazar_game', $con, 'transaction_id,status,winning_point,commission,customer_id', '', '', '', '', '');
        $arrReq['code'] = '601';
        $arrReq['rec'] = json_encode($arrLossBet);
        $arrReq['market'] = 'Starline Bazar';
        $arrReq['market_code'] = '401';
        // $req = requestForClient($l['end_point_url'],$arrReq);
        $multiUrl[$multiI] = $l['end_point_url'];
        $multiData[$multiI] = $arrReq;
        $multiI++;
    }
    $req = requestForMultiClient($multiUrl, $multiData);
    responseLog($req);
    responseLog($multiUrl);
    return json_encode(['status' => 200, 'massage' => 'Bets Updated.']);
}

function responseLog($data)
{
    $log_path = APPPATH . 'logs/' . date('Y-m-d') . '-custom-log.php'; // Specify the log file path
    $log = file_put_contents($log_path, date('Y-m-d H:i:s') . ' - ' . json_encode($data) . PHP_EOL, FILE_APPEND);
    if ($log) {
        return json_encode(['status' => 200, 'message' => 'resplnse logged.']);
    } else {
        return json_encode(['status' => 400, 'message' => 'error']);
    }
}

function responseLogTest($data)
{
    $log_path = APPPATH . 'logs/' . date('Y-m-d') . '-response-logTest.php'; // Specify the log file path
    $log = file_put_contents($log_path, date('Y-m-d H:i:s') . ' - ' . json_encode($data) . PHP_EOL, FILE_APPEND);
    if ($log) {
        return json_encode(['status' => 200, 'message' => 'resplnse logged.']);
    } else {
        return json_encode(['status' => 400, 'message' => 'error']);
    }
}

function betResponseLog($data)
{
    $log_path = APPPATH . 'logs/' . date('Y-m-d') . '-bet-log.php'; // Specify the log file path
    $log = file_put_contents($log_path, date('Y-m-d H:i:s') . ' - ' . json_encode($data) . PHP_EOL, FILE_APPEND);
    if ($log) {
        return json_encode(['status' => 200, 'message' => 'resplnse logged.']);
    } else {
        return json_encode(['status' => 400, 'message' => 'error']);
    }
}

function checkTime($time)
{
    // if($_GET['app']=="BD"){
    //     return strtotime('30 minutes', strtotime($time));
    // }else{
    //     return strtotime($time);
    // }
    if ($_GET['app'] == "BD") {
        return strtotime($time . ' +30 minutes');
    } else if ($_GET['app'] == "PH") {
        // echo 'working';die();
        return strtotime($time . ' +150 minutes');
    } else {
        return strtotime($time);
    }
}

function checkBetData($data, $type)
{
    $CI = &get_instance();
    $CI->load->helper(array('form', 'url'));
    $CI->load->library('form_validation');
    if ($type == 'Regular') {

        $_POST['date'] = $_POST['result_date'];
        define('OPEN', 'Open');
        define('CLOSE', 'Close');
        define('JODI', 'Jodi');
        define('open', 'open');
        define('close', 'close');
        define('jodi', 'jodi');
        define('HALFSANGAM', 'Half Sangam');
        define('FULLSANGAM', 'Full Sangam');
        $CI->form_validation->set_rules(
            'bazar.name',
            'game.name',
            'totalAmount',
            'trim|required|integer',
            array(
                'required'      => 'Bazar name/ Game name must not empty',
                'integer'     => 'Invalid Data Format In Bazar Name/Game Name'
            )
        );
        $CI->form_validation->set_rules('game_type', 'Game type', 'trim|required|in_list[' . OPEN . ',' . CLOSE . ',' . open . ',' . close . ',' . jodi . ',' . JODI . ',' . HALFSANGAM . ',' . FULLSANGAM . ']', array(
            'required'      => 'Game type must not empty',
            'in_list'     => 'Invalid Data Format In Game Type'
        ));
        $CI->form_validation->set_rules('result_date', 'Result date', 'trim|required');
        $CI->form_validation->set_rules('customer_id', 'Customer Id', 'trim|required');
        if($_POST['tokenId']){
            $CI->form_validation->set_rules('tokenId', 'TokenId', 'trim|required');
        }
        $rule = $CI->form_validation->run();
        if ($rule != TRUE) {
            $errors = validation_errors();
            die(json_encode(["status" => 400, "message" => $errors]));
        } else {
            foreach ($_POST['games'] as $key => $object) {
                if ($_POST['game_name'] != '50' && $_POST['game_name'] != '51') {
                    if (!is_numeric($object['coin']) || !is_numeric($object['akda'])) {
                        die(json_encode(["status" => 400, "message" => "Invalid Data Format In Coin/Akda"]));
                    }
                }
            }
            return json_encode(["status" => 200, "message" => "Valid Data."]);
        }
    } else if ($type == 'Starline') {
        $CI->form_validation->set_rules(
            'bazar.name',
            'game.name',
            'totalAmount',
            'time',
            'trim|required|integer|min_length[1]|max_length[5]|',
            array(
                'required'      => 'Bazar name/ Game name must not empty',
                'integer'     => 'Invalid Data Format.'
            )
        );
        $CI->form_validation->set_rules('starTime', 'Star Time', array('trim', 'required', 'regex_match[/^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/]'));
        $CI->form_validation->set_rules('result_date', 'Result date', 'trim|required');
        $CI->form_validation->set_rules('customer_id', 'Customer Id', 'trim|required');
        $CI->form_validation->set_rules('tokenId', 'TokenId', 'trim|required');
        $rule = $CI->form_validation->run();
        if ($rule != TRUE) {
            $errors = validation_errors();
            die(json_encode(["status" => 400, "message" => $errors]));
        } else {
            foreach ($_POST['games'] as $key => $object) {
                if ($_POST['game_name'] != 50 && $_POST['game_name'] != 51) {
                    if (!is_numeric($object['coin']) || !is_numeric($object['akda'])) {
                        die(json_encode(["status" => 400, "message" => "Invalid Data Format In Coin/Akda"]));
                    }
                }
            }
            return json_encode(["status" => 200, "message" => "Valid Data."]);
        }
    } else if ($type == 'KingBazar') {
        $CI->form_validation->set_rules(
            'bazar.name',
            'game.name',
            'totalAmount',
            'trim|required|integer|min_length[1]|max_length[5]|',
            array(
                'required'      => 'Bazar name/ Game name must not empty',
                'integer'     => 'Invalid Data Format.'
            )
        );
        $CI->form_validation->set_rules('result_date', 'Result date', 'trim|required');
        $CI->form_validation->set_rules('customer_id', 'Customer Id', 'trim|required');
        $CI->form_validation->set_rules('tokenId', 'TokenId', 'trim|required');
        $rule = $CI->form_validation->run();
        if ($rule != TRUE) {
            $errors = validation_errors();
            die(json_encode(["status" => 400, "message" => $errors]));
        } else {
            foreach ($_POST['games'] as $key => $object) {
                if (!is_numeric($object['coin']) || !is_numeric($object['akda'])) {
                    die(json_encode(["status" => 400, "message" => "Invalid Data Format In Coin/Akda"]));
                }
            }
            return json_encode(["status" => 200, "message" => "Valid Data."]);
        }
    }

    function checkSumRecords($tbl, $feild, $con)
    {
        $CI = &get_instance();
        $query = "SELECT id FROM " . $tbl . " WHERE " . $con;
        $digit = $CI->db->query($query)->result_array();
        return $digit;
    }


    function t()
    {
        return ['120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890', '100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990', '000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
    }
}



/*---------------------------------- Crezy Matka Start ------------------------------*/
function requestForCrezyMatka($url, $data)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: a640ed60-8a99-0b4d-4949-0f66e3d78adb"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    }
    return $response;
}
/*---------------------------------- Crezy Matka End ------------------------------*/

/*---------------------------------- Bulk SMS Start ------------------------------*/
function requestForSMS($url)
{
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
/*---------------------------------- Bulk SMS End ------------------------------*/
/*---------------------------------- WhatsApp message Start ------------------------------*/
    function sendWhatsApp($body,$to){      
        $params=array(
            'token' => 'sqleif03x309t2lg',
            'to' => $to,
            'body' => $body
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance136409/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
/*---------------------------------- WhatsApp message End ------------------------------*/
/*---------------------------------- User Detail Start ------------------------------*/
function requestForUserDetail($url, $data)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    }
    return $response;
}

function exchangeCurrency($fromCurrency, $toCurrency)
{
    try {
        return ['status' => true, 'conversion_rate' => 1];
        // $fromCurrencyNew = "INR";
        // if(in_array($fromCurrency,['PHP','VND','IDR','THB', 'BDT', 'MYR', 'HKD', 'INR'])){
        //     $fromCurrencyNew = $fromCurrency;
        // }else if($fromCurrency == 'PH'){
        //     $fromCurrencyNew = 'PHP';
        // }else if($fromCurrency == 'BD'){
        //     $fromCurrencyNew = 'BDT';
        // }else {
        //     $fromCurrencyNew = "INR";
        // }
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.aaryapaar.exchange/api/v2/currency/get/' . $fromCurrencyNew,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // $response = json_decode($response);
        // if ($response->result == 'success') {
        //     return ['status' => true, 'conversion_rate' => $response->conversion_rates->$toCurrency];
        // } else {
        //     return ['status' => false, 'conversion_rate' => 1];
        // }
    } catch (Exception $e) {
        // return ['status' => false, 'conversion_rate' => 1];
        return ['status' => true, 'conversion_rate' => 1];
    }
}

function getMinMaxBet($currency)
{
    $CI = &get_instance();
    $con2 = " WHERE currency='" . $currency . "'";
    $limit = $CI->Common_model->getData('currency', $con2, '', '', '', 'One', '', '');
    if ($limit) {
        return $limit;
    } else {
        $limit['minBetLimit'] = 5;
        $limit['maxBetLimit'] = 50000;
        return $limit;
    }
}
    /*---------------------------------- User Detail End ------------------------------*/

function setBalance($id,$token,$app){
    $id = str_replace(" ", "+", $id);
    $this->load->model('Common_model');
    $con = ' WHERE status="A" AND client_token="' . $token . '"';
    $partner = $this->Common_model->getData('client', $con, 'id,end_point_url', '', '', 'One', '', '');
    if (!empty($partner)) {
        $_SESSION['end_point_url'] = $partner['end_point_url'];
        $data = $this->requestForClient($partner['end_point_url'], ['id' => $id, 'code' => '300']);
        $res = json_decode($data);
        if ($res->Code == 200) {
            $_SESSION['token'] = $token;
            $_SESSION['app'] = $app;
            $_SESSION['partner'] = $partner;
            $_SESSION['balance'] = $res->data[0];
            $_SESSION['userName'] = $res->data[1];
            $_SESSION['customer_id'] = $id;
        }
    }
    return;
}
