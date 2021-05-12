<!-- Blog Post -->
<div class="card shadow mb-4 text-start" id="postim">
  <span style=" text-align:right; ">
    <?php
    $post = new Post();
    $id = "myModal" . $ROW['post_id'];
    $id_like = "myModal2" . $ROW['post_id'];
    if ($post->iown_post($ROW['post_id'], $_SESSION['blog_user_id']))
    {

      echo " <a id='delete-post' class='remove-decoration' href='' data-toggle='modal' data-target='#$id'> Delete</a>";
    }
    ?>
  </span>

  <div class="modal fade" <?php
                          echo "id='$id'" ?>>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Delete Post </h4>
        </div>
        <div class="modal-body" id="modal-b">
          Are you sure that you want to delete this post?
        </div>
        <div class="modal-footer">
          <?php
          $ruaj_id_postim = $ROW['post_id'];
          if ($post->iown_post($ruaj_id_postim, $_SESSION['blog_user_id']))
          {
            echo " <a id='remove-now' class=' btn btn-default remove-decoration' href='delete.php?post_id=$ruaj_id_postim'>Delete now</a>";
          }
          ?>
          <input class="btn btn-default" data-dismiss="modal" value="Close">


        </div>
      </div>
    </div>
  </div>




  <div id="card_head" class="row" class="post-info" style="text-decoration:none;">
    <div id="avatar">
      <img id="profile_image" src=<?php
                                  if (file_exists($ROW_USER['image']))
                                  {
                                    echo htmlspecialchars($ROW_USER['image']);
                                  }
                                  else
                                  {
                                    echo "assets\img\default_user_picture.jpg";
                                  } ?> alt="avatar">
    </div>
    <div class="tedhena mx-2">

      <?php $check = $post->iown_post($ROW['post_id'], $_SESSION['blog_user_id']); ?>
      <ul>
        <li> <a class="remove-decoration" href=<?php
                                                if (!$check)
                                                {

                                                  echo htmlspecialchars("profile_page.php?id=" . $ROW['user_id']);
                                                }
                                                else
                                                {
                                                  echo htmlspecialchars("profile_page.php");
                                                } ?>><b><?php echo htmlspecialchars($ROW_USER['emer']) . " " . htmlspecialchars($ROW_USER['mbiemer']); ?> </b></a></li>
        <li>
          <i><small><?php


                    $timestamp = strtotime($ROW['data']);
                    echo date('l h:i:s a d/m/Y', $timestamp);
                    ?>
            </small> </i>


        </li>
      </ul>

    </div>

  </div>

  <p class="postim_tekst fit-content mx-5" style="padding-left:inherit;">
    <?php echo htmlspecialchars($ROW['post']); //escaping qe te mos ekzekutohen scripts ne html 
    //shton special characters dhe i thone browsers 'dont run this' 
    ?>
  </p>


  <div id="attachment " class="mx-5 my-2">
    <?php
    if (file_exists($ROW['image']))
    {
      $file = $ROW['image'];
      if (strpos($file, 'png') !== false || strpos($file, 'jpg') !== false || strpos($file, 'gif') !== false)
      {
        echo "<img class='img-responsive rounded mx-auto d-block'  src='$file'";
        echo " style= 'display:block;'>";
      }
      else if (strpos($file, 'rar') !== false)
      {
        echo "<a href=$file> <img class='ikona_file' src='assets/img/rarfile.jfif' > FILE</a>";
      }
      else if (strpos($file, 'pdf') !== false)
      {
        echo "<a href=$file> <img class='ikona_file' src='assets/img/pdf.png' > PDF</a>";
      }
      else if (strpos($file, 'mp4') !== false)
      {
        echo "<video width='80%' height='60%' controls playonclick style=' margin-left: auto;
      margin-right: auto;
      display: block;'>
              <source src='$file' type='video/mp4'> 
              </video>";
      }
    }
    ?>
  </div>

  <?php
  $likes = ($ROW['likes'] > 0) ? $ROW['likes'] : "0";

  $comments = ($ROW['komente'] > 0) ? $ROW['komente'] : "";
  ?>
  <div class="interacting " style="text-align:left; margin-left: 10%; display: block;">
    <a onclick="like_post(event)" id="<?php echo $ROW['post_id'] ?>" class="remove-decoration <?php $post = new Post();
      $liked = $post->get_likes($ROW['post_id'], 'post'); //kthen array of arrays
      if ($liked)
      {

        $liked_userids = array_column($liked, 'user_id'); //krijon nje array te re me elemente vetem te kolones se zgjedhur
        if (in_array($_SESSION['blog_user_id'], $liked_userids))
        {
          echo "orange";
        }
      }
      else echo "";
      
      
      ?> " href="like.php?type=post&id=<?php echo $ROW['post_id'] ?>">
      <?php $post = new Post();
      $liked = $post->get_likes($ROW['post_id'], 'post'); //kthen array of arrays
      $id_ikona = "ikon" . $ROW['post_id'];
      if ($liked)
      {

        $liked_userids = array_column($liked, 'user_id'); //krijon nje array te re me elemente vetem te kolones se zgjedhur
        if (in_array($_SESSION['blog_user_id'], $liked_userids))
        {
          echo "Unlike";
        }else{
          echo "Like";
        }

      }
      else echo "Like";
      ?>

    </a>
    <a id="like<?php echo $ROW['post_id'] ?>" class="remove-decoration" href="" data-toggle="modal" data-target=<?php echo "#" . $id_like ?>>
      <?php echo $ROW['likes']; ?>
    </a>


    <!--Kjo modal shfaqet kur klikohet te connections dhe shfaq te gjithe connections-->
    <div class="modal fade" <?php echo "id='$id_like'" ?>>

      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4>Likes</h4>
          </div>
          <div class="modal-body" id="modal-b">
            <ul class="list-group">
              <?php

              $post = new Post();
              if (isset($_GET['id']) && isset($_GET['type']))
              {
                $liked = $post->get_likes($_GET['id'], $_GET['type']);
              }

              ?>

              <?php
              $user = new User();
              if (is_array($liked))
              {
                foreach ($liked as $row)
                {
                  
                  $users = $user->get_user($row['user_id']);
                  $emer = $users['emer'];
                  $mbiemer = $users['mbiemer'];
                  echo "<li class='list-group-item'> <a class='remove-decoration' href=";
                  if (!$check)
                  {

                    echo htmlspecialchars('profile_page.php?id=' . $users['user_id']);
                  }
                  else
                  {
                    echo htmlspecialchars("profile_page.php");
                  }

                  echo "><b>";
                  echo htmlspecialchars($emer);

                  echo " ";
                  echo htmlspecialchars($mbiemer);
                  echo "</b></a></li>";
                }
              }
              else
              {
                echo "No likes to show!";
              }

              ?>
            </ul>

          </div>
          <div class="modal-footer">
            <input class="btn btn-default" data-dismiss="modal" value="Close">
          </div>
        </div>
      </div>
    </div>

    <a class="remove-decoration" href="single_post.php?id=<?php echo $ROW['post_id'] ?>"> Comments

      <?php echo $ROW['komente'] ?> </a>

  </div>

</div>
<script>
  function ajax_send(data) {
    var post_id = data.id;
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('readystatechange', function() {
      if (ajax.readyState == 4 && ajax.status == 200) {
        response(ajax.responseText, post_id);
      }
    });

    data = JSON.stringify(data);
    ajax.open("post", "ajax.php", true); //data dergohet ne menyre asinkronike, nuk ngrin nderfaqen
    ajax.send(data);
  }

  function response(result, id) {
    results = JSON.parse(result)
    document.getElementById("like" + id).innerHTML = results[0];
    if (results[1] == true) {
      document.getElementById(id).classList.add("orange");
      document.getElementById(id).innerHTML = "Unlike";
    } else {
      document.getElementById(id).classList.remove("orange");
      document.getElementById(id).innerHTML = "Like";
    }

  }

  function like_post(e) {
    e.preventDefault();
    var link = e.target.getAttribute('href');
    var id = e.target.id;
    var data = {};
    data.link = link;
    data.action = "like_post";
    data.id = id;
    ajax_send(data);
  }
</script>