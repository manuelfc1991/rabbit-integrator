<?php
$action = '';
$html = array('msg' => 'N', 'html' => '', 'ID' => 0);
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
}
if($action == 'rabbit_integrator_new_template')
{
    $template_data = $_POST['template_data'];
    parse_str($template_data, $template_data_array);
    $title  = $template_data_array['title'];
    $price   = floatval($template_data_array['price']);
    $btn_txt = $template_data_array['button_text'];
    $btn_txt_size = $template_data_array['button_text_size'];
    $btn_width = $template_data_array['button_width'];
    $btn_height = $template_data_array['button_height'];
    $btn_txt_color = $template_data_array['button_text_color'];
    $btn_color = $template_data_array['button_color'];

    $id = isset($template_data_array['id']) ? $template_data_array['id'] : 0;

    $data = array(
        'template_title' => $title,
        'template_price' => $price,
        'template_btn_txt' => $btn_txt,
        'template_btn_txt_size' => $btn_txt_size,
        'template_btn_width' => $btn_width,
        'template_btn_height' => $btn_height,
        'template_btn_txt_color' => $btn_txt_color,
        'template_btn_bg_color' => $btn_color,
        'template_status' => 'Y'
    );

    $data_format = array('%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s');

    $table_name = $wpdb->prefix . 'rabbit_integrator_template';

    $where = array(
    'template_id' => $id 
    );

    if($id)
    {
        $wpdb->update($wpdb->prefix . 'rabbit_integrator_template', $data, $where);
        $html['msg'] = 'Y';
        $html['ID'] = $id;
    }
    else 
    {
        $wpdb->insert($table_name, $data, $data_format);
        // $wpdb->insert($wpdb->prefix."rabbit_integrator_template", array( 'template_title' => $title, 'template_price' => $price, 'template_btn_txt' => $btn_txt, 'template_btn_txt_size' => $btn_txt_size, 'template_btn_width' => $btn_width, 'template_btn_height' => $btn_height, 'template_btn_txt_color' => $btn_txt_color, 'template_btn_bg_color' => $btn_color, 'template_status' => 'Y'), array('%s','%s','%s','%s','%s','%s','%s','%s','%s') );
        $inserted_id = $wpdb->insert_id;
        $html['msg'] = 'Y';
        $html['ID'] = $inserted_id;
    }
    
    echo json_encode($html);
}
else if($action == 'rabbit_integrator_template_list')
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
        $searchQuery = " template_id = '$searchValue' OR template_title LIKE '%" . $searchValue . "%'";
    }
    if ($searchValue != '') {
        $searchQuery = ' WHERE ' . $searchQuery;
    }
    //## Total number of records without filtering
    $iTotalRecordsResult = $wpdb->get_results("SELECT COUNT(*) AS total_records FROM " . $wpdb->prefix . "rabbit_integrator_template", ARRAY_A);
    $iTotalRecords = $iTotalRecordsResult[0]['total_records'];
    $iTotalDisplayRecords = $iTotalRecords;

    //## Total number of record with filtering
    if (!empty($searchQuery)) {
        $iTotalDisplayRecordsResult = $wpdb->get_results("SELECT COUNT(*) AS total_records FROM " . $wpdb->prefix . "rabbit_integrator_template " . $searchQuery, ARRAY_A);
        $iTotalDisplayRecords = $iTotalDisplayRecordsResult[0]['total_records'];
    }
    
    //## Fetch records
    $aaData = array();
    if ($iTotalDisplayRecords > 0) {
        $aaDataResult = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_template " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage, ARRAY_A);
        for ($i = 0; $i < count($aaDataResult); $i++) {
            $aaData[$i] = array(
                "template_id" => $aaDataResult[$i]['template_id'],
                "template_title" => stripslashes($aaDataResult[$i]['template_title']),
                "template_price" => stripslashes($aaDataResult[$i]['template_price']),
                "template_datetime" => date('Y-m-d', strtotime($aaDataResult[$i]['template_datetime']))
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