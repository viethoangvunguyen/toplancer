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
    1 =>'name',
    2 =>'email',
    3 =>'sex',
    4 =>'status'
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    $where .=" WHERE ";
    $where .=" ( username LIKE '".$params['search']['value']."%' ";
    $where .=" OR name LIKE '".$params['search']['value']."%' ";
    $where .=" OR email LIKE '".$params['search']['value']."%' ";

    $where .=" OR sex LIKE '".$params['search']['value']."%' )";
}

// getting total number records without any search
$sql = "SELECT * FROM `".$config['db']['pre']."admins` ";
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
    $username = $row['username'];
    $name = $row['name'];
    $email = $row['email'];
    $image = $row['image'];
    if ($image == "")
        $image = "default_user.png";
    else {
        $image = $image;
    }


    $row0 = '<td>
                <label class="css-input css-checkbox css-checkbox-default" style="padding-right: 1em;padding-left: 1em;">
                    <input type="checkbox" class="service-checker" value="'.$id.'" id="row_'.$id.'" name="row_'.$id.'"><span></span>
                </label>
            </td>';
    $row1 = '<td class="text-center">
                <div class="pull-left m-r"><img class="img-avatar img-avatar-48" src="'.$config['site_url'].'storage/profile/'.$image.'"></div>
                <p class="font-500 m-b-0">'.$name.'</p>
                <p class="text-muted m-b-0">#'.$username.'</p>
            </td>';
    $row2 = '<td>'.$email.'</td>';

    $row3 = '<td class="text-center">
                <div class="btn-group">
                    <a href="#" data-url="panel/admin_edit.php?id='.$id.'" data-toggle="slidePanel" class="btn btn-xs btn-default"> <i style="font-size: 18px;" class="ion-edit"></i> Sửa</a>
                    <a href="javascript:void(0)" class="btn btn-xs btn-default item-js-delete" data-ajax-action="deleteadmin"><i style="font-size: 18px;" class="ion-close"></i></a>
                </div>
            </td>';
    $value = array(
        "DT_RowId" => $id,
        0 => $row0,
        1 => $row1,
        2 => $row2,
        3 => $row3
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
