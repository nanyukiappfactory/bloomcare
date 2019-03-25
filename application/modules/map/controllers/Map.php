<?php
class Map extends MX_Controller
{
    
    public $upload_path;
    public $upload_location;

    public function __construct()
    {
        parent::__construct();
        // Allow from any origin

    if (isset($_SERVER['HTTP_ORIGIN'])) {

        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    
        header('Access-Control-Allow-Credentials: true');
    
        header('Access-Control-Max-Age: 86400'); // cache for 1 day
    
    }
    // Access-Control headers are received during OPTIONS requests
   
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
        }
        $this->upload_path = realpath(APPPATH. "../assets/uploads");
        $this->upload_location = base_url()."assets/uploads";
        $this->load->library("image_lib");
        $this->load->model("map_model");
        $this->load->model("site/site_model");
        $this->load->model("site/file_model");
    }

    public function index()
    {
        $json_string = file_get_contents("php://input");
        //echo $json_string;
        $json_array = json_decode($json_string, true);
        // echo $json_array;

        if(is_array($json_array)){
            foreach($json_array as $onePoint){
                $save_farm_points = $this->map_model->save_mapped_points($onePoint);
                return $save_farm_points;
            }
        }
        else{
            return 'not array';
        }

        // var_dump($map_details);die();
        // return $save_farm_points;
    }

    

}
