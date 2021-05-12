<?php
//unset($_SESSION['blog_user_id']);
include("classes/autoloader.php");

//isset($_SESSION['blog_user_id']);
$login = new Login();
$user_data = $login->check_login($_SESSION['blog_user_id']);

if(isset($_GET['search'])){
$find=addslashes(($_GET['search']));
$query="select * from users where emer like '%$find%' || mbiemer like '%$find%'";
$database=Database::getInstance();
$results=$database->read($query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="assets/css/search.css" rel="stylesheet">
        <link href="assets/fontawesome/css/all.css" rel="stylesheet">
        <script defer src="assets/fontawesome/js/all.js"></script> 
</head>

<body id="search_page">
   <?php    
    include("navbar.php")
   ?>
        <div id="users">
        <?php
        
        $user = new User();
        if (is_array($results))
        { 
            foreach ($results as $row)
            {
               // echo '<div id="user_row" class="row m-3">';
                $users = $user->get_user($row['user_id']);
                include("user.php");
               // echo '</div>';
            }
        }
        ?>
        </div>
        
    </div>
    

<!--Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>