<?php
/*
Copyright (c) 2015 Devendra Katariya (bylancer.com)
*/
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
// Path to app folder.
define("APPPATH", ROOTPATH."/php/");

require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';

admin_session_start();
$pdo = ORM::get_db();

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;
if($params['draw'] == 1)
    $params['order'][0]['dir'] = "desc";
//define index of column
$columns = array(
    0 =>'message_id',
    1 =>'from_id',
    2 =>'to_id',
    3 =>'message_content',
    4 =>'message_date',
    5 =>'recd'
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    $where .=" WHERE ";
    $where .=" ( from_uname LIKE '".$params['search']['value']."%' ";
    $where .=" OR to_uname LIKE '".$params['search']['value']."%' ";
    $where .=" OR message_content LIKE '".$params['search']['value']."%' )";
    $where .=" AND ( message_type = 'text' )";
}

// getting total number records without any search
$sql = "SELECT * FROM `".$config['db']['pre']."messages`";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if(isset($where) && $where != '') {

    $sqlTot .= $where;
    $sqlRec .= $where;
}else{
    $where .=" Where ( message_type = 'text' )";
    $sqlTot .= $where;
    $sqlRec .= $where;
}


$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']." LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = $pdo->query($sqlTot);
$totalRecords = $queryTot->rowCount();
$queryRecords = $pdo->query($sqlRec);

//iterate on results row and create new index array of data
foreach ($queryRecords as $row) {
    //$data[] = $row;
    $id = $row['message_id'];
    $msgdate = $row['message_date'];
    $msgcontent = $row['message_content'];
    $recd = $row['recd'];
    $msgtype = $row['message_type'];

    $picname = "";
    $picname2 = "";

    $query1 = "SELECT image,name,username FROM `".$config['db']['pre']."user` WHERE id='".$row['from_id']."' LIMIT 1";
    $row1 = $pdo->query($query1);
    foreach ($row1 as $info) {
        $picname = $info['image'];
        $from_fullname = (isset($info['name'])) ? $info['name'] : $info['username'];
        $fromuname = $info['username'];
    }
    $query4 = "SELECT image,name,username FROM `".$config['db']['pre']."user` WHERE id='".$row['to_id']."' LIMIT 1";
    $row2 = $pdo->query($query4);
    foreach ($row2 as $info4) {
        $picname2 = $info4['image'];
        $to_fullname = (isset($info4['name'])) ? $info4['name'] : $info4['username'];
        $touname = $info4['username'];
    }

    if ($recd == "0"){
        $recd = '<span class="label label-info">Chưa đọc</span>';
    }
    elseif($recd == "1")
    {
        $recd = '<span class="label label-success">Đã đọc</span>';
    }

    $row0 = '<td>
                <label class="css-input css-checkbox css-checkbox-default">
                    <input type="checkbox" class="service-checker" value="'.$id.'" id="row_'.$id.'" name="row_'.$id.'"><span></span>
                </label>
            </td>';
    $row1 = '<td class="text-center">
                <div class="pull-left m-r"><img class="img-avatar img-avatar-48" src="'.$config['site_url'].'storage/profile/'.$picname.'"></div>
                <p class="font-500 m-b-0">'.$from_fullname.'</p>
                <p class="text-muted m-b-0">#'.$fromuname.'</p>
            </td>';
    $row2 = '<td class="text-center">
                <div class="pull-left m-r"><img class="img-avatar img-avatar-48" src="'.$config['site_url'].'storage/profile/'.$picname2.'"></div>
                <p class="font-500 m-b-0">'.$to_fullname.'</p>
                <p class="text-muted m-b-0">#'.$touname.'</p>
            </td>';
    $row3 = '<td class="hidden-xs hidden-sm">'.$msgcontent.'</td>';
    $row4 = '<td class="hidden-xs hidden-sm">'.date('d/m/Y H:i:s', strtotime($msgdate)).'</td>';
    $row5 = '<td class="hidden-xs hidden-sm">'.$recd.'</td>';
    $row6 = '<td class="text-center">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-xs btn-danger item-js-delete" data-ajax-action="deleteMessage"><i class="ion-close"></i> Xóa</a>
                </div>
            </td>';
    $value = array(
        "DT_RowId" => $id,
        0 => $row0,
        1 => $row1,
        2 => $row2,
        3 => $row3,
        4 => $row4,
        5 => $row5,
        6 => $row6
    );
    $data[] = $value;
}

$json_data = array(
    "draw"            => intval( $params['draw'] ),
    "recordsTotal"    => intval( $totalRecords ),
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
?>
