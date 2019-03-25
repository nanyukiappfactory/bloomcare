<?php
class Map_model extends CI_Model
{
    function save_mapped_points($onePoint){
        $data = array(
            "block_name"    =>  $onePoint['blockHead'],
            "latitude"      =>  $onePoint['Latitide'],
            "longitude"     =>  $onePoint['Longitude'],
            "direction"     =>  "null",
            "pillar_number" =>  $onePoint['PillarNumber'],
            "door"          =>  $onePoint['DoorNumber'] 
        );
        if($this->db->insert('plotted_map',$data)){
            return  "Successfully saved";
        }
        else{
            return "Error when saving";
        }
            

    }
}
