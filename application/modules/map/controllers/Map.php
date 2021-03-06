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

            header("Access-Control-Allow-Headers: token, Content-Type");
            header('Content-Type: text/plain');
           
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
                echo json_encode($save_farm_points);
            }
        }
        else{
            return 'not array';
        }

        // var_dump($map_details);die();
        // return $save_farm_points;
    }

    public function generate_map()
    {
        $this->db->select("latitude, longitude, pillar_number, block_name");
        $this->db->where("block_name", "Block A");
        $query = $this->db->get("plotted_map");
        
        if($query->num_rows() > 0)
        {
            //echo json_encode($query->result());
            $points = array();
            $points_details = array();
            foreach($query->result() as $res)
            {
                $latitude = $res->latitude;
                $longitude = $res->longitude;
                $pillar_number = $res->pillar_number;
                $block_name = $res->block_name;
                array_push($points, array(
                    "lat" => $latitude,
                    "lng" => $longitude,
                    "pillar_number" => $pillar_number,
                    "block_name" => $block_name
                ));
                array_push($points_details, array(
                    "pillar_number" => $pillar_number
                ));
            }

            $data["points_json"] = json_encode($points);
            $data["points_details_json"] = json_encode($points_details);
            $this->load->view("points2", $data);
        }
    }

    public function get_blocks()
    {
        $block_details = $this->map_model->get_blocks();

        if($block_details->num_rows() > 0){
            echo json_encode($block_details->result());
        }
    }
}
