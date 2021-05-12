<?php

class TestFunksione extends \PHPUnit\Framework\TestCase
{
    public function testPositiveTestcaseForassertIsString()
    {
        $func = new \App\Models\Funksione;
        $actualArray = $func->gjenero_Url("profil.php", 2, "page");
        $this->assertSame(["profil.php?page=3", "profil.php?page=1"],
            $actualArray,
            "actual value is a string or not"
        );
    }  
    public function testRandId()
    {
        $func = new \App\Models\Funksione;
        $num = $func->create_postid();
        $this->assertTrue(is_numeric($num), "Vlera e kerkuar nuk eshte numer.");
    }
    public function testRandId2()
    {
        $func = new \App\Models\Funksione;
        $num = $func->create_postid();
        $this->assertGreaterThan(0, strlen($num), "ID nuk eshte krijuar sic duhet.");
    }

    
}
