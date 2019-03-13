<?php
class Friends extends MX_Controller
{
    public $upload_path;
    public $upload_location;

    public function __construct()
    {
        parent::__construct();
        $this->upload_path = realpath(APPPATH. "../assets/uploads");
        $this->upload_location = base_url()."assets/uploads";
        $this->load->library("image_lib");
        $this->load->model("friends_model");
        $this->load->model("site/site_model");
        $this->load->model("site/file_model");
    }

    public function index()
    {

        // $this->form_validation->set_rules("search", "Search", "required");
        // if ($this->form_validation->run()) {
        //     $friend_id["searched_friends"] = $this->friends_model->search_friend();
        //     // if ($friend_id > 0) {
        //     //     $this->session->set_flashdata("success", "Search results found");

        //     // } else {
        //     //     $this->session->set_flashdata("error", "Friend not found");
        //     // }
        //     $data = array("title" => $this->site_model->display_page_title(),
        //         "content" => $this->load->view('friends/search_results', $friend_id, true),

        //     );
        //     $this->load->view("site/layouts/layout", $data);
        // } else {
            // start of pagination
            $segment = 3;
            $this->load->library("pagination");
            $config['base_url'] = site_url().'friends/all-friends';
            $config['total_rows'] = $this->friends_model->record_count();
            // echo $config['total_rows']; die();
            $config['uri_segment'] = $segment;
            $config['per_page'] = 5;
            $config['num_links'] = 5;
            
            $config['full_tag_open'] = '<div class="pagging text-center"><nav aria-label="Page navigation example"><ul class="pagination">';
            $config['full_tag_close'] = '</ul></nav></div>';
            $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close'] = '</span></li>';
            $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close'] = '</span></li>';
            $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close'] = '</span></li>';
            
            $this->pagination->initialize($config);

            $page = ($this->uri->segment($segment))?$this->uri->segment($segment) : 0;
            $v_data["links"] = $this->pagination->create_links();
            $all_friends = $this->friends_model->get_friends($config['per_page'],$page);
            $v_data['page'] = $page;
            $v_data["all_friends"] = $all_friends;

            $data = array("title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("friends/all_friends", $v_data, true),

            );
            $this->load->view("site/layouts/layout", $data);

            // end of pagination
        // }

        //    $friend_name =  $this->input->post('friend_name');
        //$data['results'] = $this->friends_model->search_friend($friend_name);
        // $this->load->view('pages/search_results',$data);
    }

    public function welcome($friend_id)
    {
        $my_friend = $this->friends_model->get_single_friend($friend_id);
        if ($my_friend->num_rows() > 0) {
            $row = $my_friend->row();
            $friend = $row->friend_name;
            $age = $row->friend_age;
            $gender = $row->friend_gender;
            $hobby = $row->friend_hobby;

            //form validation

            // $this->form_validation->set_rules
            //("firstname","First Name","required");
            //$this->form_validation->set_rules
            // ("age","Age","required|numeric");
            // $this->form_validation->set_rules
            // ("gender","Gender","required");
            // $this->form_validation->set_rules
            //("hobby","Hobby","required");

            // if($this->form_validation->run())
            // {
            // $friend = $this->input->post("firstname");
            // $age = $this->input->post("age");
            // $gender = $this->input->post("gender");
            //  $hobby = $this->input->post("hobby");

            //}else{
            //    $validation_errors = validation_errors();

            // }

            $data = array(
                "friend_name" => $friend,
                "friend_age" => $age,
                "friend_gender" => $gender,
                "friend_hobby" => $hobby,

            );

            //  $v_data ["welcome_here"]= "friends/Friends_model";
            // $data = array("title" => $this->site_model->display_page_title(),
            //     "content" => $this->load->view("friends/welcome_here", $v_data, true),

            // );
            // $this->load->view("site/layouts/layout", $data);

            $this->load->view("welcome_here", $data);
        } else {
            $this->session->set_flashdata("error_message", "could not find your friend");
            redirect("hello");

        }
    }

//add friend
    public function new_friend()
    {

        $this->form_validation->set_rules("firstname", "First Name", "required");
        $this->form_validation->set_rules("age", "Age", "required|numeric");
        $this->form_validation->set_rules("gender", "Gender", "required");
        $this->form_validation->set_rules("hobby", "Hobby", "required");
        // $this->form_validation->set_rules("friend_image", "Profile Image", "required");


        if ($this->form_validation->run()) {
            $resize = array(
                "width"=>600,
                "height"=>600

            );
            $upload_response = $this->file_model->upload_image($this->upload_path,"friend_image",$resize);
            if($upload_response["check"] == FALSE){
                $this->session->set_flashdata("error",$upload_response["message"]);
            }
            else{
                if($this->friends_model->add_friend($upload_response)){
                    $this->session->set_flashdata("success",$upload_response["message"]);
                    redirect("friends");
                }
                
            }
            // $friend_id = $this->friends_model->add_friend($upload_response["message"]);
            
            // redirect("friends");
        }

        $data["form_error"] = validation_errors();

        // $this->load->view("add_friend", $data);

        $v_data["add_friend"] = "friends/Friends_model";
        $data = array("title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("friends/add_friend", $v_data, true),

        );
        $this->load->view("site/layouts/layout", $data);

    }

    

