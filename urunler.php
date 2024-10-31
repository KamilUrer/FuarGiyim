<?php
require 'config.php'; // config ayarlarımızı yüklüyoruz

// Filtreleme için değişkenler
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$minFiyat = isset($_GET['min_fiyat']) ? $_GET['min_fiyat'] : '';
$maxFiyat = isset($_GET['max_fiyat']) ? $_GET['max_fiyat'] : '';
$renk = isset($_GET['renk']) ? $_GET['renk'] : '';

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürünler | Fuar Giyim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

    <header>
        <?php require 'header.php'; // header'ı yazdırıyoruz. ?>
    </header>

    <main>

        <div class="welcome small">
            <div class="dark"></div>
            <img src="images/urun.jpg" class="main_img" alt="Giysi Sitesi Giriş Resmi">
            <div class="container">
                <h1>Ürünler</h1>
            </div>
        </div>

        <div class="container mt-100 main-content">
            <!-- Filtreleme Çubuğu -->
            <div class="filter-bar">
                <form method="GET">
                    <select name="kategori">
                        <option value="">Kategori Seçin</option>
                        <option value="Erkek" <?= $kategori == 'Erkek' ? 'selected' : '' ?>>Erkek</option>
                        <option value="Kadın" <?= $kategori == 'Kadın' ? 'selected' : '' ?>>Kadın</option>
                        <option value="Çocuk" <?= $kategori == 'Çocuk' ? 'selected' : '' ?>>Çocuk</option>
                    </select>
                    <input type="number" name="min_fiyat" placeholder="Min Fiyat" value="<?= htmlspecialchars($minFiyat) ?>">
                    <input type="number" name="max_fiyat" placeholder="Max Fiyat" value="<?= htmlspecialchars($maxFiyat) ?>">
                    <input type="text" name="renk" placeholder="Renk" value="<?= htmlspecialchars($renk) ?>">
                    <button type="submit">Filtrele</button>
                </form>
            </div>

            <div class="urunler mt-30">
                <?php
                // SQL sorgusunu oluşturuyoruz
                $sql = 'SELECT * FROM urunler WHERE 1=1';

                if ($kategori) {
                    $sql .= ' AND urun_kategori = "' . $db->real_escape_string($kategori) . '"';
                }
                if ($minFiyat) {
                    $sql .= ' AND urun_fiyat >= ' . (int)$minFiyat;
                }
                if ($maxFiyat) {
                    $sql .= ' AND urun_fiyat <= ' . (int)$maxFiyat;
                }
                if ($renk) {
                    $sql .= ' AND urun_renk = "' . $db->real_escape_string($renk) . '"';
                }

                // Sorguyu çalıştırıyoruz
                $urunleriCek = $db->query($sql);

                if ($urunleriCek->num_rows == 0) { // tablomuzda ürün yok ise
                    echo 'Gösterilecek ürün bulunamadı';
                } else { // var ise
                    // while ile ürünleri tek tek yazdırıyoruz.
                    while ($urun = $urunleriCek->fetch_assoc()) {
                        echo '<div class="urun">
            <div class="urun_icerik">
                <img src="images/urun/' . $urun["urun_id"] . '.jpg" alt="' . $urun["urun_isim"] . '">
                <div class="urun_detay">
                    <h5>' . $urun["urun_isim"] . '</h5>
                    <h6>' . number_format($urun["urun_fiyat"], 0, ',', '.') . '₺<b>' . $urun["urun_kategori"] . '</b></h6>
                    <a href="urun-detay.php?urun_id=' . $urun["urun_id"] . '"><button class="button-1">Detaylar</button></a>
                </div>
            </div>
        </div>';
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <footer>
        <?php require 'footer.php' // footer'ımızı yazdırıyoruz. ?>
    </footer>

</body>
</html>
