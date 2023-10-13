<?php
$action = '';
$html = array('msg' => 'N', 'html' => '', 'ID' => 0);
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
}
if($action == 'rabbit_integrator_transaction_list')
{
  //## Read value
  $draw = $_POST['draw'];
  $row = $_POST['start'];
  $rowperpage = $_POST['length']; // Rows display per page
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $searchValue = $_POST['search']['value']; // Search value

  //## Search 
  $searchQuery = "";
  if ($searchValue != '') {
      $searchQuery = " payer_first_name LIKE '%" . $searchValue . "%' OR payer_last_name LIKE '%" . $searchValue . "%'";
  }
  if ($searchValue != '') {
      $searchQuery = ' WHERE ' . $searchQuery;
  }
  //## Total number of records without filtering
  $iTotalRecordsResult = $wpdb->get_results("SELECT COUNT(*) AS total_records FROM " . $wpdb->prefix . "rabbit_integrator_transaction_history", ARRAY_A);
  $iTotalRecords = $iTotalRecordsResult[0]['total_records'];
  $iTotalDisplayRecords = $iTotalRecords;

  //## Total number of record with filtering
  if (!empty($searchQuery)) {
      $iTotalDisplayRecordsResult = $wpdb->get_results("SELECT COUNT(*) AS total_records FROM " . $wpdb->prefix . "rabbit_integrator_transaction_history " . $searchQuery, ARRAY_A);
      $iTotalDisplayRecords = $iTotalDisplayRecordsResult[0]['total_records'];
  }

  //## Fetch records
    $aaData = array();
    if ($iTotalDisplayRecords > 0) {
        $aaDataResult = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_transaction_history " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage, ARRAY_A);
        for ($i = 0; $i < count($aaDataResult); $i++) {
            $markAsCompleted = '';
            if($aaDataResult[$i] == 'Pending')
                $markAsCompleted = ' <a class="rabbit-integrator-mark-completed-btn" href="'.$aaDataResult[$i]['transaction_history_id'].'">Mark as Completed</a>';
            $aaData[$i] = array(
              "transaction_history_id" => stripslashes($aaDataResult[$i]['transaction_history_id']),
              "payer_first_name" => stripslashes($aaDataResult[$i]['payer_first_name']),
              "payer_last_name" => stripslashes($aaDataResult[$i]['payer_last_name']),
              "payer_last_name" => stripslashes($aaDataResult[$i]['payer_last_name']),
              "payer_email" => stripslashes($aaDataResult[$i]['payer_email']),
              "payment_type" => stripslashes($aaDataResult[$i]['payment_type']),
              "mc_currency" => stripslashes($aaDataResult[$i]['mc_currency']),
              "payment_gross" => stripslashes($aaDataResult[$i]['payment_gross']),
              "payment_date" => stripslashes($aaDataResult[$i]['payment_date']),
              "payer_payment_status" => $aaDataResult[$i]['payer_payment_status'].$markAsCompleted,
              "txn_id" => stripslashes($aaDataResult[$i]['txn_id']),
              "json_data" => $aaDataResult[$i]
            );
        }
    }

  // ## Response
  $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $iTotalRecords,
      "iTotalDisplayRecords" => $iTotalDisplayRecords,
      "aaData" => $aaData
  );
  echo json_encode($response);
}


