<?php
include("classes/autoloader.php");
 

$login = new Login();
$login->check_login($_SESSION['blog_user_id']);

$user = new User();
$user_data = $user->get_user($_SESSION['blog_user_id']);

if (isset($_GET['id']) && is_numeric($_GET['id'])){
  $profile_data = $user->get_user($_GET['id']);
  if (is_array($profile_data)){
    $user_data = $profile_data;
  }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<meta http-equiv="refresh" content="60">-->
        <title>FTI blog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="assets/css/profile.css" rel="stylesheet">
        <link href="assets/css/postime_profil.css" rel="stylesheet">
        <link href="assets/fontawesome/css/all.css" rel="stylesheet">
        <script defer src="assets/fontawesome/js/all.js"></script> 
        <script defer src="assets/js/profile.js"></script>

        
        
    </head>
    <body id="profilePage" class="py-0">
    <?php include("navbar.php")?>
        <div id="container" class="container-fluid m-0 h-100">
        
            <div class="row h-50" >
               <div class="h-50 p-0" id="cover">
                <div class="h-50">
                <div class="h-75">
                  
                </div>
                </div>
                
            
           
                  <div class="image_area mx-auto d-block h-100 d-flex align-items-center">
                    <form id="profile_picture_form" action="upload_profile_picture.php" method="POST" enctype="multipart/form-data" class="mx-auto d-block fit-content-width">
                      <input id="upload_button" type="file" name="file" hidden>
                      <label for="upload_button">
                        <div class="circular mx-auto d-block image overlay">
                              <img src=<?php if(!empty($user_data['image']))
                                                    echo $user_data['image'];            
                                                else echo "assets\img\default_user_picture.jpg"; ?>
                              id="uploaded_image" class="img-fluid">
                            <div class="overlay" id="overlay">
                              <div class="text">Edit picture <i class="fas fa-camera"></i></div>
                            </div>
                        </div>
                      </label> 
                      <?php 
                      //Pengon ndryshimin e fotos kur eshte hapur profili i nje useri tjeter
                          if(isset($_GET['id'])&&$_GET['id']!=$_SESSION['blog_user_id']){
                            echo '
                            <script>
                              const upload_file=document.getElementById("upload_button");
                              upload_file.disabled="true";
                              const overlay=document.getElementById("overlay");
                              overlay.style.display="none";
                            </script>
                            ';
                          }
                      ?>                   
                      <input type="submit" name="submit" value="save changes" id="save_changes" hidden>
                    </form>
                  </div>

                  <div id="user_name" class="d-flex justify-content-center">
                    <h3 class="pt-1"><?php echo $user_data['emer']." ".$user_data['mbiemer']?></h3>
                  
                    <?php
                    if(isset($_GET['id'])&&$_GET['id']!=$_SESSION['blog_user_id']){ 
                       $_SESSION['get_param']=$_GET['id'];
                    ?>
                   
                   <!--Ketu filloi fshirja-->
                  
                   <button id="relationship_button" class="btn connect-btn text-center"></button>
                   <?php }
                     ?>
                  <!--Ketu mbaroi fshirja-->
                  </div>

          
                  <a href="">
                  <div class="d-flex flex-row justify-content-center mx-2 fllw">
                    <div class="mx-2 p-2 d-flex flex-column justify-content-center align-items-center">
                      <h6><?php echo $user_data['post_count']; ?></h6>
                      <h7>Posts</h7>
                    </div>
                  </a>


                  <a href="" data-toggle="modal" data-target="#myModal">
                      <div class="mx-2 p-2 d-flex flex-column justify-content-center align-items-center">
                        <h6><?php echo $user_data['connections_count']; ?></h6>
                        <h7 id="connections_count">Connections</h7>
                      </div>
                  </a>
                
                  
                    <!--Kjo modal shfaqet kur klikohet te connections dhe shfaq te gjithe connections-->
                    <div class="modal fade" id="myModal">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header"> 
                            <h4>Connections</h4>
                          </div>
                          <div class="modal-body">
                          
                          <?php
                          if(isset($_GET['id'])){
                            $friends=Relationship::friends_list($_GET['id']);
                            if(!empty($friends)){
                              foreach($friends as $friend_info){
                                echo '<a href="'.htmlspecialchars("profile_page.php?id=" . $friend_info['user_id']).'">';
                                echo $friend_info['emer']." ".$friend_info['mbiemer'];
                                echo '</a>';
                                echo '</br>';
                              }
                            }else{
                              echo "No friends to show!";
                            }
                            
                          }else{
                            $friends=Relationship::friends_list($_SESSION['blog_user_id']);
                            if(!empty($friends)){
                              foreach($friends as $friend_info){
                                echo '<a href="'.htmlspecialchars("profile_page.php?id=" . $friend_info['user_id']).'">';
                                echo $friend_info['emer']." ".$friend_info['mbiemer'];
                                echo '</a>';
                                echo '<hr>';
                              }
                            }else{
                              echo "No friends to show!";
                            }
                          }
                          ?>
                        
                          
                          </div>
                          <div class="modal-footer">
                            <input class="btn btn-default"  data-dismiss="modal" value="Close">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div> 
            </div>
            <div class="row w-100 m-0 pt-5">
 
                <div class="col d-flex flex-row justify-content-center p-0 w-100">
                  <div class="card text-center card-size">
                    <div class="card-header ">
                      <ul class="nav nav-tabs card-header-tabs d-flex flex-row justify-content-center w-100">
                        <li class="nav-item d-flex flex-row justify-content-center w-50">
                          <a class="nav-link remove-decorations" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false" href="#">About</a>
                        </li>
                        <li class="nav-item d-flex flex-row justify-content-center w-50">
                          <a class="nav-link remove-decorations" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false" href="#">Posts</a>
                        </li>
                      </ul>
                    </div>

                    <div class="card-body" id="card_body">
                    <div class="tab-content" id="myTabContent">
                        <!--Tabi i about-->
                        <div class="tab-pane fade mx-4 text-start" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <div class="d-flex justify-content-end mx-4">
                          <a class="remove-decorations" href="edit_page.php" id="edit_button"><i class="fas fa-edit"></i></a>
                          <?php
                            if(isset($_GET['id'])&&$_GET['id']!=$_SESSION['blog_user_id']){
                              echo "<script>document.getElementById('edit_button').style.display='none'</script>";
                            }
                          ?>
                        </div>
                        <?php
                          if($user_data['role']=='Student'){
                        ?>
                        <div class="info m-3 d-flex justify-content-start info_divs p-3">
                          <div class="w-50"><i class="fas fa-university"></i> Study Field</div>
                          <div class="w-50"><?php if(!empty($user_data['dega'])) echo $user_data['dega']; else echo '-';?></div>
                        </div>
                        
                        <div  class="info m-3 d-flex  justify-content-start info_divs p-3">
                          <div class="w-50"><i class="fas fa-user-graduate"></i> Currently in</div>
                          <div> <?php if(!empty($user_data['cikli_studimit'])) echo $user_data['cikli_studimit']; else echo '-';?></div>
                        </div>
                        
                        <div class="info m-3 d-flex  justify-content-start info_divs p-3">
                          <div class="w-50"><i class="fas fa-users"></i> Group</div>
                          <div > <?php if(!empty($user_data['klasa'])) echo $user_data['klasa']; else echo '-';?></div>
                        </div>
                        
                        <div class="info m-3 d-flex  justify-content-start info_divs p-3">
                          <div class="w-50"><i class="far fa-calendar-alt"></i> Joined in</div>
                          <div > <?php echo date('d F Y', strtotime($user_data['data']))?></div>
                         
                        </div>
                        <?php }else{
                          $courses_array=explode(",",$user_data['courses']);
                        
                          ?>
                        <div class="info m-3 d-flex  justify-content-start info_divs p-3">
                          <div class="w-50"><i class="fas fa-book"></i> Courses</div>
                          <div> 
                            <?php 
                            $itr=1;
                            foreach($courses_array as $course){
                                  echo $itr.'. '.$course."<br>";
                                  $itr++;
                                }
                            ?>
                          </div>
                        </div>
                        <?php }?>




                        <div class="info m-3 d-flex  justify-content-start info_divs p-3">
                          <div class="w-50"><i class="fas fa-file-alt"></i> Curriculum Vitae</div>
                          <div> 
                          <a id="cv_tag" class=" w-50 remove-decorations" href="<?php echo $user_data['CV']?>"> CV<i class="fas fa-download"></i></a>
                          </div>
                          <script>
                          const cv_tag=document.getElementById("cv_tag");
                          
                          if(cv_tag.href==="http://localhost/Blog/profile_page.php"){
                            console.log(cv_tag.href);
                            cv_tag.innerHTML="-";
                            
                          }
                          </script>
                          
                        </div>
                       

                        </div>
                        <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                        <div class="col-9 mx-auto"  >

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
                $posts = $post->get_posts($id, $limit, $offset);

                //collect post per profil tjeter
                if (isset($_GET['id']) && is_numeric($_GET['id']))
                { //white listening,limit, select values to insert
                  $post = new Post();
                  $posts = $post->get_posts($_GET['id'], $limit, $offset);
                }

                if ($posts) //nese ekzistojne postime me kete ID,
                {
                  foreach ($posts as $ROW)
                  {
                    $user = new User();
                    $ROW_USER = $user->get_user($ROW['user_id']); //mund te jete postimi i dikujt tjeter, per te tanet vetem id mjdfton
                    include("postim.php");
                    //echo "<hr>";
                  }
                }
                else
                {
                  echo '<img id="no_posts_img" src="assets/img/no_posts.svg" alt="no posts">';
                  echo '<h5 id="no_posts">There are no posts to show</h5>';
                }
                ?>

              </div class="pagg mx-auto">
              <a class="paggination" style="text-decoration:none; color: <?php if(!isset($_GET['page']) or (!empty($_GET['page'])&&$_GET['page'] == 1)){
                        echo "gray";
                    } ?> "
                    
              
              href="<?php if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']>1)
                    {
                      echo $previous_page_link;
                    }
                    else if (!empty($_GET['page'])&&$_GET['page'] == 1)
                    {
                      echo "javascript:void(0)";
                    }
                    else
                    {
                      echo
                      'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?page=1';
                    }
                        ?>">
                Previous
              </a>
              <a class="paggination" style="text-decoration:none; color: <?php if(!$posts){
                        echo "gray";
                    } ?> "
                    
                    href="<?php if (isset($_GET['page']) && is_numeric($_GET['page']) && $posts)
                    {
                      echo $next_page_link;
                    }
                    else if(!$posts){
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
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
                           
                           
                          
        
        <!--Ben qe forma mos te behet resubmit kur i ben refresh faqes-->
        <script>
            if ( window.history.replaceState ){
              window.history.replaceState( null, null, window.location.href );
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>

