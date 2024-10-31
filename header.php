<!-- Google Font Linki Ekledik -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Pacifico&display=swap');
</style>

<div class="container">
    <a href="index.php">
        <h2 class="jaro float-left">Fuar Giyim</h2>
    </a>

    <nav id="navigasyon">
        <ul>
            <li><a href="index.php">Ana Sayfa</a></li>
            <li><a href="urunler.php">Ürünlerimiz</a></li>
            <li><a href="iletisim.php">İletişime Geç</a></li>
            <?= ($admin ? '<li><a href="admin.php">Admin</a></li>' : '') // admin ise menüde Admin sayfasını gösteriyoruz ?>
        </ul>
    </nav>

    <div class="user">
        <?php if (!$girisVarmi) { // Giriş yapılmamış ise bu kısmı yüklüyoruz
                echo '<a href="login.php" style="background-color:#E5E5E5; border-radius:18px; padding:10px; margin-left:5px; color:black;">Giriş yap</a>
                <a href="login.php?register" style="border-radius:18px; margin-left:2px; padding: 10px; color:white; background:red;"">Kayıt Ol</a>';
            } else { // giriş yapılmış ise burayı yüklüyoruz.
                echo '<a href="profil.php">' . $kullanici["kullanici_isim"] . '</a>
            <img class="userimg" src="images/kullanicilar/' . $kullanici["kullanici_id"] . '.jpg"
            onerror="this.src=\'images/kullanicilar/kullanicilar.png\'" alt="Kullanıcı Fotoğrafı">
            <a href="begenilenler.php" style="width:60px; background-color:#E5E5E5; border-radius:20px; margin-left:5px; padding: 5px; color:white;"><i class="fa-regular fa-bookmark" style="color: #000000;"></i></a>
            <a href="profil.php?logout" style="width:60px; border-radius:20px; margin-left:2px; padding: 5px; color:white; background:red;"">Çıkış</a>';
            } ?>

        <img class="menu" src="images/menu.png" onclick="menu()" alt="Menü">
    </div>
</div>

<script>
    // menu fonksiyonu
    function menu() {
        var nav = document.getElementById("navigasyon"); // navigasyon ID'li elementi seçiyoruz
        var disp = window.getComputedStyle(nav).display; // navigasyon elementimizin display değerini seçiyoruz
        if (disp == "none") { // display: none ise
            nav.style.display = "block"; // display: block yapıyoruz ve menümüzü gösteriyoruz
        } else nav.style.display = "none"; // değil ise display: none yapıyoruz ve menümüzü gizliyoruz
    }
</script>
