<?php
class Map_model extends CI_Model
{
    function save_mapped_points($block,$lat,$long,$direction,$pillar_number,$door){
        $data = array(
            "block_name"    =>  $block,
            "latitude"      =>  $lat,
            "longitude"     =>  $long,
            "direction"     =>  $direction,
            "pillar_number" =>  $pillar_number,
            "door"          =>  $door 
        );
        if($this->db->insert('plotted_map',$data)){
            return  "Successfully saved";
        }
        else{
            return "Error when saving";
        }
            

    }
}
