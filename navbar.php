<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top_nav" >
                <a href="feed.php"><img src="assets/img/logo2.png" class="navbar-brand p-0 mx-4" width="100px"></a>
                
                <button class="navbar-toggler mx-4" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
               
                  <div class="navbar-collapse collapse justify-content-start" id="navbarMenu">
                      
                    <div class="bg-dark ">
                            <form action="search.php" class="" method="get">
                                <input class="kerko m-2" type="text" name="search" placeholder="Kerko..">
                            </form>
                    </div>
                   
                     <ul class="navbar-nav navbar-dark bg-dark">
                      <li class="nav-item">
                        <a href="profile_page.php" class="nav-link nav-col">My profile</a>
                      </li>

                      <li class="nav-item ">
                        <a href="feed.php" class="nav-link nav-col">Feed</a>
                      </li>

                      <li class="nav-item  ">
                        <?php
                           $pending_requests=Relationship::get_pending_requests($_SESSION['blog_user_id']);
                           if(!empty($pending_requests)){
                             echo '<a href="notifications.php" class="nav-link nav-col d-flex flex-row"> <div class="circle mx-1"></div> <div>Requests</div></a>';
                           }else{
                             echo '<a href="notifications.php" class="nav-link nav-col ">Requests</a>';
                           }
                        ?>
                      
                          
                      </li>

                      <li class="nav-item text-center">
                        <li class="nav-item dropdown">
                          <a href="#" class="nav-link nav-col dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
                          <div class="dropdown-menu " id="settings" style="margin-left: 10%;"  aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="edit_page.php">Edit profile</a>
                            <a class="dropdown-item" href="account_settings.php">Account</a>
                            <a class="dropdown-item" href="logout.php">Log out <i class="fas fa-sign-out-alt"></i></a>
                          </div>
                        </li>
                      </li>
                     </ul>
                  </div>
                </nav>