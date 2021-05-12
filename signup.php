<?php
ob_start();
include("connection.php");
include("classes/signup.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $signup = new Signup();
    $result = $signup->evaluate($_POST);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FTI blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="assets/css/signup.css" rel="stylesheet">
    <link href="assets/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="assets/fontawesome/js/all.js"></script>
    <script defer src="assets/js/signup.js"></script>

</head>

<body id="signupPage">
    <div class="container h-100">
        <div class="row justify-content-end h-100">
            <div class="col" id="empty_col"></div>
            <div id="signup_row" class="col-lg-6 col-md-12 col-s-12 d-flex flex-column align-items-center justify-content-center h-100">
                <div class="TWE m-3">
                    <div class="Iam">
                        <p>TOGETHER</p>
                        <b>
                            <div class="innerIam">
                                WE LEARN.<br />
                                WE GROW.<br />
                                WE EVOLVE.<br />
                            </div>
                        </b>
                    </div>
                </div>

                <form id="signup_form" action="signup.php" method="post" class="m-4">
                    <div class="form-group input-group-sm m-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="emer" id="emer" class="form-control input-style">
                        <p id="error_name"></p>
                    </div>

                    <div class="form-group input-group-sm m-2">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" name="mbiemer" id="mbiemer" class="form-control input-style">
                        <p id="error_surname"></p>
                    </div>
                    <div class="form-group input-group-sm m-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control input-style ">
                        <p id="error_email"></p>
                    </div>
                    <div class="form-group input-group-sm m-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="fjalekalimi" id="fjalekalimi" class="form-control input-style">
                        <p id="error_password"></p>
                    </div>


                    <div class="form-group input-group-sm m-2">
                        <label for="roli" class="form-label">Role</label>
                        <select name="roli" id="roli" class="form-control input-style">
                            <option selected>Select</option>
                            <option value="Student">Student</option>
                            <option value="Profesor">Professor</option>
                        </select>
                        <p id="error_roli"></p>
                    </div>


                    <div class="text-center error">
                        <span id="php_error" class="warning mx-auto">
                            <?php
                            if (isset($result) && $result != "")
                            {
                                echo '<i class="fas fa-exclamation-triangle"></i>' . " " . $result;
                            }

                            ?>
                        </span>
                    </div>

                    <div class="text-center">
                        <input type="submit" id="signup_button" class=" signup_button btn text-align-center w-50 m-2" value="Sign up"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>