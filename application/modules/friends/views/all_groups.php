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
        <h1>My Groups</h1>
        <?php echo anchor("friends/groups/new_group","Add Group");?>
        <table class="table">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>                
                <th scope="col">Actions</th>
            </tr>
            <?php
            if($all_groups->num_rows() > 0)
            {
                $count=0; 

                foreach($all_groups->result() as $row)
                { 
                    $count++;
                    $id=$row->group_id;
                    $name=$row->group_name;
                     ?>
                  

                 <tr>
                 <td>
                        <?php echo $count;?>
                 </td>
                 <td>
                        <?php echo $name;?>
                 </td>
                 
                 <td>
                      <?php echo anchor("friends/groups/welcome/".$id,"view");?>
                 </td>
                </tr>
                <?php
                }
            }
            
            ?>
          
        </table>
    </div>
    
</body>
</html>