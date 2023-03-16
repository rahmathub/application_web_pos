<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menghitung volume bangun ruang</title>
</head>
<body>
    <?php 
    // Judul 
    echo 
    "<h2>
        <hr>
        3 Macam menghitung volume bangun ruang
        <hr>
    </h2>
    ";

    echo 
    "<h3>
        1. Rumus menghitung Luas Bangun ruang kubus      
    </h3>
    
    <p>gambar bawah adalah kubus dengan <i>panjang rusuk kubus (r) = 15 cm</i>
    maka untuk menghitung volumenya adalah</p><br>
    ";

    ?>
    <img src="https://cilacapklik.com/wp-content/uploads/2021/07/Contoh-Soal-Kubus.jpg"
    width="500px">
    <?php

    // php di dalam html
    ?>
    <div>
        <p style="font-weight:bold;font-size:20px;background-color: yellow;display:inline;">
            Volume Kubus (V) = r x r x r
        </p>
        <br>
        <ul>
            <li>Diketahui  Panjang rusuk kubus = 15 cm</li>
            <li>
                <?php 
                // diketakui ukuran Kubus
                $Pk= 15;
                $vk= $Pk * $Pk * $Pk;
                // pengerjaan
                echo "Volume Kubus =  $Pk cm x $Pk cm x $Pk cm = $vk cm<sub>3</sub>";
                ?>
            </li>
        </ul>
    </div>
    <hr>
    <br>
    <?php
    // lanjut ke php

    echo 
    "<h3>
        2. Rumus menghitung Luas Bangun ruang Balok      
    </h3>
    
    <p>gambar bawah adalah balok dengan <i>panjang rusuk kubus (r) = 15 cm</i>
    maka untuk menghitung volumenya adalah</p><br>
    ";

    ?>
    <img src="https://cilacapklik.com/wp-content/uploads/2021/07/Contoh-Soal-Balok.jpg"
    width="500px">
    <?php

    // php di dalam html
    ?>
    <div>
        <p style="font-weight:bold;font-size:20px;background-color: yellow;display:inline;">
            Volume Balok (V) = (Panjang)P x (Lebar)L x (Tinggi)T
        </p>
        <br>
        <ul>
            <li>Diketahui  <br>
                Panjang = 10 cm
                <br>
                Lebar = 7 cm
                <br>
                Tinggi = 5 cm
            </li>
            <br><br>
            <li>
                <?php 
                // diketakui ukuran Balok
                $PB= 10;
                $LB= 7;
                $TB= 5;
                $Vb= $PB * $LB * $TB;
                // pengerjaan
                echo "Volume Balok =  $PB cm x $LB cm x $TB cm = $Vb cm<sub>3</sub>";
                ?>
            </li>
        </ul>
    </div>
    <hr>
    <br>
    <?php
    // lanjut ke php


    echo 
    "<h3>
        3. Rumus menghitung Luas Bangun ruang Bola      
    </h3>
    
    <p>gambar bawah adalah bola dengan <i>ukuran jari-jari (r) = 14 cm</i>
    maka untuk menghitung volumenya adalah</p><br>
    ";

    ?>
    <img src="https://www.advernesia.com/wp-content/uploads/2019/04/Hitunglah-luas-permukaan-bola-yang-mempunyai-jari-jari-14-cm.png"
    width="300px">
    <?php

    // php di dalam html
    ?>
    <div>
        <p style="font-weight:bold;font-size:20px;background-color: yellow;display:inline;">
            Volume Bola (V) = 4/3 x 22/7 x (r)3
        </p>
        <br>
        <ul>
            <li>Diketahui  <br>
                jari-jari = 14 cm
                
            </li>
            <br><br>
            <li>
                <?php 
                // diketakui ukuran Bola
                $rb = 14;
                $a = 4/3;
                $b = 22/7;
                $jari3= $rb * $rb * $rb;
                $Vbola = $a * $b * $jari3;
                $Vbulat = floor($Vbola);
                // pengerjaan
                echo "Volume Balok =  $a x $b x $jari3 = $Vbola di bulatkan menjadi = $Vbulat cm<sub>3</sub>";
                ?>
            </li>
        </ul>
    </div>
    <hr>
    <br>
    <?php
    // lanjut ke php


    ?>
</body>
</html>