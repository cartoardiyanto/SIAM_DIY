<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
 if($_SESSION['admin'] ==2){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk membuka halaman ini");
                    window.location.href="./logout.php";
                  </script>';
        } else {

        if(isset($_REQUEST['submit'])){

            //validasi form kosong
            if($_REQUEST['klasifikasi'] == "" || $_REQUEST['pencipta_arsip'] == "" || $_REQUEST['deskripsi'] == ""|| $_REQUEST['kurun_waktu'] == ""|| $_REQUEST['keterangan'] =="" || $_REQUEST['jangka_simpan'] == "")
             {
                
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi!';
                echo '<script language="javascript">window.history.back();</script>';
            }else {
                $rak = $_REQUEST['rak'];
                $box = $_REQUEST['box'];
                $klasifikasi = $_REQUEST['klasifikasi'];
                $pencipta_arsip = $_REQUEST['pencipta_arsip'];
                $deskripsi = $_REQUEST['deskripsi'];
                $kurun_waktu = $_REQUEST['kurun_waktu'];
                $keterangan = $_REQUEST['keterangan'];
                $lokasi_simpan = $_REQUEST['lokasi_simpan'];
                $jangka_simpan = $_REQUEST['jangka_simpan'];
                $id_user = $_SESSION['id_user'];

        
                 //validasi input data

                    if(!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $pencipta_arsip)){
                        $_SESSION['pencipta_arsip'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } 
                    else {

                         if(!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $deskripsi)){
                                $_SESSION['deskripsi'] = 'Form deskripsi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } 
                            else {
                                if(!preg_match("/^[a-zA-Z0-9.()\/ -]*$/", $kurun_waktu)){
                                    $_SESSION['kurun_waktu'] = 'Form Asal Surat hanya boleh mengandung karakter angka dan minus(-)';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } 
                                else{

                                    if(!preg_match("/^[a-zA-Z0-9., ]*$/", $tingkat_perkembangan)){
                                        $_SESSION['tingkat_perkembangan'] = 'Form jumlah hanya boleh mengandung karakter huruf, koma(,) dan spasi';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } 
                                    else {

                                            if(!preg_match("/^[a-zA-Z0-9., ]*$/", $keterangan)){
                                                $_SESSION['keterangan'] = 'Form Tanggal Surat hanya boleh mengandung huruf, koma(,) dan spasi';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            } else {

                                                if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $lokasi_simpan)){
                                                    $_SESSION['lokasi_simpan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                } 
                                                else {
                                                        if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $jangka_simpan)){
                                                         $_SESSION['jangka_simpan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                                        echo '<script language="javascript">window.history.back();</script>';
                                                        } 
                                                        else {


                                                            $sintak = mysqli_query($config, "SELECT kode_klasifikasi FROM tbl_opsi_klasifikasi WHERE id_kode='$klasifikasi'");

                                                            while($data = mysqli_fetch_array($sintak)){
                                                                $kode=$data['kode_klasifikasi'];
                                                            }

                                                             $satuin[0]=$rak;
                                                            $satuin[1]=$box;
                                                            $lokasi_simpan=(implode(".",$satuin));
                                                             $no_dentitif = $_REQUEST['no_dentitif'];
                                                            $query = mysqli_query($config, 
                                                                "UPDATE tbl_berkas_koresponden SET
                                                                id_kode='$klasifikasi',
                                                                kode_klasifikasi='$kode', 
                                                                pencipta_arsip='$pencipta_arsip', 
                                                                deskripsi ='$deskripsi', 
                                                                kurun_waktu='$kurun_waktu', 
                                                                keterangan ='$keterangan', 
                                                                lokasi_simpan='$lokasi_simpan', 
                                                                jangka_simpan='$jangka_simpan', 
                                                                id_user ='$id_user' 
                                                                WHERE no_dentitif='$no_dentitif'");
                                                            
                                                            if($query == true){
                                                            $sintak = mysqli_query($config, "SELECT no_dentitif FROM tbl_berkas_koresponden WHERE no_dentitif='$no_dentitif'");

                                                            while($data = mysqli_fetch_array($sintak)){
                                                                $baru=$data['no_dentitif'];
                                                            }

                                                                $_SESSION['succAdd'] ="Data no dentitif = "."$baru"." Berhasil Dirubah !";
                                                                header("Location: ./admin.php?page=bkr");
                                                                die();
                                                            } 

                                                            else {
                                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    
                                }
                            }
                        }
                    }
                
            
    else {

        $no_dentitif = mysqli_real_escape_string($config,$_REQUEST['no_dentitif']);
        $query = mysqli_query($config, "SELECT  pencipta_arsip, deskripsi, kurun_waktu,keterangan, lokasi_simpan, jangka_simpan,id_user FROM tbl_berkas_koresponden WHERE no_dentitif='$no_dentitif'");
        list($pencipta_arsip,$deskripsi,$kurun_waktu,$keterangan,$lokasi_simpan,$jangka_simpan,$id_user) = mysqli_fetch_array($query);

        if($_SESSION['id_user'] != $id_user AND $_SESSION['admin'] ==2 ){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=bkr";
                  </script>';
        } else {?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper green darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Berkas Korespondensi No Dentitif :  <?php echo "$no_dentitif"; ?></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
                if(isset($_SESSION['errQ'])){
                    $errQ = $_SESSION['errQ'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errQ']);
                }
                if(isset($_SESSION['errEmpty'])){
                    $errEmpty = $_SESSION['errEmpty'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errEmpty']);
                }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <!-- Form START -->
                <form class="col s12" method="POST" action="?page=bkr&act=edit&no_dentitif=<?php echo $no_dentitif ?>" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="input-field col s6">
                         <i class="material-icons prefix md-prefix">format_align_justify</i><label>Pilih Klasifikasi Berkas</label><br>
                            <div class="input-field col s11 right">
                                <select class="klasifikasi" name="klasifikasi" id="klasifikasi" required>
                                <?php 
                                    
                                        $sintak = mysqli_query($config, "SELECT * FROM tbl_berkas_koresponden where no_dentitif='$no_dentitif'");
                                        while($x=mysqli_fetch_assoc($sintak)){

                                            $kode_sebelum=$x['id_kode'];
                                        }


                                                               
                                        $tested = mysqli_query($config, "SELECT * FROM tbl_opsi_klasifikasi where id_kode='$kode_sebelum'");
                                        while($x=mysqli_fetch_assoc($tested)){

                                     ?>
                                                ?>
                                <option value="<?php echo $x['id_kode']; ?>"><?php echo $x['nama_klasifikasi']; ?></option>
                                 <?php 
                                      } 
                                    ?>



                                <?php 
                                 $query = mysqli_query($config, "SELECT* FROM tbl_opsi_klasifikasi where id_kode > 40");
                                 while($data=mysqli_fetch_assoc($query)){
                                ?>
                                    <option value="<?php echo $data['id_kode']; ?>"><?php echo $data['nama_klasifikasi']; ?></option>
                                  <?php 
                                      } 
                                    ?>

                                </select>

                              
                            </div>
                                <?php
                                    if(isset($_SESSION['klasifikasi'])){
                                        $klasifikasi = $_SESSION['klasifikasi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$klasifikasi.'</div>';
                                        unset($_SESSION['klasifikasi']);
                                    }
                                ?>
                        </div>
                        
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">archive</i>
                            <input id="pencipta_arsip" type="text" class="validate" name="pencipta_arsip" value="<?php echo $pencipta_arsip?>" required >
                                <?php
                                    if(isset($_SESSION['pencipta_arsip'])){
                                        $pencipta_arsip = $_SESSION['pencipta_arsip'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$pencipta_arsip.'</div>';
                                        unset($_SESSION['pencipta_arsip']);
                                    }
                                ?>
                            <label for="pencipta_arsip">Pencipta Arsip</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">description</i>
                            <textarea id="deskripsi" class="materialize-textarea validate" name="deskripsi" required ><?php echo $deskripsi?></textarea>
                                <?php
                                    if(isset($_SESSION['deskripsi'])){
                                        $deskripsi = $_SESSION['deskripsi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$deskripsi.'</div>';
                                        unset($_SESSION['deskripsi']);
                                    }
                                ?>
                            <label for="deskripsi">Deskripsi</label>
                        </div>
                      
                      
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">announcement</i><br>
                            <div class="input-field col s11 right"><br>
                            <select  id="keterangan"  name="keterangan" >
                                <?php 
                                    if ($keterangan==1) {
                                    echo '<option value="1">Baik</option>';
                                    }
                                    else if ($keterangan==2) {
                                    echo '<option value="2">Rapuh</option>';
                                    }
                                    else if ($keterangan==3) {
                                     echo '<option value="3">Menguning</option>';
                                    }
                                    else if ($keterangan==4) { 
                                    echo '<option value="4">Sobek</option>';
                                    }
                                    else if ($keterangan==5) {
                                    echo '<option value="5">Rapuh,Menguning</option>';
                                    }
                                    else if ($keterangan==6) {
                                    echo '<option value="6">Sobek,Menguning</option>';
                                    }
                                    else  if ($keterangan==7) {
                                    echo '<option value="7">Rapuh,Sobek</option>';
                                    }

                                    else if ($keterangan==8) {
                                    echo '<option value="8">Rapuh, menguning, sobek</option>';
                                    }

                                    else if ($keterangan==9) {
                                    echo '<option value="9">Rusak</option>';
                                    }
                                 ?>
                                <option value="1">Baik</option>
                                <option value="2">Rapuh</option>
                                <option value="3">Menguning</option>
                                <option value="4">Sobek</option>
                                <option value="5">Rapuh,Menguning</option>
                                <option value="6">Sobek,Menguning</option>
                                <option value="7">Rapuh,Sobek</option>
                                <option value="8">Rapuh, menguning, sobek</option>
                                <option value="9">Rusak</option>
                            </select>
                            </div>

                                <?php
                                    if(isset($_SESSION['keterangan'])){
                                        $keterangan = $_SESSION['keterangan'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$keterangan.'</div>';
                                        unset($_SESSION['keterangan']);
                                    }
                                ?>
                            <label for="keterangan">keterangan</label>
                        </div>
                        <div class="input-field col s6 right">
                            <i class="material-icons prefix md-prefix">local_library</i><br>
                           <div class="input-field col s6 "><br>
                                <label for="lokasi_simpan">Rak</label>
                                <?php 
                                    $lokasi_simpan;
                                    $tempat=(explode(".",$lokasi_simpan))

                                       ?>
                                <select class="rak" name="rak" id="rak" required>
                                    <?php 
                                    echo '<option value='.$tempat[0].'>'.$tempat[0].'</option>';
                                     ?>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>

                              
                            </div>
                            <div class="input-field col s6 "><br>
                                <label for="lokasi_simpan">Boks</label>
                                <select class="box" name="box" id="box" required>
                                    <?php 
                                    $x=1;
                                     echo '<option value='.$tempat[1].'>'.$tempat[1].'</option>';
                                    while ($x <= 20) {
                                        echo '<option value="'.$x.'">'.$x.'</option>';
                                        $x++;
                                    } ?>
                                </select>

                              
                            </div>
                            <label for="lokasi_simpan">Pilih Lokasi Simpan</label>
                             
                        </div>
                     <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">watch_later</i>
                            <input id="kurun_waktu" type="text" class="validate" name="kurun_waktu" value="<?php echo $kurun_waktu?>" required>
                                <?php
                                    if(isset($_SESSION['kurun_waktu'])){
                                        $kurun_waktu = $_SESSION['kurun_waktu'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$kurun_waktu.'</div>';
                                        unset($_SESSION['kurun_waktu']);
                                    }
                                ?>
                            <label for="kurun_waktu">Kurun Waktu</label>
                        </div>

                    
                        <div class="input-field col s6 left">
                            <i class="material-icons prefix md-prefix">timelapse</i>
                              <div class="input-field col s11 right ">
                                <br>
                                <select class="jangka_simpan" name="jangka_simpan" id="jangka_simpan" required>
                                <?php echo '<option value='.$jangka_simpan.'>'.$jangka_simpan.'</option>'; ?>
                                <option value="-">-</option>
                                <option value="serah">serah</option>                
                                <option value="serah">pindah</option>                
                                <option value="serah">musnah</option>                
                                
                                </select>
                               </div>
                              <label for="jangka_simpan">Nasib Akhir</label>
                         </div>
                        


                    </div>
                    <!-- Row in form END -->

                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=bkr" class="btn-large deep-orange waves-effect waves-light">BATAL<i class="material-icons">clear</i></a>
                        </div>
                    </div>
                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->

<?php
            }
            }

    }
}
    
?>
