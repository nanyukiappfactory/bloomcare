<?php
if ( ! defined ('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function validate_user()
    {
        $where = array (
            "user_email" => $this->input->post("user_email"),
            "user_password" => md5($this->input->post("user_password"))
        );

        //run the query
        $this->db->where($where);
        $query = $this->db->get("user");

        if($query->num_rows()==1)
        {
            $row = $query->row();
            $user = array(
                "first_name" =>$row->user_first_name,
                "last_name" =>$row->user_last_name,
                "phone_number" =>$row->user_phone_number,
                "email" =>$row->user_email,
                "id" =>$row->user_id,
                "login_status" =>TRUE,
            );

            $this->session->set_userdata($user);
            $this->session->set_flashdata("success", "Welcome back " .$user["first_name"]);
            return TRUE;
        }
        else {
            $this->session->set_flashdata("error","Email or password is incorrect");
            return FALSE;
        }
    }
}
?>