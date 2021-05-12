<?php
namespace App\Models;
class Funksione{

    public function create_postid()
    {
        $length = rand(4, 10);
        $number = "";
        for ($i = 0; $i < $length; $i++)
        {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }
    
    public function gjenero_Url($url,$page_number,$key){
        $next_page_link = $url;
        $previous_page_link = $url;

                if ($key == "page")
                {
                    $next_page_link .="?". $key . "=" . ($page_number + 1);
                    $previous_page_link .="?". $key . "=" . ($page_number - 1);
                }
             
             
                $array=array($next_page_link, $previous_page_link);
        return $array;
        }

}
