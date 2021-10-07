<!doctype html>
<html lang="en">
<?php
//Eğer giriş yapılmamışsa anasayfaya yönlendiren kod bloğu:
require_once('fonksiyon.php');
if (isset($_GET['kid']) == false) {
  header("Location:index.php");
}
//Seçilen konuya ait bilgileri fonksiyondan alıyoruz
$konuID = $_GET['kid'];
$konuIcerik = konuBilgileri($konuID);
?>

<head>
  <title><?php echo $konuIcerik['baslik'] ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="forum-container">
    <div class="forum forum-left">
      <h3>KONULAR</h3>
      <div class="forum-subjects d-flex flex-column">
        <?php
        //Tüm konuları listeliyoruz
        $konular = tumKonular();
        foreach ($konular as $konu) {
          echo "<a href='konu-icerigi.php?kid={$konu['id']}'>{$konu['baslik']}</a>";
        }
        ?>
      </div>
    </div>
    <div class="forum forum-right">

      <header class="d-flex justify-content-between align-items-center">
        <a href="index.php" class="anasayfa">Anasayfa</a>
        <?php
        //Yönetici girişi yapılmışsa admin düğmesini görüntülüyoruz
        if (isset($_SESSION['yetki']) && $_SESSION['yetki'] == 1) {
          echo '<a href="admin.php" class="anasayfa">Yönetici Paneli</a>';
        }
        ?>
        <?php
        if (isset($_SESSION['kid']) == false) {
        ?>
          <div class="login">
            <input type="button" data-toggle="modal" data-target="#girisModal" data-whatever="@mdo" value="Giriş Yap" />
            <input type="button" data-toggle="modal" data-target="#kayitModal" data-whatever="@mdo" value="Kayıt Ol" />
          </div>
        <?php
        } else {
        ?>
          <div class="login">
            <a class="btn btn-primary" href="fonksiyon.php?cikis=1"><?php echo kullaniciBilgisi($_SESSION['kid'])['kullaniciadi']; ?> - Çıkış Yap</a>
          </div>
        <?php
        }
        ?>
      </header>
      <div class="forum-content">
        <div class="forum-content-item">
          <a href="#" class="konu-adi"><?php echo $konuIcerik['baslik'] . " - " . $konuIcerik['konuadi']; ?></a>
          <div class="user d-flex align-items-center">
          </div>
        </div>
        <?php
        //Konuya yapılan yorumları alıyoruz ve her birini listeliyoruz
        $yorumlar = konuYorumlari($konuID);
        foreach ($yorumlar as $yorum) {
          $kullanici = kullaniciBilgisi($yorum['kullaniciid']);
        ?>
          <div class="forum-content-item">
            <p class="konu-aciklaması"><?php echo $yorum['yorum']; ?></p>
            <div class="user d-flex align-items-center">
              <a href="#"><i class="fas fa-user"></i><?php echo $kullanici['kullaniciadi'] . " &nbsp-&nbsp Yorum Tarihi :" . $yorum['tarih']; ?></a>
            </div>
          </div>
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['kid']) && $_SESSION['kid'] != null) {
        ?>
          <div class="add-comment">
            <form action="fonksiyon.php" method="post">
              <input type="hidden" name="konuid" value="<?php echo $_GET['kid']; ?>">
              <textarea name="yorum" cols="30" rows="3" placeholder="Yorum Yaz..."></textarea>
              <input type="submit" value="Gönder" name="yorumyap">
            </form>
          </div>
        <?php
        } else {
          echo "<p>Yorum yapmak için giriş yapınız..";
        }
        ?>
      </div>
    </div>
  </div>

  <div class="modal fade" id="girisModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Giriş Yap</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="kullanici-adi" class="col-form-label">Kullanıcı Adı:</label>
              <input type="text" class="form-control" id="kullanici-adi">
            </div>
            <div class="form-group">
              <label for="sifre" class="col-form-label">Şifre:</label>
              <input type="password" class="form-control" id="sifre">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Kapat">
          <input type="button" class="btn btn-primary" value="Giriş Yap">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="kayitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Kayıt Ol</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="fonksiyon.php" method="POST">
            <div class="form-group">
              <label for="kullanici-adi" class="col-form-label">Kullanıcı Adı:</label>
              <input type="text" class="form-control" id="kullanici-adi" name="kullaniciadi">
            </div>
            <div class="form-group">
              <label for="sifre" class="col-form-label">Şifre:</label>
              <input type="password" class="form-control" id="sifre" name="sifre">
            </div>
            <div class="form-group">
              <label for="eposta" class="col-form-label">E-Posta:</label>
              <input type="email" class="form-control" id="eposta" name="eposta">
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Kapat">
              <input type="submit" class="btn btn-primary" value="Kayıt Ol" name="kayitol">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>