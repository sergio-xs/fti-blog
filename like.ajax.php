
<?php
//unset($_SESSION['blog_user_id']);
//isset($_SESSION['blog_user_id']);
if(!isset($_SESSION['blog_user_id'])){
    die;
}
$query_string=explode("?",$data['link']);  //? delimeter 
$query_string=end($query_string); //merr pjesen pas ? te array qe eshte kthyer pas ndarjes me ?



$str=explode("&",$query_string);

foreach($str as $value){
    $value=explode("=",$value);
    $_GET[$value[0]]=$value[1];
}
$iliked= "";
$post = new Post();
if(isset($_GET['type'])&&isset($_GET['id'])){
        if(is_numeric($_GET['id'])){
            if($_GET['type']=="post"){
           
                $post->like_post($_GET['id'],$_GET['type'],$_SESSION['blog_user_id']);
                $post_data = $post->get_one_post($_GET['id']);
                $likes=$post_data['likes'];

                $liked = $post->get_likes($_GET['id'], 'post'); //kthen array of arrays
                if ($liked)
                 {

                  $liked_userids = array_column($liked, 'user_id'); //krijon nje array te re me elemente vetem te kolones se zgjedhur
                    if (in_array($_SESSION['blog_user_id'], $liked_userids))
                 {
                    $iliked=true;
                } else{
                    $iliked=false;
                }
            }
            }
        }
    }
    $responses=array();
    $responses[]=$likes;
    $responses[] = $iliked;
    echo json_encode($responses);  

