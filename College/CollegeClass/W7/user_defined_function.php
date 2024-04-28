<?php 
    // Membuat dan Memanggil Function
    function salam() {
        echo "<p>Selamat Pagi</p>";
    }
    salam();
    salam();
    salam();

    // Argumen Function
    function salam2($nama){
        echo "<p>Selamat Pagi, $nama<p>";
    }
    salam2("Gerrard");    
    salam2("Sebastian");    
    salam2("Indonesia");
    salam2("World..."); 

    // Multiple Argumen
    function salam3($waktu, $nama){
    echo "<p>Selamat $waktu, $nama </p>";
    }
    salam3("Malam","Gerrard");       
    salam3("Siang","Sebastian");       
    salam3("Pagi","Indonesia...");

    // Pemanggilan Argumen
    function salam4($waktu,$nama){
        echo "<p>Selamat $waktu, $nama!</p>";
      }
    $event = "Belajar PHP";
    $user = "Gerrard";
    salam4($event, $user);

    // Return Value
    function tambah($satu,$dua){
        $hasil = $satu + $dua;
        return $hasil;
    }
    $a = tambah(6,10);
    echo $a;

    // Default Argumen
    function salam5($waktu="Malam", $nama="Sebastian"){
        echo "<p>Selamat $waktu, $nama </p>";
    }
    salam5();                         
    salam5("Pagi");                   
    salam5("Siang", "Mr. President!");

    // Anonymous Function
    $salam = function () {
        return "Selamat Siang";
    };
    echo $salam();

    echo "<br/><br/>";

    // Arrow Function
    $salam = fn () => "Selamat Siang";
    echo $salam();
