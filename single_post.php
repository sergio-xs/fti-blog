<?php
//unset($_SESSION['blog_user_id']);
include("classes/autoloader.php");

//isset($_SESSION['blog_user_id']);
$login = new Login();
$user_data = $login->check_login($_SESSION['blog_user_id']);


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $post = new Post();
    $id = $_SESSION['blog_user_id'];
    $result = $post->create_post($id, $_POST, $_FILES);
}
$post = new Post();
$my_post = false;
$Error = "";
if (isset($_GET['id']))
{
    $ROW = $post->get_one_post($_GET['id']);
}
else
{
    $Error = "No post found";
}

?>
<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="assets/fontawesome/css/all.css" rel="stylesheet">
<script defer src="assets/fontawesome/js/all.js"></script>


<!-- ===== BOX ICONS ===== -->
<link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

<!-- ===== CSS ===== -->
<link rel="stylesheet" href="assets/css/kryefaqja.css">
<link rel="stylesheet" href="assets/css/komente.css">

<title>Komente</title>
<script>
    if (window.history.replaceState) { //nek lejon resubmit te formes kur i ben refresh faqes
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</head>

<body id="komentt">

    <?php include("navbar.php"); ?>

    <div class="container" style="margin-top:5%;">

        <div class="col-9 mx-auto" id="mobile_post">
            <div id="komente" style="display: block;">
                <?php

                if (is_array($ROW))
                {
                    $user = new User();
                    $ROW_USER = $user->get_user($ROW['user_id']);
                    include("postim.php");

                    $comments = $post->get_comments($ROW['post_id']);
                    if (is_array($comments))
                    {
                        foreach ($comments as $comment_row)
                        {
                            $ROW_USER = $user->get_user($comment_row['user_id']);

                            include("comment.php");
                        }
                    }
                }
                ?>

                <form method="post" enctype="multipart/form-data" class="p-3">
                    <textarea name="post" style="overflow:auto;"cols="50" class="posto m-4" placeholder="Comment something"></textarea>
                    <input type="hidden" name="parent" value="<?php echo $ROW['post_id'] ?>">
                    <button type="submit" id="shpernda" class="btn buttons" >
                    
                        <b style="color: #4d4d4d;">Comment</b>
                    </button>

                </form>
            </div>
        </div>
    </div>

</body>

</html>