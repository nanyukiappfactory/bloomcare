<?php
class Map extends MX_Controller
{
    public $upload_path;
    public $upload_location;

    public function __construct()
    {
        parent::__construct();
        $this->upload_path = realpath(APPPATH. "../assets/uploads");
        $this->upload_location = base_url()."assets/uploads";
        $this->load->library("image_lib");
        $this->load->model("map_model");
        $this->load->model("site/site_model");
        $this->load->model("site/file_model");
    }

    public function index($block,$lat,$long,$direction,$pillar_number,$door)
    {
        $save_farm_points = $this->map_model->save_mapped_points($block,$lat,$long,$direction,$pillar_number,$door);
        return $save_farm_points;
    }

    

}
