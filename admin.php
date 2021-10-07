<!doctype html>
<html lang="en">
<?php
require_once("fonksiyon.php");
?>

<head>
  <title>Yönetici Paneli</title>
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
        //Tüm konular veri tabanından çekilerek sağ tarafta listelenir
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
        //Yetki 1 ise yönetici paneli görüntülenir
        if (isset($_SESSION['yetki']) && $_SESSION['yetki'] == 1) {
          echo '<a href="admin.php" class="anasayfa">Yönetici Paneli</a>';
        }
        ?>
        <?php
        //Eğer giriş yapılmışsa çıkış düğmesi gösterilir, yapılmamışsa giriş yap düğmesi
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
      <div class="admin-konular-header d-flex align-items-center justify-content-between">
        <h5>Tüm Konular</h5>
        <input type="button" value="Yeni Konu Ekle" data-toggle="modal" data-target="#yeniKonuEkle" data-whatever="@mdo">
      </div>
      <div class="admin-konular d-flex flex-column">
        <?php
        //Veri tabanındaki her bir konu sırasıyla yazdırılır
        foreach ($konular as $konu) {
        ?>
          <div class="admin-konular-item d-flex align-items-center justify-content-between">
            <p><?php echo $konu['baslik']; ?></p>
            <div class="actions d-flex align-items-center ">
              <a class="btn btn-primary" href="fonksiyon.php?sil=<?php echo $konu['id']; ?>">Sil</a>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
<!--
  Giriş Yap düğmesine basıldığında açılan pencere kodları;
  Form içinde kadı ve şifre girişi yapılacak alanlar açılır
-->
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
          <form action="fonksiyon.php" method="POST">
            <div class="form-group">
              <label for="kullanici-adi" class="col-form-label">Kullanıcı Adı:</label>
              <input type="text" class="form-control" id="kullanici-adi" name="kullaniciadi">
            </div>
            <div class="form-group">
              <label for="sifre" class="col-form-label">Şifre:</label>
              <input type="password" class="form-control" id="sifre" name="sifre">
            </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Kapat">
          <input type="submit" class="btn btn-primary" value="Giriş Yap" name="girisyap">
        </div>
          </form>
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

  <div class="modal fade" id="yeniKonuEkle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yeni Konu Ekle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="fonksiyon.php" method="POST">
            <div class="form-group">
              <label for="konu-baslik" class="col-form-label">Konu Başlığı:</label>
              <input type="text" class="form-control" id="konu-baslik" name="baslik">
              <label for="konu-adi" class="col-form-label">Konu Adı / Detayı:</label>
              <input type="text" class="form-control" id="konu-adi" name="konuadi">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
              <input type="submit" class="btn btn-primary" name="konuekle" value="Ekle">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
          <button type="button" class="btn btn-primary">Tamamla</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="eminMisin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="sil-text">Silmek istediğine emin misin?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
          <button type="button" class="btn btn-danger">Sil</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>