    // edit button
    // public function edited_friend ()
    // {
    //     $this->form_validation->set_rules ("firstname","First Name","trim|required");
    //     $this->form_validation->set_rules ("age","Age","trim|required|numeric");
    //     $this->form_validation->set_rules ("gender","Gender","trim|required");
    //     $this->form_validation->set_rules ("hobby","Hobby","trim|required");

    //     if ($this->form_validation->run() == FALSE)
    //     {
    //         echo "failed to edit friend";
    //     }
    //     else
    //     {
    //         $friend_id = $this->input->post("friend_id");
    //         $this->friends_model->edit_friend($friend_id);
    //         $this->session->set_flashdata("success_message","Friend ID ".$friend_id." has been edited");
    //     }

    // }

    //function to display the edit form

    public function display_edit_form($friend_id)
    {
        $this->form_validation->set_rules("firstname", "First Name", "required");
        $this->form_validation->set_rules("age", "Age", "required|numeric");
        $this->form_validation->set_rules("gender", "Gender", "required");
        $this->form_validation->set_rules("hobby", "Hobby", "required");

        //if the edit form is submitted do this
        if ($this->form_validation->run()) {
            $friend_id = $this->friends_model->update_friend($friend_id);
            redirect("friends");
        } else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_flashdata("error", $validation_errors);
            }
        }

        //1. get data for the friend with the passed friend_id from the model

        $single_friend_data = $this->friends_model->get_single_friend($friend_id);
        if ($single_friend_data->num_rows() > 0) {
            $row = $single_friend_data->row();
            $friend_id = $row->friend_id;
            $friend_name = $row->friend_name;
            $friend_age = $row->friend_age;
            $friend_gender = $row->friend_gender;
            $friend_hobby = $row->friend_hobby;
        }
        $v_data = array(
            "friend_id" => $friend_id,
            "friend_name" => $friend_name,
            "friend_age" => $friend_age,
            "friend_gender" => $friend_gender,
            "friend_hobby" => $friend_hobby,

        );

        //2. Load view with the data from step 1
        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("friends/edit_friend", $v_data, true),
        );

        $this->load->view("site/layouts/layout", $data);
    }

    //delete function whereby we are updating detete column to 1
    public function delete_friend($friend_id)
    {
        //1. load model and pass friend_id so as to update the delete column of that particular friend
        $undeleted = $this->friends_model->remove_friend($friend_id);
        //2. Return all friends where the value delete column is 0; meaning, they are not deleted

        $v_data["all_friends"] = $undeleted;
        // var_dump($v_data);
        //3. load the all friends view with data from step 2
        $data = array(
            "title" => $this->site_model->display_page_title(),
            "content" => $this->load->view("friends/all_friends", $v_data, true),
        );

        $this->load->view("site/layouts/layout", $data);
    }

}
