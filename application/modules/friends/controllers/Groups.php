<?php
Class Groups extends MX_Controller {

    function __construct()
    {
        parent:: __construct();
        $this->load->model("groups_model");
        $this->load->model("site/site_model");
    }

    public function index()
    {
         
            $v_data["all_groups"]=$this->groups_model->get_groups();
    
            $data = array("title" =>$this->site_model->display_page_title(),
            "content" =>$this->load->view("friends/all_groups",$v_data, TRUE)
    
        );
            $this->load->view("site/layouts/layout",$data);
            
    
           // $data=array
            //(
             //   "all_friends"=>$this->friends_model->get_friend()
            //);
          //  $this->load->view("hello_world",$data);
    }
    
    public function welcome($group_id)
    {   
        $my_group = $this->groups_model->get_single_group($group_id);
        if($my_group->num_rows()>0)
        {
            $row = $my_group->row();
            $group = $row->group_name;
           

      
       
     $data = array(
         "group_name"=> $group,
         

     );

        $this->load->view("friends/validate_group", $data); 
    }else{
        $this->session->set_flashdata("error_message","could not find your group");
        redirect("friends/groups");

    } 
}

public function new_group(){
    $this->form_validation->set_rules ("group_name","Group Name","required");
    
    
 if($this->form_validation->run())
       {
         $group_id = $this->groups_model->add_group();
          if($group_id > 0)
          {
              $this->session->set_flashdata("success_message","New group ID ".$group_id." has been added");
          }
        
        else{
            $this->session->set_flashdata
            ("error_message", "unable to add group");
           }
           redirect("friends/groups");
        }

      $data["form_error"]=validation_errors(); 
     
     $this->load->view("friends/add_group",$data);
    }
    }
?>
