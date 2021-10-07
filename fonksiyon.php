<?php
//Veritabanı bağlantısı
$vt = mysqli_connect("localhost", "root", "", "forumvt");
session_start();
//Sil düğmesine basıldığında ID bilgisi seçilen konu ve bu konuya yapılan tüm yorumlar veri tabanından silinir
if(isset($_GET['sil'])){
    if(isset($_SESSION['yetki'])&&$_SESSION['yetki']==1){
        global $vt;
        $konuID=$_GET['sil'];
        $sonuc = $vt->query("DELETE FROM konuyorum WHERE id=$konuID");
        $sonuc = $vt->query("DELETE FROM konu WHERE id=$konuID");
        header("Location:admin.php");
    }
    else{
        header("Location:index.php");
    }
}
//Konu ekle düğmesine basılmışsa ve yetki yönetici ise girilen konu adı ve başlık bilgisi kullanılarak yeni bir konu veri tabanına eklenir
if(isset($_POST['konuekle'])&&isset($_SESSION['yetki'])&&$_SESSION['yetki']==1){
    $baslik = $_POST['baslik'];
    $konuadi = $_POST['konuadi'];
    $olusturan = $_SESSION['kid'];
    $sonuc = $vt->query("INSERT INTO konu(baslik,konuadi,olusturanid,olusturmatarihi) VALUES('$baslik','$konuadi',$olusturan,CURRENT_TIMESTAMP)");
    header("Location:admin.php");
}
//Yorum yap düğmesine basıldıysa ve giriş yapılmışsa, girilen yorum bilgisi, yorum yapılan konunun yorumlarına eklenir
if(isset($_POST['yorumyap'])&&isset($_SESSION['kid'])){
    $yorum = $_POST['yorum'];
    $kid = $_SESSION['kid'];
    $konuid = $_POST['konuid'];
    $sonuc = $vt->query("INSERT INTO konuyorum(konuid,kullaniciid,yorum,tarih) VALUES($konuid,$kid,'$yorum',CURRENT_TIMESTAMP)");
    header("Location:konu-icerigi.php?kid=$konuid");
}
//Çıkış düğmesine basılmışsa çıkış sağlanır ve anasayfaya yönlendirilir
if(isset($_GET['cikis'])){
    session_destroy();
    session_start();
    header("Location:index.php");
}
//Giriş yap düğmesine basıldığında kullanıcı adı ve şifre bilgileri alınarak girisYap fonkisoynu çağırılır
//Eğer fonksiyon false döndürmezse SESSION değerleri değiştirilerek giriş yapıldığı bilgisi güncellenir
if(isset($_POST['girisyap'])){
    $giris=girisYap($_POST['kullaniciadi'],$_POST['sifre']);
    if($giris!==false){
        $_SESSION['kid']=$giris['id'];
        $_SESSION['yetki']=$giris['yetki'];
        header("Location:index.php");
    }
    else{
        header("Location:index.php?girisbasarisiz");
    }
}
//Kayıt ol düğmesine basıldığında kullanıcı adı ve şifre bilgileri alınır ve boş değilse bu bilgiler kullanılarak
//kayitOl fonksiyonu çağırılarak kayıt gerçekleştirilir
if(isset($_POST['kayitol'])){
    $kullaniciadi = $_POST['kullaniciadi'];
    $sifre= $_POST['sifre'];
    $eposta = $_POST['eposta'];
    if(empty($kullaniciadi)||empty($sifre)||empty($eposta)){
        header("location:index.php?KayitBasarisiz"); 
    }
    else{
        if(kayitOl($kullaniciadi,$sifre,$eposta)){
            header("location:index.php?KayitBasarili"); 
        }
        else{
            header("location:index.php?KayitBasarisiz"); 
        }
    }
}
//Kayıt ol fonksiyonu çağırılınca  kullanici tablosuna yeni kayıt eklenir
function kayitOl($kadi, $sifre, $eposta)
{
    global $vt;
    $sonuc = $vt->query("INSERT INTO kullanici(kullaniciadi,sifre,eposta,yetki) VALUES('$kadi','$sifre','$eposta',0)");
    if ($sonuc == false) return false;
    else return true;
}
//Giris yap fonksiyonu, verilen kadi ve sifre bilgisine göre veri tabanında kullanıcı arar, bulunursa satır bilgisini döndürür
//Bulamazsa false döndürür
function girisYap($kadi, $sifre)
{
    global $vt;
    $sorgu = "SELECT * FROM kullanici WHERE kullaniciadi='$kadi' AND sifre='$sifre'";
    $sonuclar = $vt->query($sorgu);
    if ($satir = $sonuclar->fetch_assoc()) {
        return $satir;
    } else return false;
}
//ID bilgisi verilen konunun yorumlarını geri döndüren fonksiyon:
function konuYorumlari($konuID)
{
    global $vt;
    $sorgu = "SELECT * FROM konuyorum WHERE konuid=$konuID";
    $sonuclar = $vt->query($sorgu);
    $dizi = [];
    while ($satir = $sonuclar->fetch_assoc()) {
        array_push($dizi,$satir);
    }
    return $dizi;
}
//ID'si verilen konunun bilgilerini döndüren fonksiyon:
function konuBilgileri($kid)
{
    global $vt;
    $sorgu = "SELECT * FROM konu WHERE id=$kid";
    $sonuclar = $vt->query($sorgu);
    if ($satir = $sonuclar->fetch_assoc()) {
        return $satir;
    } 
}
//ID'si verilen kullanıcının tüm bilgilerini döndüren fonksiyon
function kullaniciBilgisi($kid)
{
    global $vt;
    $sorgu = "SELECT * FROM kullanici WHERE id=$kid";
    $sonuclar = $vt->query($sorgu);
    if ($satir = $sonuclar->fetch_assoc()) {
        return $satir;
    } 
}
//Bir konunya yapılan yorum sayısını döndüren fonksiyon
function yorumSayisi($konuid)
{
    global $vt;
    $sorgu = "SELECT count(konuyorum.id) as 'yorumsayisi' FROM konuyorum WHERE id=$konuid GROUP BY konuyorum.konuid";
    $sonuclar = $vt->query($sorgu);
    if ($satir = $sonuclar->fetch_assoc()) {
        return $satir['yorumsayisi'];
    } 
}
//Veri tabanındaki tüm konuları bir diziye ekleyerek döndüren fonksiyon
function tumKonular()
{
    global $vt;
    $sorgu = "SELECT konu.* FROM konu";
    $sonuclar = $vt->query($sorgu);
    $dizi = [];
    while ($satir = $sonuclar->fetch_assoc()) {
        array_push($dizi,$satir);
    } 
    return $dizi;
}