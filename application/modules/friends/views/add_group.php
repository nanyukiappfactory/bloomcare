<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel ="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/themes/custom/style.css">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css "rel="stylesheet">
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
    <div class = "container">
        <?php
       
        $validation_errors = validation_errors();
        if(!empty($validation_errors)){
            echo $validation_errors;
        }
        ?>
        <!-- dynamically generating a form in brackets where to submit data to-->
    <?php echo form_open ($this->uri->uri_string());?>

    
    
   <div class="form-group">  
       <label for ="group_name">Group Name</label>
       <input type="text" name="group_name" class="form-control">
    </div>
    
       <div class="submit_button">
           <input type ="submit"value="Add Group"/>

       </div>
      
   
   <?php echo form_close() ?>
    </div>
</body>
</html>