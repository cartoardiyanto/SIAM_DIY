<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        
         if(isset($_REQUEST['act'])){
                $act = $_REQUEST['act'];
                switch ($act) {
                    case 'add':
                        include "tambah_berkas_khusus.php";
                        break;
                    case 'edit':
                        include "edit_berkas_khusus.php";
                        break;
                    case 'isikhusus':
                        include "isi_berkas_khusus.php";
                        break;
                    case 'del':
                        include "hapus_berkas_khusus.php";
                        break;

                }
            } else {

                $query = mysqli_query($config, "SELECT berkas_khusus FROM tbl_sett");
                list($berkas_khusus) = mysqli_fetch_array($query);

                //pagging
                $limit = $berkas_khusus;
                $pg = @$_GET['pg'];
                if(empty($pg)){
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper green darken-1">
                                    <div class="col m7">
                                        <ul class="left">
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=bks" class="judul"><i class="material-icons">storage</i> Berkas Khusus</a></li>
                                            <li class="waves-effect waves-light">
                                                <a href="?page=bks&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=bks">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" placeholder="Ketik dan tekan enter mencari data..." required>
                                                <label for="search"><i class="material-icons md-dark">search</i></label>
                                                <input type="submit" name="submit" class="hidden">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
                    if(isset($_SESSION['succAdd'])){
                        $succAdd = $_SESSION['succAdd'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succAdd.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succAdd']);
                    }
                    if(isset($_SESSION['succEdit'])){
                        $succEdit = $_SESSION['succEdit'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succEdit.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succEdit']);
                    }
                    if(isset($_SESSION['succDel'])){
                        $succDel = $_SESSION['succDel'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card green lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succDel.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['succDel']);
                    }
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                <?php

                    if(isset($_REQUEST['submit'])){
                    $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
                        echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=bks"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                        <th width="10%"><center>No dentitif<br/>Kode Klasifikasi</center></th>
                                        <th width="10%"><center>Pencipta Arsip<center></th>
                                        <th width="30%"><center>Deskripsi<center></th>
                                        <th width="14%"><center>Kurun Waktu<br/>Tingkat Perkembangan</center></th>
                                        <th width="10%"><center>Jumlah </br>Keterangan Berkas</center></th>
                                        <th width="12%"><center>Lokasi Simpan<br/>Nasib Akhir</center></th>
                                         <th width="18%"><center>Tindakan <span class="right"><i class="maerial-icons" style="color: #333;">settings</i></span><center></th>
                                </tr>
                            </thead>
                            <tbody>';

                            //script untuk mencari data
                            $query = mysqli_query($config, "SELECT * FROM tbl_berkas_khusus WHERE pencipta_arsip LIKE '%$cari%' or deskripsi LIKE '%$cari%' ORDER by no_dentitif DESC LIMIT 15");
                            if(mysqli_num_rows($query) > 0){
                              
                                while($row = mysqli_fetch_array($query)){
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
                                           $tingkat_perkembangan='(Belum ada isi Berkas)'; 
                                        }
                                        

                                    if ($row['keterangan']=="1") {
                                    $keterangannya="Baik";
                                    }
                                    else if ($row['keterangan']=="2") {
                                    $keterangannya="Rapuh";
                                    }
                                    else if ($row['keterangan']=="3") {
                                    $keterangannya= "Menguning";
                                    }
                                    else if ($row['keterangan']=="4") { 
                                   $keterangannya= "Sobek";
                                    }
                                    else if ($row['keterangan']=="5") {
                                   $keterangannya= "Rapuh,Menguning";
                                    }
                                    else if ($$row['keterangan']=="6") {
                                   $keterangannya= "Sobek,Menguning";
                                    }
                                    else  if ($row['keterangan']=="7") {
                                   $keterangannya= "Rapuh,Sobek";
                                    }
                                    else if ($row['keterangan']=="8") {
                                    $keterangannya="Rapuh, menguning, sobek";
                                    }
                                    else if ($row['keterangan']=="9") {
                                    $keterangannya="Rusak";
                                    }
                                 
                                        $pisah=(explode(".",$row['lokasi_simpan']));

                                      echo '
                                      <tr>
                                       <td>'.$row['no_dentitif'].'<br/><hr/>'.$row['kode_klasifikasi'].'</td>
                                        <td>'.$row['pencipta_arsip'].'</td>
                                        <td>'.substr($row['deskripsi'],0,200).'</td>
                                       
                                        <td>'.$row['kurun_waktu'].'<br/><hr/>'.$tingkat_perkembangan.'</td>
                                        <td>'.$hasil.' Item<hr/>'.$keterangannya.' </td>
                                        <td>
                                        Rak &nbsp&nbsp&nbsp: '.$pisah[0].'<br/>Boks &nbsp: '.$pisah[1].'<br/><hr/>'.$row['jangka_simpan'].'        
                                        </td>
                                        <td>';

                                           if($_SESSION['admin'] ==2 ){
                                            echo '
                                                        <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih Isi Berkas untuk menambahkan Isi Berkas Arsip" href="?page=bks&act=isikhusus&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">description</i> Isi Berkas</a>
                                                       ';
                                                 echo '
                                                </td>
                                                </tr>';
                                              
                                            } else {
                                                                            
                                                echo '<a class="btn small blue waves-effect waves-light" href="?page=bks&act=edit&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">edit</i> EDIT</a>
                                                        <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih Isi Berkas untuk menambahkan Isi Berkas Arsip" href="?page=bks&act=isikhusus&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">description</i> Isi Berkas</a>
                                                       

                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=bks&act=del&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">delete</i> HAPUS</a>';
                                                 echo '
                                                </td>
                                                </tr>';
                                            }
                            }
                            } else {
                                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
                            }
                             echo '</tbody></table><br/><br/>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    } else {

                        echo '
                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="10%"><center>No dentitif<br/>Kode Klasifikasi</center></th>
                                        <th width="10%"><center>Pencipta Arsip<center></th>
                                        <th width="30%"><center>Deskripsi<center></th>
                                        <th width="14%"><center>Kurun Waktu<br/>Tingkat Perkembangan</center></th>
                                        <th width="10%"><center>Jumlah </br>Keterangan Berkas</center></th>
                                        <th width="12%"><center>Lokasi Simpan<br/>Nasib Akhir</center></th>
                                        <th width="14%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                                                    $query = mysqli_query($config, "SELECT id_sett,berkas_khusus FROM tbl_sett");
                                                    list($id_sett,$berkas_khusus) = mysqli_fetch_array($query);
                                                    echo '
                                                    <div class="row">
                                                        <form method="post" action="">
                                                            <div class="input-field col s12">
                                                                <input type="hidden" value="'.$id_sett.'" name="id_sett">
                                                                <div class="input-field col s1" style="float: left;">
                                                                    <i class="material-icons prefix md-prefix">looks_one</i>
                                                                </div>
                                                                <div class="input-field col s11 right" style="margin: -5px 0 20px;">
                                                                    <select class="browser-default validate" name="berkas_khusus" required>
                                                                        <option value="'.$berkas_khusus.'">'.$berkas_khusus.'</option>
                                                                        <option value="5">5</option>
                                                                        <option value="10">10</option>
                                                                        <option value="20">20</option>
                                                                        <option value="50">50</option>
                                                                        <option value="100">100</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer white">
                                                                    <button type="submit" class="modal-action waves-effect waves-green btn-flat" name="simpan">Simpan</button>';
                                                                    if(isset($_REQUEST['simpan'])){
                                                                        $id_sett = "1";
                                                                        $berkas_khusus = $_REQUEST['berkas_khusus'];
                                                                        $id_user = $_SESSION['id_user'];

                                                                        $query = mysqli_query($config, "UPDATE tbl_sett SET berkas_khusus='$berkas_khusus',id_user='$id_user' WHERE id_sett='$id_sett'");
                                                                        if($query == true){
                                                                            header("Location: ./admin.php?page=bks");
                                                                            die();
                                                                        }
                                                                    } echo '
                                                                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Batal</a>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    </tr>
                                </thead>
                                <tbody>';

                                //script untuk menampilkan data
                                $query = mysqli_query($config, "SELECT * FROM tbl_berkas_khusus ORDER by no_dentitif DESC LIMIT $curr, $limit");
                                if(mysqli_num_rows($query) > 0){
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)){
                                    
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
                                           $tingkat_perkembangan='(Belum ada isi Berkas)'; 
                                        }
                                        

                                    if ($row['keterangan']=="1") {
                                    $keterangannya="Baik";
                                    }
                                    else if ($row['keterangan']=="2") {
                                    $keterangannya="Rapuh";
                                    }
                                    else if ($row['keterangan']=="3") {
                                    $keterangannya= "Menguning";
                                    }
                                    else if ($row['keterangan']=="4") { 
                                   $keterangannya= "Sobek";
                                    }
                                    else if ($row['keterangan']=="5") {
                                   $keterangannya= "Rapuh,Menguning";
                                    }
                                    else if ($row['keterangan']=="6") {
                                   $keterangannya= "Sobek,Menguning";
                                    }
                                    else  if ($row['keterangan']=="7") {
                                   $keterangannya= "Rapuh,Sobek";
                                    }
                                    else if ($row['keterangan']=="8") {
                                    $keterangannya="Rapuh, menguning, sobek";
                                    }
                                    else if ($row['keterangan']=="9") {
                                    $keterangannya="Rusak";
                                    }
                                 

                                    $pisah=(explode(".",$row['lokasi_simpan']));
                                      echo '
                                      <tr>
                                        <td>'.$row['no_dentitif'].'<br/><hr/>'.$row['kode_klasifikasi'].'</td>
                                        <td>'.$row['pencipta_arsip'].'</td>
                                        <td>'.substr($row['deskripsi'],0,200).'</td>
                                       
                                        <td>'.$row['kurun_waktu'].'<br/><hr/>'.$tingkat_perkembangan.'</td>
                                        <td>'.$hasil.' Item<hr/>'.$keterangannya.' </td>
                                        <td>
                                        Rak &nbsp&nbsp&nbsp: '.$pisah[0].'<br/>Boks &nbsp: '.$pisah[1].'<br/><hr/>'.$row['jangka_simpan'].'        
                                        </td>
                                        <td>';

                                        if($_SESSION['admin'] ==2 ){
                                            echo '
                                                        <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih Isi Berkas untuk menambahkan Isi Berkas Arsip" href="?page=bks&act=isikhusus&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">description</i> Isi Berkas</a>
                                                       ';
                                                 echo '
                                                </td>
                                                </tr>';
                                              
                                            } else {
                                                                            
                                                echo '<a class="btn small blue waves-effect waves-light" href="?page=bks&act=edit&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">edit</i> EDIT</a>
                                                        <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih Isi Berkas untuk menambahkan Isi Berkas Arsip" href="?page=bks&act=isikhusus&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">description</i> Isi Berkas</a>
                                                       

                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=bks&act=del&no_dentitif='.$row['no_dentitif'].'">
                                                            <i class="material-icons">delete</i> HAPUS</a>';
                                                 echo '
                                                </td>
                                                </tr>';
                                            }
                                }
                            } else {
                                echo '<tr><td colspan="7"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=bks&act=add">Tambah data baru</a></u></p></center></td></tr>';
                            }
                          echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_berkas_khusus");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=bks&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=bks&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg) echo '<li class="active waves-effect waves-dark"><a href="?page=bks&pg='.$i.'"> '.$i.' </a></li>';
                                else echo '<li class="waves-effect waves-dark"><a href="?page=bks&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=bks&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=bks&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">last_page</i></a></li>';
                        }
                        echo '
                        </ul>';
                    } else {
                        echo '';
                    }
                }
            }
        
    }
?>
