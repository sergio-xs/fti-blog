<?php

class Post
{
    private $error="";
    public function create_post($user_id, $data, $files)
    {
        if(!empty($data['post']) || !empty($files['file']['name']))
        {
            $myfile = "";
            if(!empty($files['file']['name']))
            {

                
                $mime = mime_content_type($_FILES['file']['tmp_name']);
                if (strstr($mime, "video/"))
                {
                    $folder = "uploads/videos/" . $user_id . "/";
                    //create folder
                    if (!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                    }
                    $image_class = new File();
                    $myfile = $folder . $image_class->generate_filename(15) . ".mp4";
                    move_uploaded_file($_FILES['file']['tmp_name'], $myfile);
                }
                else if (strstr($mime, "image/"))
                {
                    if (!empty($files['file']['name']))
                    {


                        $image_class = new File();
                        $folder = "uploads/images/" . $user_id . "/";
                        //create folder
                        if (!file_exists($folder))
                        {
                            mkdir($folder, 0777, true);
                        }
                        $image_class = new File();
                        $type   = exif_imagetype($_FILES['file']['tmp_name']);

                        if ($type == 2)
                        {
                            $myfile = $folder . $image_class->generate_filename(15) . ".jpg";
                            move_uploaded_file($_FILES['file']['tmp_name'], $myfile);
                            $image_class->resize_image($myfile, $myfile, 500, 500, $type);
                        }
                        else if ($type == 3)
                        {
                            $myfile = $folder . $image_class->generate_filename(15) . ".png";
                            move_uploaded_file($_FILES['file']['tmp_name'], $myfile);
                            $image_class->resize_image($myfile, $myfile, 500, 500, $type);
                        }
                        else if ($type == 1)
                        {
                            $myfile = $folder . $image_class->generate_filename(15) . ".gif";
                            move_uploaded_file($_FILES['file']['tmp_name'], $myfile);
                        }
                    }
                }
                else if (strstr($mime, "application/"))
                {
                    $folder = "uploads/doc/" . $user_id . "/";
                    //create folder
                    if (!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);
                    }
                    $file_class = new File();
                    if (strstr($mime, "application/pdf"))
                    {
                        $myfile = $folder . $file_class->generate_filename(15) . ".pdf";
                    }
                    else
                    {
                        $myfile = $folder . $file_class->generate_filename(15) . ".rar";
                    }
                    move_uploaded_file($_FILES['file']['tmp_name'], $myfile);
                }
            }


            $database = Database::getInstance();
            $post = addslashes($data['post']);
            $post_id=$this->create_postid();
            $parent=0;

          
            if(isset($data['parent'])&&is_numeric($data['parent'])){

                $parent=$data['parent'];
                $sql="update posts set komente=komente+1 where post_id='$parent 'limit 1 ";
                $database->save($sql);              
            }
            $query="INSERT INTO posts (user_id,post_id,post,image,parent) values ('$user_id','$post_id','$post','$myfile','$parent')";
            $database->save($query);

            if (!isset($data['parent']))
            {
                $sql = "update users set post_count=post_count+1 where user_id='$user_id' limit 1";
                $database->save($sql);
            }
            
        }else
        {
            return $this->error .="Ju lutem shkruani dicka!<br>";
        }
        return $this->error;
    }

    public function like_post($id,$type,$blog_user_id){
        $database = Database::getInstance();

        $sql = "SELECT likes from likes where type='post' && post_id='$id' limit 1";
        $result=$database->read($sql);
        
        if(is_array($result)){
            $likes=json_decode($result[0]['likes'],true); //array brenda array
            //check nese ka pelqyer

            $user_ids=array_column($likes,'user_id');
            if(!in_array($blog_user_id,$user_ids)){
                $arr["user_id"] = $blog_user_id;
                $arr["date"] = date("Y-m-d H:i:s");

                $likes[]=$arr;
                $likes_string = json_encode($likes); //konverton ne string, js object notation, per te ruajtur ne DB
                $sql = "update likes set likes='$likes_string' where post_id='$id' limit 1";
                $database->save($sql);
                //increment likes
                $sql = "update posts set likes=likes+1 where post_id='$id' limit 1";
                $database->save($sql);

            }else{ //hiq like
                $key=array_search($blog_user_id,$user_ids);
                unset($likes[$key]);
                $likes_string = json_encode($likes); //konverton ne string, js object notation, per te ruajtur ne DB
                $sql = "update likes set likes='$likes_string' where post_id='$id' limit 1";
                $database->save($sql);
                $sql = "update posts set likes=likes-1 where post_id='$id' limit 1";
                $database->save($sql);
            }
           
        }else{
                $arr["user_id"]=$blog_user_id;
                $arr["date"]=date("Y-m-d H:o:s");

                $arr2[]=$arr;
                $likes=json_encode($arr2); //konverton ne string, js object notation, per te ruajtur ne DB
                $sql="insert into likes (type,post_id,likes) values('$type','$id','$likes')";
                $database->save($sql);
                //increment likes
                $sql = "update posts set likes=likes+1  where  post_id='$id' limit 1";
                $database->save($sql);
        
        }

    }
    public function get_likes($id,$type){
        $database = Database::getInstance();
        if($type=="post"){
            //merr likes
            $sql = "SELECT likes from likes where type='post' && post_id='$id' limit 1";
            $result = $database->read($sql);

            if (is_array($result))
            {
                $likes = json_decode($result[0]['likes'], true); //array brenda array
                return $likes;
            }
        }
        return false;
    }
    public function get_posts($id,$limit,$offset){
        $query="SELECT * FROM posts where user_id='$id'  && parent='' order by id desc limit $limit offset $offset";
        $database=Database::getInstance();
        $result=$database->read($query);
        if($result)
        {
            return $result;
        }else{
            return false;
        }
    }


    public function get_timeline_post($id,$friends_id,$limit,$offset)
    {

        if($friends_id){
            $query = "SELECT * FROM posts where (user_id='$id' || user_id  IN ('" . implode("','", $friends_id) . "') ) && parent='' order by id desc limit $limit offset $offset";
        }else{
            $query = "SELECT * FROM posts where user_id='$id'  && parent='' order by id desc limit $limit offset $offset ";
        }
       

            $database = Database::getInstance();
            $result = $database->read($query);
            if ($result)
            {
                return $result;
            }
            else
            {
                return false;
            }
  
    }




    public function get_comments($id)
    {
        $query = "SELECT * FROM posts where parent='$id' order by id asc ";
        $database = Database::getInstance();
        $result = $database->read($query);
        if ($result)
        {
            return $result;
        }
        else
        {
            return false;
        }
    }
    public function get_one_post($post_id)
    {   if(!is_numeric($post_id)){
            return false;
         }
        $query = "SELECT * FROM posts where post_id='$post_id'  limit 1";
        
        $database = Database::getInstance();
        $result = $database->read($query);
        if ($result)
        {
            return $result[0];
        }
        else
        {
            return false;
        }
    }

    public function delete_post($post_id)
    {
        if (!is_numeric($post_id))
        {
            return false;
        }
        $postimi=$this->get_one_post($post_id);
        $query = "DELETE FROM posts where post_id='$post_id'  limit 1";
        $userid=$postimi['user_id'];
        $query2 = "update users set post_count=post_count-1 where user_id='$userid 'limit 1 ";
       
        $database = Database::getInstance();
        $database->save($query);
        $database->save($query2);
        
        
    }
    

    public function iown_post($post_id,$blog_user_id)
    {
        if (!is_numeric($post_id))
        {
            return false;
        }

        $query = "SELECT * FROM posts where post_id='$post_id'  limit 1";
       
        $database = Database::getInstance();
        $result=$database->read($query);
        if(is_array($result)){
            
                if($result[0]['user_id']==$blog_user_id){
                    
                    return true;
                }
        }
        return false;
    }


    private function create_postid()
    {
        $length=rand(4,9);
        $number="";
        for($i=0;$i<$length;$i++){
            $new_rand=rand(0,9);
            $number=$number . $new_rand;
        }
        return $number;
    }


}
