<?php

// database'mizin değişkenlerini tanımlıyoruz.
define("DB_HOST", "localhost");
define("DB_NAME", "fua30ilgicom_fuar");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "fua30ilgicom_fuarbilgi");
define("DB_PASSWORD", "Fuarbilgi.123");

// databasemize bağlanıyoruz ve $db değişkenine tanımlıyoruz
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// lokasyonumuzu Türkiye olarak tanımlıyoruz ve saat ayarını Istanbul yapıyoruz.
setlocale(LC_ALL, 'tr_TR.UTF-8', 'tr_TR', 'tr', 'turkish');
date_default_timezone_set('Europe/Istanbul');

// Veritabanına bağlantı sağlanamadı ise
if ($db->connect_error) {
    die("Bir sorun oluştu!"); // sayfayı bitiriyoruz ve hatamızı gösteriyoruz
}

$time = time(); // unix zamanımızı $time değişkenine tanımlıyoruz

$admin = false; // admin değişkenini false tanımlıyoruz
$girisVarmi = false; // girisVarmi değişkenini false tanımlıyoruz

// kullanici_mail ve kullanici_sifre adında çerezlerimiz var ise
if (isset($_COOKIE["kullanici_mail"]) && isset($_COOKIE["kullanici_sifre"])) {

    // mail ve şifreyle eşleşen bir değer var mı kontrol ediyoruz
    $girisKontrol = $db->query("SELECT * FROM kullanicilar WHERE kullanici_mail = '{$_COOKIE["kullanici_mail"]}' AND kullanici_sifre = '{$_COOKIE["kullanici_sifre"]}'");
    if ($girisKontrol->num_rows > 0) { // var ise
        $girisVarmi = true; // girisVarmi değişkenini true yapıyoruz
        $kullanici = $girisKontrol->fetch_assoc(); // kullanıcı bilgilerini $kullanici değişkenine tanımlıyoruz
        $kullanici_id = $kullanici["kullanici_id"]; // kullanici_id değişkenine kullanici_id değerini atıyoruz

        if ($kullanici["kullanici_id"] == 1) // kullanici_id 1 ise admin olarak tanımlıyoruz.
            $admin = true;
    }
}
    else {
        $kullanici_id = null; // kullanici_id değişkenini null yapıyoruz
    }
