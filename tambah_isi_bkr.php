<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
        if($_SESSION['admin'] ==2 ){
                    echo '<script language="javascript">
                            window.alert("ERROR! Anda tidak memiliki hak akses untuk menambah data !");
                            window.location.href="./admin.php?page=bkr";
                          </script>';
                } 
            else{
        if(isset($_REQUEST['submit'])){

          
            //validasi form kosong
           if($_REQUEST['klasifikasii'] == "" || $_REQUEST['pencipta_arsipi'] == "" || $_REQUEST['deskripsii'] == ""|| $_REQUEST['kurun_waktui'] == ""|| $_REQUEST['jumlahi'] == "" || $_REQUEST['keterangani'] == "")
            {
               
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';

                echo '<script language="javascript">window.history.back();</script>';
            } else {

                $no_dentitif = $_REQUEST['no_dentitif'];
                $rak = $_REQUEST['rak'];
                $box = $_REQUEST['box'];
                $klasifikasii = $_REQUEST['klasifikasii'];
                $pencipta_arsipi = $_REQUEST['pencipta_arsipi'];
                $deskripsii = $_REQUEST['deskripsii'];
                $kurun_waktui = $_REQUEST['kurun_waktui'];
                $tingkat_perkembangani = $_REQUEST['tingkat_perkembangani'];
                $jumlahi = $_REQUEST['jumlahi'];
                $keterangani = $_REQUEST['keterangani'];
              
                $jangka_simpani = $_REQUEST['jangka_simpani'];
                $id_user = $_SESSION['id_user'];


                 if(!preg_match("/^[0-9]*$/", $klasifikasii)){
                    $_SESSION['klasifikasi'] = 'Form Nomor Agenda harus dideskripsi angka!';
                    echo '<script language="javascript">window.history.back();</script>';
                } 
                else {

                    if(!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $pencipta_arsipi)){
                        $_SESSION['pencipta_arsip'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } 
                    else {

                         if(!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $deskripsii)){
                                $_SESSION['deskripsi'] = 'Form deskripsi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } 
                            else {
                                if(!preg_match("/^[a-zA-Z0-9.()\/ -]*$/", $kurun_waktui)){
                                    $_SESSION['kurun_waktu'] = 'Form Asal Surat hanya boleh mengandung karakter angka dan minus(-)';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } 
                                else{

                                        if(!preg_match("/^[0-9]*$/", $jumlahi)){
                                           $_SESSION['jumlah'] = 'Form jumlah hanya boleh mengandung karakter angka';
                                         echo '<script language="javascript">window.history.back();</script>';
                                        } else {
                                                        if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $jangka_simpani)){
                                                         $_SESSION['jangka_simpan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                                        echo '<script language="javascript">window.history.back();</script>';
                                                        } 

                                                    else {

                                                    $ekstensi = array('doc','docx','pdf');
                                                    $file = $_FILES['file']['name'];
                                                    $x = explode('.', $file);
                                                    $eks = strtolower(end($x));
                                                    $ukuran = $_FILES['file']['size'];
                                                    $target_dir = "upload/berkas_koresponden/";

                                                    if (! is_dir($target_dir)) {
                                                        mkdir($target_dir, 0755, true);
                                                    }

                                                    //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                                    if($file != ""){

                                                        $rand = rand(1,10000);
                                                        $nfile = $rand."-".$file;
                                                        //validasi file
                                                        if(in_array($eks, $ekstensi) == true){
                                                            if($ukuran < 2500000){

                                                           
                                                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir.$nfile);
                                                            $sintak = mysqli_query($config, "SELECT kode_klasifikasi FROM tbl_opsi_klasifikasi WHERE id_kode='$klasifikasii'");

                                                            while($data = mysqli_fetch_array($sintak)){
                                                                $kode=$data['kode_klasifikasi'];
                                                            }

                                                          
                                                            $s = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden 
                                                                where no_dentitifi='$no_dentitif'");

                                                            $no_item = mysqli_num_rows($s);
                                                            $no_item=$no_item+1;
                                                            
                                                            $satuin[0]=$rak;
                                                            $satuin[1]=$box;
                                                            $lokasi_simpani=(implode(".",$satuin));
                                                                $query = mysqli_query($config, "INSERT INTO tbl_isi_berkas_koresponden(no_itemi ,id_kodei,kode_klasifikasi,pencipta_arsipi,deskripsii,kurun_waktui,tingkat_perkembangani,jumlahi,keterangani,lokasi_simpani,file,jangka_simpani,no_dentitifi,id_useri)
                                                                VALUES('$no_item','$klasifikasii','$kode','$pencipta_arsipi','$deskripsii','$kurun_waktui','$tingkat_perkembangani','$jumlahi','$keterangani','$lokasi_simpani','$nfile','$jangka_simpani','$no_dentitif','$id_user')");


                                                                if($query == true){
                                                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                                    header("Location: ./admin.php?page=bkr&act=isikoresponden&no_dentitif=$no_dentitif");
                                                                    die();
                                                                } else {
                                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                    echo '<script language="javascript">window.history.back();</script>';
                                                                }
                                                            } else {
                                                                $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        } else {
                                                            $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.DOC, *.DOCX atau *.PDF!';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    } else {

                                                            $sintak = mysqli_query($config, "SELECT kode_klasifikasi FROM tbl_opsi_klasifikasi WHERE id_kode='$klasifikasii'");

                                                            while($data = mysqli_fetch_array($sintak)){
                                                                $kode=$data['kode_klasifikasi'];
                                                            }

                                                            $sintak3 = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden where no_dentitifi='$no_dentitif' ");

                                                            $no_item = mysqli_num_rows($sintak3);
                                                            $no_item=$no_item+1;
                                                        
                                                        //jika form file kosong akan mengeksekusi script dibawah ini
                                                            $satuin[0]=$rak;
                                                            $satuin[1]=$box;
                                                            $lokasi_simpani=(implode(".",$satuin));
                                                            
                                                         $query = mysqli_query($config, "INSERT INTO tbl_isi_berkas_koresponden(no_itemi,id_kodei,kode_klasifikasi,pencipta_arsipi,deskripsii,kurun_waktui,tingkat_perkembangani,jumlahi,keterangani,lokasi_simpani,file,jangka_simpani,no_dentitifi,id_useri)
                                                                VALUES('$no_item','$klasifikasii','$kode','$pencipta_arsipi','$deskripsii','$kurun_waktui','$tingkat_perkembangani','$jumlahi','$keterangani','$lokasi_simpani','','$jangka_simpani','$no_dentitif','$id_user')");


                                        if($query == true){
                                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                        echo '<script language="javascript">
                                                window.location.href="./admin.php?page=bkr&act=isikoresponden&no_dentitif='.$no_dentitif.'";
                                              </script>';
                                    } else {
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
        } else {?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper green darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">note_add   </i> Tambah Isi Berkas Korespondensi</a></li>
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
                <form class="col s12" method="post" action="" enctype="multipart/form-data">

                    <!-- Row in form START -->
                     <div class="input-field col s6">
                         <i class="material-icons prefix md-prefix">format_align_justify</i><label>Pilih Klasifikasi Berkas</label><br>
                            <div class="input-field col s11 right">
                                <select class="klasifikasii" name="klasifikasii" id="klasifikasii" required>

                                <?php 
                                 $query = mysqli_query($config, "SELECT* FROM tbl_opsi_klasifikasi where id_kode > 40 ");

                                 while($data=mysqli_fetch_assoc($query)){
                                ?>
                                    <option value="<?php echo $data['id_kode']; ?>"><?php echo $data['nama_klasifikasi']; ?></option>
                                  <?php 
                                      } 
                                    ?>

                                </select>

                              
                            </div>
                                <?php
                                    if(isset($_SESSION['klasifikasii'])){
                                        $klasifikasii = $_SESSION['klasifikasii'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$klasifikasii.'</div>';
                                        unset($_SESSION['klasifikasii']);
                                    }
                                ?>
                        </div>
                        
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">archive</i>
                            <input id="pencipta_arsipi" type="text" class="validate" name="pencipta_arsipi" required>
                                <?php
                                    if(isset($_SESSION['pencipta_arsipi'])){
                                        $pencipta_arsipi = $_SESSION['pencipta_arsipi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$pencipta_arsipi.'</div>';
                                        unset($_SESSION['pencipta_arsipi']);
                                    }
                                ?>
                            <label for="pencipta_arsipi">Pencipta</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">description</i>
                            <textarea id="deskripsii" class="materialize-textarea validate" name="deskripsii" required></textarea>
                                <?php
                                    if(isset($_SESSION['deskripsii'])){
                                        $deskripsii = $_SESSION['deskripsii'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$deskripsii.'</div>';
                                        unset($_SESSION['deskripsii']);
                                    }
                                ?>
                            <label for="deskripsii">Deskripsi</label>
                        </div>

                        <div class="input-field col s6">
                           <i class="material-icons prefix md-prefix">watch_later</i>
                            <input id="kurun_waktui" type="text" class="validate" name="kurun_waktui" required>
                                <?php
                                    if(isset($_SESSION['kurun_waktui'])){
                                        $kurun_waktui = $_SESSION['kurun_waktui'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$kurun_waktui.'</div>';
                                        unset($_SESSION['kurun_waktui']);
                                    }
                                ?>
                            <label for="kurun_waktui">Kurun Waktu</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">insert_drive_file</i>
                             <div class="input-field col s11 right">
                               <select class="tingkat_perkembangani" name="tingkat_perkembangani" id="tingkat_perkembangani" required>
                                    <option value="1">asli</option>
                                    <option value="2">salinan</option>

                                </select>
                            </div>
                                <?php
                                    if(isset($_SESSION['tingkat_perkembangani'])){
                                        $tingkat_perkembangan = $_SESSION['tingkat_perkembangani'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$tingkat_perkembangan.'</div>';
                                        unset($_SESSION['tingkat_perkembangani']);
                                    }
                                ?>
                            <label for="tingkat_perkembangani">Pilih Tingkat Perkembangan</label>
                        </div>   


                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="jumlahi" type="number" class="validate" name="jumlahi" required>
                                <?php
                                    if(isset($_SESSION['jumlahi'])){
                                        $jumlahi = $_SESSION['jumlahi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$jumlahi.'</div>';
                                        unset($_SESSION['jumlahi']);
                                    }
                                  
                                ?>
                            <label for="jumlahi">Jumlah Item</label>
                        </div>
                       


                         <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">announcement</i><br>
                            <div class="input-field col s11 right">
                            <select  id="keterangani"  name="keterangani" >
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
                                    if(isset($_SESSION['keterangani'])){
                                        $keterangani = $_SESSION['keterangani'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$keterangani.'</div>';
                                        unset($_SESSION['keterangani']);
                                    }
                                ?>
                            <label for="keterangani">keterangan</label>
                        </div>


                          <div class="input-field col s6 right">
                            <i class="material-icons prefix md-prefix">local_library</i><br>
                           <div class="input-field col s6 "><br>
                                <label for="lokasi_simpani">Rak</label>
                                <select class="rak" name="rak" id="rak" required>

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

                                    while ($x <= 20) {
                                        echo '<option value="'.$x.'">'.$x.'</option>';
                                        $x++;
                                    } ?>
                                </select>

                              
                            </div>
                            <label for="lokasi_simpani">Pilih Lokasi Simpan</label>
                     
                    </div>
                    
                    <div class="input-field col s6 left">
                            <i class="material-icons prefix md-prefix">timelapse</i>
                              <div class="input-field col s11 right ">
                                <br>
                                <select class="jangka_simpani" name="jangka_simpani" id="jangka_simpani" required>
                                <option value="-">-</option>
                                <option value="serah">serah</option>                
                                <option value="serah">pindah</option>                
                                <option value="serah">musnah</option>                
                                
                                </select>
                               </div>
                              <label for="jangka_simpani">Nasib Akhir</label>
                    </div>
                        

                        <div class="input-field col s6">
                            <div class="file-field input-field">
                                <div class="btn light-green darken-1">
                                  <i class="material-icons">backup</i>
                                    <input type="file" id="file" name="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload file/scan gambar surat masuk">
                                        <?php
                                            if(isset($_SESSION['errSize'])){
                                                $errSize = $_SESSION['errSize'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errSize.'</div>';
                                                unset($_SESSION['errSize']);
                                            }
                                            if(isset($_SESSION['errFormat'])){
                                                $errFormat = $_SESSION['errFormat'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errFormat.'</div>';
                                                unset($_SESSION['errFormat']);
                                            }
                                        ?>
                                    <small class="red-text">*Format file yang diperbolehkan *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row in form END -->

                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name ="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <button type="reset" onclick="window.history.back();" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
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
?>
