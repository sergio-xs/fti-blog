<?php
include("classes/autoloader.php");
$login = new Login();
$login->check_login($_SESSION['blog_user_id']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FTI blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="assets/css/requests.css" rel="stylesheet">
    <link href="assets/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="assets/fontawesome/js/all.js"></script>
    <script defer src="assets/js/change_password.js"></script>
</head>

<body id="requests">
    <?php include("navbar.php") ?>
    <div class="container">

        <div class="row h-100 d-flex justify-content-center align-items-center ">
            <div class="card p-0 m-5" id="card">
                <div class="card-header d-flex justify-content-center align-items-center" id="card_header">
                    <h4 id="header" class="card-title">Pending connection requests</h4>
                </div>
                <div class="card-body p-0 d-flex flex-row justify-content-center text-center">

                    <ul class="w-100 m-4">
                        <?php
                        $pending_requests = Relationship::get_pending_requests($_SESSION['blog_user_id']);
                        if (!empty($pending_requests))
                        {
                            // print_r($pending_requests);

                            foreach ($pending_requests as $pending_request)
                            {
                                $requester = new User();
                                $requester_info = $requester->get_user($pending_request);
                                $requester_full_name = $requester_info['emer'] . " " . $requester_info['mbiemer'];

                        ?>
                                <li>
                                    <div class="w-100 mx-auto">
                                        <?php echo $requester_full_name . " sent a connection request" ?>
                                        <a class='m-1 remove-decorations' href="handle_request.php?requester=<?php echo $requester_info['user_id'] ?>&action=accepted">
                                            <button id="accept" class="btn buttons">Accept</button>
                                        </a>

                                        <a class='m-1 remove-decorations' href="handle_request.php?requester=<?php echo $requester_info['user_id'] ?>&action=rejected ">
                                            <button id="reject" class='btn buttons'>Reject</button>
                                        </a>
                                    </div>


                                </li>
                                <hr>


                            <?php }
                        }
                        else
                        { ?>
                            <div id="no_requests" class="mx-auto">
                                <img class="mx-auto" src="assets/img/no_posts.svg" alt="no_requests">
                            </div>
                        <?php } ?>



                    </ul>

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