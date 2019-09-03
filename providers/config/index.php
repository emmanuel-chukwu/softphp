<?php
class Config {

    public function get_input($type, $field) {
        if ($type == "POST") $type = INPUT_POST;
        if ($type == "GET") $type = INPUT_GET;
        
        return filter_input($type, $field);
    }

    public function check_request($request) {
        if (isset($_REQUEST[$request])) return true;
        return false;
    }

    public function create_response_object($status, $status_code, $message, $data = null) {

        $response = array();
        $response['status'] = $status;
        $response['status_code'] = $status_code;
        $response['message'] = $message;
        if ($data != null) {
            $response['data'] = $data;
        }

        return json_encode($response);
    }

    public function return_as_json($sql, $fields) {
        $fields = explode(", ", $fields);
        $result = array();
        if (is_array($sql)) {
            foreach ($sql as $content) {
                $json_result = array();
                foreach ($fields as $field) {
                    $json_result[$field] = $content[$field];
                }
                $result[] = $json_result;
            }
        return json_encode($result);
        }
        else {
            return null;
        }
    }
}

$config = new Config();

?>
