<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MX_Controller 
{
	function __construct()
	{
		parent:: __construct();
        $this->load->model("friends_model");
	}
    
	/*
	*
	*	Default action is to show all the payments
	*
	*/
	public function index($order = 'friend_name', $order_method = 'ASC') 
	{
		$where = 'friend_id > 0';
		$table = 'friend';

		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'friends/all-friends/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->friends_model->count_items($table, $where);
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
        // $config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->friends_model->get_all_friends($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
        $data['title'] = 'Friends';
        
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['all_friends'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('friends/all_friends', $v_data, true);
		
        $this->load->view("site/layouts/layout", $data);
	}
	
}
?>