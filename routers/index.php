<?php

class Router {
    
    // private $endpoints = ['user', 'products', 'customers'];
    private $endpoints = [];

    public function handle_request() {
        foreach ($this->endpoints as $endpoint) {
            if ($this->check_request($endpoint)) return $this->process_request($endpoint);
        }

        echo $this->create_404_error();
        die();
    }

    private function process_request($endpoint) {
        $file_path = 'controllers/'.$endpoint.'.php';
        if (!is_dir($file_path) && file_exists($file_path)) {
            require $file_path;
            return;
        }
        
        echo $this->create_404_error();
    }

    private function create_404_error() {
        $response = array();
        $response['status'] = false;
        $response['status_code'] = 404;
        $response['message'] = "Could not find the url you are looking for. Please check our documentation and try again.";

        return json_encode($response);
    }

    private function check_request($endpoint) {
        if (isset($_REQUEST[$endpoint])) return true;
        return false;
    }

    public function addEndpointFiles() {
        foreach ($this->endpoints as $endpoint) {
            if (!file_exists("controllers/".$endpoint.".php") && !is_dir($endpoint)) {

                $controller = fopen("controllers/".$endpoint.".php", "w") or die("Unable to open file!");
                $txt = "<?php //".$endpoint." controller ?>";
                fwrite($controller, $txt);
                fclose($controller);
                
                $model = fopen("models/".$endpoint.".php", "w") or die("Unable to open file!");
                $txt = "<?php //".$endpoint." model ?>";
                fwrite($model, $txt);
                fclose($model);

                chmod("controllers/".$endpoint.".php", 0777);
                chmod("models/".$endpoint.".php", 0777);
            }
        }
    }
}

?>
