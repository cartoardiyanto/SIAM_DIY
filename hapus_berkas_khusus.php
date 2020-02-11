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

    	$no_dentitif = mysqli_real_escape_string($config,$_REQUEST['no_dentitif']);
        $query = mysqli_query($config, "SELECT * FROM tbl_berkas_khusus WHERE no_dentitif='$no_dentitif'");
    	if(mysqli_num_rows($query) > 0){
            $no = 1;
            while($row = mysqli_fetch_array($query)){

            if($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['admin'] == 2){
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak memiliki hak akses untuk menghapus data ini");
                        window.location.href="./admin.php?page=bks";
                      </script>';
            } else {
                                    
                                    $keterangani=$row['keterangan'];
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
                                    $no_dentitif=$row['no_dentitif'];
                                    $q= mysqli_query($config, "SELECT * FROM tbl_isi_berkas_khusus WHERE no_dentitifi ='$no_dentitif'");
                                    $hasil=mysqli_num_rows($q);
                                  if($hasil>0){
                                        while($apa = mysqli_fetch_array($q)){
                                        if($apa['tingkat_perkembangani']==1){
                                                $x=1;
                                        }

                                        if($apa['tingkat_perkembangani']==2){
                                                $y=1;
                                        }
                                    }
                                    }
                                    else
                                    {
                                         $y=0;
                                          $x=0;
                                    }
                                   
                                    
                                        if($x=='1'){
                                            $tingkat_perkembangan='Asli';
                                        }
                                        else if($y=='1'){
                                            $tingkat_perkembangan='Salinan';
                                        }
                                        else if($x=='1' AND $y=='1'){
                                            $tingkat_perkembangan='Asli Dan Salinan';
                                        }else{
                                           $tingkat_perkembangan='(isi Berkas Belum ada)'; 
                                        }
                                 
    		  echo '
                <!-- Row form Start -->
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
				                    <td width="13%">No Dentitif</td>
				                    <td width="1%">:</td>
				                    <td width="86%">'.$row['no_dentitif'].'</td>
				                </tr>
				                <tr>
				                    <td width="13%">Kode Klasifikasi</td>
				                    <td width="1%">:</td>
				                    <td width="86%">'.$row['kode_klasifikasi'].'</td>
				                </tr>
                                <td width="13%">Pencipta Arsip</td>
                                <td width="1%">:</td>
                                <td width="86%">'.$row['pencipta_arsip'].'</td>
                                </tr>
    			                <tr>
    		                    <td width="13%">Deskripsi</td>
    		                    <td width="1%">:</td>
    		                    <td width="86%">'.$row['deskripsi'].'</td>
    			                </tr>
    			                <tr>
    			                    <td width="13%">Kurun Waktu dan Keterangan</td>
    			                    <td width="1%">:</td>
    			                    <td width="86%">'.$row['kurun_waktu'].'</br>'.$tingkat_perkembangan.'</br>'.$hasil.' item </br> '.$keterangannya.'</td>
    			                </tr>
    			                <tr>
    			                    <td width="13%">Lokasi Simpan</br>Jangka Simpan dan Nasib Akhir</td>
    			                    <td width="1%">:</td>
    			                    <td width="86%">'.$row['lokasi_simpan'].'</br>'.$row['jangka_simpan'].'</td>
    			                </tr>
    			             
    			            </tbody>
    			   		</table>
                        </div>
                        <div class="card-action">
        	                <a href="?page=bks&act=del&submit=yes&no_dentitif='.$row['no_dentitif'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        	                <a href="?page=bks" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
    	                </div>
    	            </div>
                </div>
            </div>
            <!-- Row form END -->';

            	if(isset($_REQUEST['submit'])){
            		$no_dentitif = $_REQUEST['no_dentitif'];
                    //jika ada file akan mengekseskusi script dibawah ini
                   

                        //jika tidak ada file akan mengekseskusi script dibawah ini
                        $query = mysqli_query($config, "DELETE FROM tbl_berkas_khusus WHERE no_dentitif='$no_dentitif'");
                        $query3 = mysqli_query($config, "SELECT *FROM tbl_isi_berkas_khusus WHERE no_dentitifi='$no_dentitif'");
                        while($row = mysqli_fetch_array($query3)){
                          

                            $no_itemi=$row['no_itemi'];
                        if(!empty($row['file'])){

                        unlink("upload/berkas_khusus/".$row['file']);
                        $query = mysqli_query($config, "DELETE FROM tbl_isi_berkas_khusus WHERE no_dentitifi='$no_dentitif' and no_itemi=' $no_itemi'");

                        
                         } else {

                        //jika tidak ada file akan mengekseskusi script dibawah ini
                        $query2 = mysqli_query($config, "DELETE FROM tbl_isi_berkas_khusus WHERE no_dentitifi='$no_dentitif' and no_itemi='$no_itemi'");
                        }
                        
                        }
                     
                        if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                            header("Location: ./admin.php?page=bks");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=bks&act=del&no_dentitif='.$no_dentitif.'";
                                  </script>';
                        }
                    
                }
    	    }
            }
        }
   } 
}
?>
