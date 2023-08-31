<?php
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
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
    0 =>'id',
    1 =>'product_id',
    2 =>'u.username',
    3 =>'amount',
    4 =>'featured',
    5 =>'transaction_gatway',
    6 =>'status',
    7 =>'transaction_time'
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    $where .=" WHERE ";
    $where .=" ( amount LIKE '".$params['search']['value']."%' ";
    $where .=" OR transaction_gatway LIKE '".$params['search']['value']."%' ";
    $where .=" OR u.username LIKE '".$params['search']['value']."%' ";
    $where .=" OR status LIKE '".$params['search']['value']."%' )";
}

// getting total number records without any search
$sql = "SELECT t.*, u.username as username FROM `".$config['db']['pre']."transaction` as t
INNER JOIN `".$config['db']['pre']."user` as u ON u.id = t.user_id ";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if(isset($where) && $where != '') {

    $sqlTot .= $where;
    $sqlRec .= $where;
}


$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']." LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = $pdo->query($sqlTot);
$totalRecords = $queryTot->rowCount();
$queryRecords = $pdo->query($sqlRec);

//iterate on results row and create new index array of data
foreach ($queryRecords as $row) {
    //$data[] = $row;
    $id = $row['id'];
    $username = $row['username'];
    $ad_id = $row['product_id'];
    $ad_title = $row['product_name'];
    $amount = $row['amount'];
    $payment_method = $row['transaction_gatway'];
    if($payment_method == "wallet") {
        $payment_method = "Ví điện tử";
    }
    $featured = $row['featured'];
    $urgent = $row['urgent'];
    $highlight = $row['highlight'];
    $t_status = $row['status'];
    $transaction_time = date('d/m/Y', $row['transaction_time']);
    $tans_link = '';
    $premium = '';

    $premium = '';
    $trans_link = "#";
    $trans_icon = '';
    if($row['transaction_method'] == 'membership'){
        $premium = '<span class="label label-default">'.__("Gói thành viên").'</span>';
        $trans_link = $link['PROFILE'].'/'.$username;
        $trans_icon = '<span style="font-size: 20px;color: green;">&#8593; </span>';
    }
    else if($row['transaction_method'] == 'project_fee'){
        $premium = '<span class="label label-default">'.__("Phí dự án").'</span>';
        $trans_icon = '<span style="font-size: 20px;color: green;">&#8593; </span>';
    }
    else if($row['transaction_method'] == 'deposit'){
        $premium = '<span class="label label-default">'.__("Nạp tiền").'</span>';
        $trans_icon = '<span style="font-size: 20px;color: green;">&#8593; </span>';
    }
    else if($row['transaction_method'] == 'milestone_created' || $row['transaction_method'] == 'milestone_released'){
        $premium = '<span class="label label-default">'.__("Cột mốc").'</span>';
        $trans_icon = '<span style="font-size: 20px;color: red;">&#8595; </span>';
    }else if($row['transaction_method'] == 'banner_advertise'){
        $premium = '<span class="label label-default">'.__("Banner quảng cáo").'</span>';
        $trans_icon = '<span style="font-size: 20px;color: green;">&#8593; </span>';
    }
    else if($row['transaction_method'] == 'withdraw'){
        $premium = '<span class="label label-default">'.__("Rút tiền").'</span>';
        $trans_icon = '<span style="font-size: 20px;color: red;">&#8595; </span>';
    }
    else{
        $trans_link = $link['POST-DETAIL'].'/'.$ad_id;
        $featured = $row['featured'];
        $urgent = $row['urgent'];
        $highlight = $row['highlight'];
        $trans_icon = '<span style="font-size: 20px;color: green;">&#8593; </span>';

        if ($featured == "1") {
            $premium = $premium . '<span class="label label-warning">Hot trend</span>';
        }

        if ($urgent == "1") {
            $premium = $premium . '<span class="label label-success">Khẩn cấp</span>';
        }

        if ($highlight == "1") {
            $premium = $premium . '<span class="label label-info">Top Picks</span>';
        }
    }

    $status = $invoice = '';
    if ($t_status == "success"){
        $status = '<span class="label label-success">Thành công</span>';
        $invoice = '<a href="'.$config['site_url'].'invoice/'.$id.'" target="_blank" class="btn btn-block btn-xs m-b-xs btn-success"> <i class="ion-ios-list-outline"></i> Hóa đơn</a>';
    }
    elseif($t_status == "pending") {
        $status = '<span class="label label-warning">Đang chờ</span>';
    }
    elseif($t_status == "failed") {
        $status = '<span class="label label-danger">Thất bại</span>';
    }else{
        $status = '<span class="label label-danger">Hủy</span>';
    }

    $row0 = '<td>
                <label class="css-input css-checkbox css-checkbox-default">
                    <input type="checkbox" class="service-checker" value="'.$id.'" id="row_'.$id.'" name="row_'.$id.'"><span></span>
                </label>
            </td>';
    $row1 = '<td><a href="'.$trans_link.'" target="_blank">'.$ad_title.'</a></td>';
    $row2 = '<td><a href="'.$link['PROFILE'].'/'.$username.'" target="_blank">'.$username.'</a></td>';
    $row3 = '<td>'.$trans_icon.price_format($amount).'</td>';
    $row4 = '<td>'.$premium.'</td>';
    $row5 = '<td>'.$status.'</td>';
    $row6 = '<td>'.$payment_method.'</td>';
    $row7 = '<td>'.$transaction_time.'</td>';
    $row8 = '<td class="text-center">'.$invoice.'
                <div class="btn-group">
                <a href="#" data-url="panel/transaction_edit.php?id='.$id.'" data-toggle="slidePanel" class="btn btn-xs btn-default"> <i class="ion-edit"></i> Sửa</a>
                    <a href="javascript:void(0)" class="btn btn-xs btn-danger item-js-delete" data-ajax-action="deleteTransaction"> <i class="ion-close"></i></a>
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
        6 => $row6,
        7 => $row7,
        8 => $row8
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