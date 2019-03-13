<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel ="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/themes/custom/style.css">
    <script src="main.js"></script>
</head>
<body>
   <!-- page for creating form -->
    <div class = "container">
        <?php
    //    returns any error message sent back by validator
        $validation_errors = validation_errors();
        if(!empty($validation_errors)){
            echo $validation_errors;
        }
        ?>
        <!-- //below generates action URL used in config file -->
    <?php echo form_open ($this->uri->uri_string());?>
   <div>
       <label for ="first_name">First Name</label>
       <input type="text" name="firstname">
    </div>
    <div>
        <label for="age">Age</label>
        <input type="number" name="age"/>
    </div>
     <div>
       <label for="gender">Gender</label>
        <input type="radio" name="gender" value="male"/>male
        <input type="radio" name="gender" value="female"/>female
    </div>
    <div>
       <label for="hobby" >Hobby</label>
       <input type="text" name="hobby" >
    </div>
       <div class="submit_button">
           <input type ="submit"value="welcome friend"/>

       </div>

   <?php echo form_close() ?>
    </div>
</body>
</html>