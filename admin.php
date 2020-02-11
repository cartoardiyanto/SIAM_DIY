<?php
    ob_start();
    //cek session
    session_start();

    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
?>


<!doctype html>
<html lang="en">

<!-- Include Head START -->
<?php include('include/head.php'); ?>
<!-- Include Head END -->

    
<!-- Body START -->
<body class="bg">

<!-- Header START -->
<header>

<!-- Include Navigation START -->
<?php include('include/menu.php'); ?>
<!-- Include Navigation END -->

</header>
<!-- Header END -->

<!-- Main START -->
<main>

    <!-- container START -->
    <div class="container">

    <?php
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
            switch ($page) {
                case 'bks':
                    include "berkas_khusus.php";
                    break;
                case 'bkr':
                    include "berkas_koresponden.php";
                    break;
                case 'usr':
                    include "user.php";
                    break;
                case 'pro':
                    include "profil.php";
                    break;
                        break;
                case 'fbks':
                    include "fbks.php";
                    break;
                case 'fbkr':
                    include "fbkr.php";
                    break;
            }
        } else {
    ?>
        <!-- Row START -->
        <div class="row">

            <!-- Include Header Instansi START -->
            <?php include('include/header_instansi.php'); ?>
            <!-- Include Header Instansi END -->

            <!-- Welcome Message START -->
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h4>Selamat Datang <?php echo $_SESSION['nama']; ?></h4>
                        <p class="description">Anda login sebagai
                        <?php
                            if($_SESSION['admin'] == 1){
                                echo "<strong>Super Admin</strong>. Anda memiliki akses penuh terhadap sistem.";
                            } elseif($_SESSION['admin'] == 2){
                                echo "<strong>Administrator</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                            } else {
                                echo "<strong>Petugas Arsip</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                            }?></p>
                    </div>
                </div>
            </div>
            <!-- Welcome Message END -->

            <?php
                //menghitung jumlah surat masuk
                $count1 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_berkas_khusus"));

                //menghitung jumlah berkas korespondensi
                $count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_berkas_koresponden"));

                //menghitung isi berkas khusus
                $count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_isi_berkas_khusus"));

                // ngitung isi berkas korespondensi
                $count4 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden"));

                //ngitung user
                $count5 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_user"));
            ?>

            <!-- Info Statistic START -->
            <div class="col s12 m6">
                <div class="card blue darken-2">
                    <div class="card-content">
                        <span class="card-title white-text"><i class="material-icons md-36">book</i> Arsip Khusus</span>
                        <?php echo '<h5 class="white-text link">'.$count1.' Berkas</h5>'; ?>
                    </div>
                </div>
            </div>
            
            <div class="col s12 m6">
                <div class="card purple darken-1">
                    <div class="card-content">
                        <span class="card-title white-text"><i class="material-icons md-36">book</i> Arsip Korespondensi</span>
                        <?php echo '<h5 class="white-text link">'.$count2.' Berkas</h5>'; ?>
                    </div>
                </div>
            </div>

            <div class="col s12 m6">
                <div class="card blue darken-2">
                    <div class="card-content">
                        <span class="card-title white-text"><i class="material-icons md-36">description</i> Isi Berkas Khusus</span>
                        <?php echo '<h5 class="white-text link">'.$count3.' Item</h5>'; ?>
                    </div>
                </div>
            </div>


             <div class="col s12 m6">
                <div class="card purple darken-1">
                    <div class="card-content">
                        <span class="card-title white-text"><i class="material-icons md-36">description</i> Isi Berkas Korespondensi</span>
                        <?php echo '<h5 class="white-text link">'.$count4.' Item</h5>'; ?>
                    </div>
                </div>
            </div>


        <?php
            if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2){?>
            <div class="col s12 m12">
                <div class="card red accent-2">
                    <div class="card-content">
                        <span class="card-title white-text"><i class="material-icons md-36">people</i> Jumlah Pengguna</span>
                        <?php echo '<h5 class="white-text link">'.$count5.' Pengguna</h5>'; ?>
                    </div>
                </div>
            </div>
            <!-- Info Statistic START -->
        <?php
            }
        ?>

        </div>
        <!-- Row END -->
    <?php
        }
    ?>
    </div>
    <!-- container END -->

</main>
<!-- Main END -->

<!-- Include Footer START -->
<?php include('include/footer.php'); ?>
<!-- Include Footer END -->

</body>
<!-- Body END -->

</html>

<?php
    }
?>
