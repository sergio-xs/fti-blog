<?php
include("change_password.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FTI blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="assets/css/account_settings.css" rel="stylesheet">
    <link href="assets/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="assets/fontawesome/js/all.js"></script>
    <script defer src="assets/js/change_password.js"></script>
</head>

<body id="edit">
    <?php include("navbar.php") ?>
    <div class="container">
        <div class="row h-100 d-flex justify-content-center align-items-center ">
            <div class="card px-0 my-5" id="card">
                <div class="card-header d-flex justify-content-center align-items-center" id="card_header">
                    <h4 id="header" class="card-title">Account Settings</h4>
                </div>
                <div class="card-body d-flex flex-row justify-content-center">


                    <div class=" container justify-content-center w-75">
                        <div class="row">
                            <form method="post" action="#" class="my-auto" id="change_password_form" enctype="multipart/form-data">


                                <div class="form-group input-group-sm m-2">
                                    <label for="old_password" class="form-label">Old password</label>
                                    <input name="old_password" type="password" id="old_password" class="form-control ">
                                    <p id="error_old_password"></p>
                                </div>

                                <div class="form-group input-group-sm m-2">
                                    <label for="new_password" class="form-label">New password</i></label>
                                    <input name="new_password" type="password" id="new_password" class="form-control">
                                    <p id="error_new_password"></p>
                                </div>

                                <div class="form-group input-group-sm m-2">
                                    <label for="confirm_new_password" class="form-label">Confrim new password</i></label>
                                    <input name="confirm_new_password" type="password" id="confirm_new_password" class="form-control">
                                    <p id="error_confirm_new_password"></p>
                                </div>

                                <div id="php_error" class="error">
                                    <?php
                                    if (!empty($status_msg))
                                        echo $status_msg;
                                    ?>
                                </div>
                                <div class="text-center my-4 d-inline-flex w-100">
                                    <input onclick="window.location = 'profile_page.php';" type="button" id="cancel" name="cancel" class="btn edit-buttons text-align-center w-50 m-2" value="Cancel"></input>
                                    <input type="submit" id="save_changes" name="submit" class="btn edit-buttons text-align-center w-50 m-2" value="Save changes"></input>
                                </div>
                            </form>

                        </div>
                        <hr>
                        <div class=" row text-center">
                            <a id="delete_acc" onclick="return confirmAccDeletion()">Delete account</a>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>