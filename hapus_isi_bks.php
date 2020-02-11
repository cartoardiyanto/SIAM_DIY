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
                        window.location.href="./logout.php
                      </script>';
            } 
        else{
        if(isset($_SESSION['errQ'])){
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row jarak-card">
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

    	$no_itemi  = mysqli_real_escape_string($config, $_REQUEST['no_item']);

    	$query = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_khusus WHERE no_itemi='$no_itemi'");
        $no_dentitif = $_REQUEST['no_dentitif'];

    	if(mysqli_num_rows($query) > 0){
            $no = 1;
            while($row = mysqli_fetch_array($query)){

                                    $keterangani=$row['keterangani'];
                                    if ($keterangani==1) {
                                    $keterangannya="Baik";
                                    }
                                    else if ($keterangani==2) {
                                    $keterangannya="Rapuh";
                                    }
                                    else if ($keterangani==3) {
                                    $keterangannya= "Menguning";
                                    }
                                    else if ($keterangani==4) { 
                                   $keterangannya= "Sobek";
                                    }
                                    else if ($keterangani==5) {
                                   $keterangannya= "Rapuh,Menguning";
                                    }
                                    else if ($keterangani==6) {
                                   $keterangannya= "Sobek,Menguning";
                                    }
                                    else  if ($keterangani==7) {
                                   $keterangannya= "Rapuh,Sobek";
                                    }
                                    else if ($keterangani==8) {
                                    $keterangannya="Rapuh, menguning, sobek";
                                    }
                                    else if ($keterangani==9) {
                                    $keterangannya="Rusak";
                                    }
                                    

                                    $tingkat_perkembangan = $row['tingkat_perkembangani'];
                                    if ($tingkat_perkembangan=="1") {
                                        $tp="Asli";
                                    }
                                    else if($tingkat_perkembangan=="2"){
                                        $tp="Salinan";
                                    }

    		  echo '<!-- Row form Start -->
    				<div class="row jarak-card">
    				    <div class="col m12">
                            <div class="card">
                                <div class="card-content">
            				        <table>
            				            <thead class="red lighten-5 red-text">
            				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
            				                Apakah Anda yakin akan menghapus data ini?</div>
            				            </thead>

            				            <tbody>
            				                <tr>
            				                    <td width="13%">No Item</br>Kode Klasifikasi</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['no_itemi'].'</br>'.$row['kode_klasifikasi'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Pencipta Arsip</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['pencipta_arsipi'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Deskripsi</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['deskripsii'].'</td>
            				                </tr>
            				                <tr>
            				                    <td width="13%">Keterangan</br>Dan Kurun Waktu</td>
            				                    <td width="1%">:</td>
            				                    <td width="86%">'.$row['kurun_waktui'].'</br>'.$tp.'</br>'.$row['jumlahi'].' lembar</br> '.$keterangannya.'</td>
            				                </tr>
                                            <tr>
                                                <td width="13%">lokasi Simpan</td>
                                                <td width="1%">:</td>
                                                <td width="86%">'.$row['lokasi_simpani'].'</td>
                                            </tr>
                                             <tr>
                                            <td width="13%">File</td>
                                            <td width="1%">:</td>
                                            <td width="86%">';
                                            if(!empty($row['file'])){
                                                echo ' <a class="blue-text" href="?page=gsk&act=fsk&no_itemi='.$row['no_itemi'].'">'.$row['file'].'</a>';
                                            } else {
                                                echo ' Tidak ada file yang diupload';
                                            } echo '</td>
                                        </tr>
                                          <tr>
                                                <td width="13%">Jangka Simpan dan Nilai Akhir</td>
                                                <td width="1%">:</td>
                                                <td width="86%">'.$row['jangka_simpani'].'</td>
                                            </tr>
            				            </tbody>
            				   		</table>
        				        </div>
                                <div class="card-action">

        		                     <a href="?page=bks&act=isikhusus&no_dentitif='.$no_dentitif.'&sub=del&submit=yes&no_item='.$row['no_itemi'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
                                     
        		                    <a href="?page=bks&act=isikhusus&no_dentitif='.$no_dentitif.'" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    	if(isset($_REQUEST['submit'])){
                    		$no_item = $_REQUEST['no_item'];
                            $no_dentitif = $_REQUEST['no_dentitif'];

                        //jika ada file akan mengekseskusi script dibawah ini
                        if(!empty($row['file'])){
                            
                            unlink("upload/berkas_khusus/".$row['file']);
                            $query = mysqli_query($config, "DELETE FROM tbl_isi_berkas_khusus WHERE no_itemi ='$no_item'");

                             if($query == true){
                                $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=bks&act=isikhusus&no_dentitif='.$no_dentitif.'";
                                      </script>';
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=bks&act=isikhusus&no_dentitif='.$no_dentitif.'&sub=del&no_item='.$no_item.'";
                                      </script>';
                            }
                        } else {

                            //jika tidak ada file akan mengekseskusi script dibawah ini
                            $query = mysqli_query($config, "DELETE FROM tbl_isi_berkas_khusus WHERE no_itemi='$no_item'");

                            if($query == true){
                                $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus ';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=bks&act=isikhusus&no_dentitif='.$no_dentitif.'";
                                      </script>';
                            } else {
                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                echo '<script language="javascript">
                                        window.location.href="./admin.php?page=bks&act=isikhusus&no_dentitif='.$no_dentitif.'&sub=del&no_item='.$no_item.'";
                                      </script>';
                            }
                        }
                	


                	}
    		    }
    	    }
        }
    }
?>
