<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel ="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/themes/custom/style.css">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css "rel="stylesheet">

</head>
<body>
    <div class ="container">
        <?php 
        $success = $this->session->flashdata("success_message");
        $error = $this->session->flashdata("error_message");
        if(!empty($success))
        {
            echo $success;
        }
        if(!empty($error)){
            echo $error;
        }
        ?>
        <h1>My friends</h1>
        <?php echo form_open($this->uri->uri_string())?>
        <div class = "form-group">        
            <input name="search" class="form-control form-control-dark w-10 col-md-3" type="text" placeholder="Search by name" aria-label="Search">
        </div>
        <div class = "form-group">  
            <input type = "submit" value="Search" class="btn btn-primary">
        </div>
        <?php echo form_close()?>
        
        <?php echo anchor("friends/new_friend","Add Friend");?>
        <table class="table">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Picture</th>
                <th scope="col">View Friend</th>
                <th scope="col">Edit Friend</th>

            </tr>
            <?php
            if($searched_friends->num_rows() > 0)
            {
                $count=0; 

                foreach($searched_friends->result() as $row)
                { 
                    $count++;
                    $id=$row->friend_id;
                    $name=$row->friend_name;
                    $age=$row->friend_age;
                    $gender=$row->friend_gender;  ?>
                  

                 <tr>
                 <td>
                        <?php echo $count;?>
                 </td>
                 <td>
                        <?php echo $name;?>
                 </td>
                 <td>
                        <?php echo $age;?>
                 </td>
                 <td>
                        <?php echo $gender;?>
                 </td>
                 <td>
                      <?php echo anchor("friends/welcome/".$id,"view","class ='btn btn-info'");?>
                 </td>
                 <td>
                 
                    <?php echo anchor("friends/friends/display_edit_form/".$id, "Edit","class ='btn btn-info'");?>
                    
                 </td>
                 <td>
                 
                    <?php echo anchor("friends/friends/delete_friend/".$id, "Delete", array("onclick"=>"return confirm('Are you sure you want to delete?')", "class"=> "btn btn-danger"));?>
                    
                 </td>
                </tr>
                
                
                <?php
                }
            }
            
            ?>
           
        </table>
        
       <!-- pagination -->
        <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav> 
<!-- end of pagination -->


    </div>
    
</body>
</html>