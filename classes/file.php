<?php
class File
{
    public function generate_filename($length)
    {   //per te mos patur 2 file me te njejtin emer
        $array = array_merge(range('A', 'Z'), range('a', 'z'), range(0,9));
        $text="";
        for($i=0;$i<$length;$i++){
            $random=rand(0,61);
            $text.=$array[$random];
        }
        return $text;
    }
    public function resize_image($original_file_name,$resized_file_name,$max_width,$max_height,$type){
        if(file_exists($original_file_name)){
            if ($type==2)
            {
                $original_image = imagecreatefromjpeg($original_file_name);
            }
            else if ($type==3)
            {
                $original_image = imagecreatefrompng($original_file_name);

            }
            else if ($type==1){
                $original_image = imagecreatefromgif($original_file_name);
            }

            $original_width=imagesx($original_image);
            $original_height=imagesy($original_image);
            if($original_height>$original_width)
            {
                //width==max width
                $ratio=$max_width / $original_width;
                $new_width=$max_width;
                $new_height=$original_height*$ratio;
            }else
            {
                //heiht==maxheight
                $ratio = $max_height / $original_height;
                $new_height = $max_height;
                $new_width = $original_height * $ratio;
                
            }
        }
        //nese height dhe width nuk jane te barabarta
        if($max_width!=$max_height){
            if($max_height>$max_width){
                if($max_height>$new_height){
                    $adjstment=($max_height/$new_height);
                }else
                {
                    $adjstment=($new_height/$max_height);
                }
                $new_width=$new_width*$adjstment;
                $new_height=$new_height*$adjstment;
            }else
            {
                if($max_width>$new_width){
                    $adjstment=($max_width/$new_width);
                }else
                {
                    $adjstment=($new_width/$max_width);
                }
                $max_width=$new_width*$adjstment;
                $max_height=$new_height*$adjstment;
            }
        }
        $new_image=imagecreatetruecolor($new_width,$new_height);
        imagecopyresampled($new_image,$original_image,0,0,0,0,$new_width,$new_height,$original_width,$original_height);
        imagedestroy($original_image);
        imagejpeg($new_image,$resized_file_name,90);
        imagedestroy($new_image);
    }
}
?>