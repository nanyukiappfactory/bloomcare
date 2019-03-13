<?php
 Class Groups_model extends CI_Model
 {
     public function add_group(){
         $data = array(
             "group_name" => $this->input->post("group_name"),
             
         );

         if($this->db->insert("group",$data))
         {
             return $this->db->insert_id();
         }else
         {
             return FALSE;
         }


     }

     public function get_groups()
     {
         $this->db->order_by("created","DESC");
         return $this->db->get("group");
     }
     public function get_single_group($group_id)
     {
         $this->db->where("group_id",$group_id);
         return $this->db->get("group");
     }
 }
?>