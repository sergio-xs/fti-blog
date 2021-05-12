<?php
//unset($_SESSION['blog_user_id']);
include("classes/autoloader.php");
//print_r($_SESSION);
//isset($_SESSION['blog_user_id']);
$login = new Login();
$user_data = $login->check_login($_SESSION['blog_user_id']);

//posto
if ($_SERVER['REQUEST_METHOD'] == "POST")
{

  $post = new Post();
  $id = $_SESSION['blog_user_id'];
  $result = $post->create_post($id, $_POST, $_FILES);

  if ($result == "")
  {
    header("Location: feed.php");
    die;
  }
  else
  {
    echo $result;
  }
}

//collect friends
$user = new User();
$id = $_SESSION['blog_user_id'];
$friends = $user->get_friends($id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <link href="assets/fontawesome/css/all.css" rel="stylesheet">
  <script defer src="assets/fontawesome/js/all.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700" type="text/css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto&display=swap" rel="stylesheet">


  <!-- ===== BOX ICONS ===== -->
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

  <!-- ===== CSS ===== -->
  <link rel="stylesheet" href="assets/css/kryefaqja.css">
  <link rel="stylesheet" href="assets/css/paggination.css">


  <title>FTI BLOG</title>
  <script>
    if (window.history.replaceState) { //nek lejon resubmit te formes kur i ben refresh faqes
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</head>

<body id="feed">

  <?php include("navbar.php"); ?>


  <div class="container">

    <div class="row">
      <div class="col-md-8 mx-auto " style="max-width: 80%;">
        <div id="posto-container" class="card shadow my-4">
          <div class="container" style="padding: 10px;">
            <p id="quote">DON'T BE AFRAID TO SHARE AN IDEA</p>
            <form method="post" enctype="multipart/form-data">
              <div class="col-md-8 mx-auto">
                <textarea class="form-control my-2" name="post" style="overflow:auto;" rows="4" cols="100" class="posto" placeholder="What's on your mind?"></textarea>

                <div class="custom-file">

                  <input name="file" type="file" class="custom-file-input" id="upload_img " accept="video/mp4, application/pdf, .zip,.rar,.7zip, image/png, image/jpeg,image/gif">
                  <label class="custom-file-label " for="upload_img"> <i class="fas fa-paperclip"></i> Add an attachment</label>
                  <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>
                <!-- <input name="file" type="file" id="upload_img" accept="video/mp4, application/pdf, .zip,.rar,.7zip, image/png, image/jpeg,image/gif" class="post-btn" style="color:white; margin-top: 5px; font-style: oblique;">-->
              </div>
              <hr>
              <div class="col-md-8 mx-auto "> <button class="post-btn" type="reset" style="padding: vw;" style=" font-style: oblique; color: #4d4d4d;">

                  <i class='bx bx-trash' style="color:#4d4d4d; font-size: 15px; "></i>
                  <b style="color: #4d4d4d;">Delete</b>
                </button>
                <button type="submit" id="shpernda" class="post-btn" style=" float: right; font-style: oblique; color: #4d4d4d;">
                  <i class='bx bx-send' style="color:#4d4d4d; font-size: 15px; "></i>
                  <b style="color: #4d4d4d;">Post</b>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
      <span style=" background-color: #F3F5F6; padding: 0 2vw;">
        Stay Updated
      </span>
    </div>
    <!-- Blog Entries Column -->
    <br>
    <div class="row">

      <div class="col-9 mx-auto" id="mobile_post">

        <?php

        $page_number = 1;
        if (isset($_GET['page']))
        {
          $page_number = (int)$_GET['page'];
          if ($page_number < 1)
          {
            $page_number = 1; //qe mos te behet zero se nuk ekziston
          }
        }

        $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']; // merr url pa localhost sepse del dy here
        $url .= "?";
        $next_page_link = $url;
        $previous_page_link = $url;
        $num = 0;
        foreach ($_GET as $key => $value)
        {
          $num++;

          if ($num == 1)
          {
            if ($key == "page")
            {
              $next_page_link .= $key . "=" . ($page_number + 1);
              $previous_page_link .= $key . "=" . ($page_number - 1);
            }
            else
            {
              $url .= $key . "=" . $value;
            }
          }
          else
          {
            if ($key == "page")
            {
              $next_page_link .= $key . "=" . ($page_number + 1);
              $previous_page_link .= $key . "=" . ($page_number - 1);
            }
            else
            {
              $url .= "&" . $key . "=" . $value;
            }
          }
        }


        $limit = 5; //pagination
        $offset = ($page_number - 1) * $limit;

        //collect posts
        $post = new Post();
        $id = $_SESSION['blog_user_id'];
        $posts = $post->get_timeline_post($id, $friends, $limit, $offset);

        if ($posts) //nese ekzistojne postime me kete ID,
        {
          foreach ($posts as $ROW)
          {

            $user = new User();
            $ROW_USER = $user->get_user($ROW['user_id']); //mund te jete postimi i dikujt tjeter, per te tanet vetem id mjdfton
            include("postim.php");
          }
        }
        else
        {
          echo '<div class="card shadow mb-4 text-center" id="postim">';
          echo '<img id="no_posts_img" height="300vh" src="assets/img/no_posts.svg" alt="no posts">';
          echo '<h5 id="no_posts">There are no posts to show</h5>';
          echo '</div>';
        }
        ?>
      </div>

    </div>
    <div class="pagg mx-auto">
      <a class="paggination" style="text-decoration:none; color: <?php if (!isset($_GET['page']) or (!empty($_GET['page']) && $_GET['page'] == 1))
                                                                  {
                                                                    echo "gray";
                                                                  } ?> " href="<?php if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1)
                                                                                {
                                                                                  echo $previous_page_link;
                                                                                }
                                                                                else if (!empty($_GET['page']) && $_GET['page'] == 1)
                                                                                {
                                                                                  echo "javascript:void(0)";
                                                                                }
                                                                                else
                                                                                {
                                                                                  echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=1';
                                                                                }
                                                                                ?>">
        Previous
      </a>
      <a class="paggination" style="text-decoration:none; color: <?php if (!$posts)
                                                                  {
                                                                    echo "gray";
                                                                  } ?> " href="<?php if (isset($_GET['page']) && is_numeric($_GET['page']) && $posts)
                                                                                {
                                                                                  echo $next_page_link;
                                                                                }
                                                                                else if (!$posts)
                                                                                {
                                                                                  echo "javascript:void(0)";
                                                                                }
                                                                                else
                                                                                {
                                                                                  echo
                                                                                  'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=2';
                                                                                }

                                                                                ?>">
        Next
      </a>
    </div>

  </div>
  <!-- /.container -->
</body>

</html>