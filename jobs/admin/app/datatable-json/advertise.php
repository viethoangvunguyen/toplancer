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

//define index of column
$columns = array(
    0 =>'id',
    1 =>'payer_name',
    2 =>'amount',
    3 =>'title',
    4 =>'url',
    5 =>'days_purchased',
    6 =>'file',
    7 =>'status',
    8 =>'registered',
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    $where .=" WHERE ";
    $where .=" ( p.payer_name LIKE '%".$params['search']['value']."%' ";
    $where .=" OR w.title LIKE '%".$params['search']['value']."%' ";
    $where .=" OR w.url LIKE '%".$params['search']['value']."%'  ) ";
}

// getting total number records without any search
$sql = "SELECT w.*,p.payer_name, p.payment_status, p.transaction_type
FROM `".$config['db']['pre']."qbm_banners` as w
INNER JOIN `".$config['db']['pre']."qbm_transactions` as p ON p.banner_id = w.id ";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if(isset($where) && $where != '') {

    $sqlTot .= $where;
    $sqlRec .= $where;
}


$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = $pdo->query($sqlTot);
$totalRecords = $queryTot->rowCount();
$queryRecords = $pdo->query($sqlRec);

//iterate on results row and create new index array of data
foreach ($queryRecords as $row) {
    //$data[] = $row;
    $id = $row['id'];
    $username = $row['payer_name'];
    $amount = $row['amount'];
    $title = $row['title'];
    $url = $row['url'];
    $url = '<a class="label label-success href="'.$url.'">Link</a>';
    $image = $row['file'];
    $days_purchased = $row['days_purchased'];
    $created_at  = date('h:i:s d/m/Y', $row['registered']);

    $t_status = $row['payment_status'];
    $status = '';
    if ($t_status == "success") {
        $status = '<span class="label label-success">'.__("Thành công").'</span><br><em>'.$row['transaction_type'].'</em>';
    } elseif ($t_status == "pending") {
        $status = '<span class="label label-warning">'.__("Đang chờ").'</span><br><em>'.$row['transaction_type'].'</em>';
    } else{
        $status = '<span class="label label-danger">'.__("Từ chối").'</span><br><em>'.$row['transaction_type'].'</em>';
    }
    $image = '<div class="pull-left m-r"><img class="img-avatar img-avatar-48" src="'.$config['site_url'].'storage/banner_advertise/'.$image.'"></div>';

    $row0 = '<td>
                <label class="css-input css-checkbox css-checkbox-default">
                    <input type="checkbox" class="service-checker" value="'.$id.'" id="row_'.$id.'" name="row_'.$id.'"><span></span>
                </label>
            </td>';
    $row1 = '<td>'.$username.'</td>';
    $row2 = '<td>'.$amount.$config['currency_sign'].'</td>';
    $row3 = '<td>'.$title.'</td>';
    $row4 = '<td>'.$url.'</td>';
    $row5 = '<td>'.$image.'</td>';
    $row6 = '<td>'.$days_purchased.'</td>';
    $row7 = '<td class="text-center">'.$status.'</td>';
    $row8 = '<td>'.$created_at.'</td>';
    $row9 = '<td class="text-center">
                <div class="btn-group">
                    <a href="#" data-url="panel/page_edit.php?id='.$id.'" data-toggle="slidePanel" class="btn btn-xs btn-default"> <i class="ion-edit"></i> Sửa</a>
                    <a href="javascript:void(0)" class="btn btn-xs btn-danger item-js-delete" data-ajax-action="deletebanner"> <i class="ion-close"></i></a>
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
        8 => $row8,
        9 => $row9
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