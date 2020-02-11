<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {



        if(isset($_REQUEST['sub'])){
            $sub = $_REQUEST['sub'];
            switch ($sub) {
                case 'add':
                    include "tambah_isi_bkr.php";
                    break;
                case 'edit':
                    include "edit_isi_bkr.php";
                    break;
                case 'del':
                    include "hapus_isi_bkr.php";
                    break;
            }
        } else {

$no_dentitif = $_REQUEST['no_dentitif'];
                $query = mysqli_query($config, "SELECT * FROM tbl_berkas_koresponden WHERE no_dentitif='$no_dentitif'");
              
                 $query = mysqli_query($config, "SELECT isi_berkas_khusus FROM tbl_sett");
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

                <?php 

              
                echo ' <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper green darken-1">
                                    <div class="col m7">
                                        <ul class="left">
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="#" class="judul"><i class="material-icons">description</i> Isi Berkas Korespondensi</a></li>
                                        <li class="waves-effect waves-light"><a href="?page=bkr&act=isikoresponden&no_dentitif='.$no_dentitif.'&sub=add"><i class="material-icons md-24">add_circle</i> Tambah Isi Berkas</a></li>
                                        <li class="waves-effect waves-light hide-on-small-only"><a href="?page=bkr  "><i class="material-icons">arrow_back</i> Kembali</a></li>
                                    </ul>
                                    </div>
                                    
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=bkr&act=isikhusus&no_dentitif='.$no_dentitif.'">
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
                </div>';
          
 
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
                      $query = mysqli_query($config, "SELECT * FROM tbl_berkas_koresponden WHERE no_dentitif='$no_dentitif'");

                if(mysqli_num_rows($query) > 0){
            
                    while($row = mysqli_fetch_array($query)){

                    if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 3 AND $_SESSION['admin'] != 2){
                        echo '<script language="javascript">
                                window.alert("ERROR! Anda tidak memiliki hak akses untuk melihat data ini");
                                window.location.href="./admin.php?page=bkr  ";
                              </script>';
                    } else {

                      echo '

                            <!-- Perihal START -->
                            <div class="col s12">
                                <div class="card green lighten-1">
                                    <div class="card-content">
                                        <p><p class="description"><strong>Isi dari Berkas </strong></br><p>No Dentitif: '.$row['no_dentitif'].'
                                            </br>'.$row['deskripsi'].'
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Perihal END -->';
                }}}
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
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"'.stripslashes($cari).'"</strong><span class="right"><a href="?page=bkr    &act=isikhusus&no_dentitif='.$no_dentitif.'"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                        <th width="10%"><center>No Item<br/>Kode Klasifikasi</center></th>
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
                           $query = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden WHERE no_dentitifi ='$no_dentitif' and (pencipta_arsipi LIKE '%$cari%' or deskripsii LIKE '%$cari%') ORDER by no_itemi DESC LIMIT 15");

                                        if(mysqli_num_rows($query) > 0){
                                           
                                            while($row = mysqli_fetch_array($query)){
                                          
                                           if ($row['keterangani']=="1") {
                                            $keterangannya="Baik";
                                            }
                                            else if ($row['keterangani']=="2") {
                                            $keterangannya="Rapuh";
                                            }
                                            else if ($row['keterangani']=="3") {
                                            $keterangannya= "Menguning";
                                            }
                                            else if ($row['keterangani']=="4") { 
                                           $keterangannya= "Sobek";
                                            }
                                            else if ($row['keterangani']=="5") {
                                           $keterangannya= "Rapuh,Menguning";
                                            }
                                            else if ($$row['keterangani']=="6") {
                                           $keterangannya= "Sobek,Menguning";
                                            }
                                            else  if ($row['keterangani']=="7") {
                                           $keterangannya= "Rapuh,Sobek";
                                            }
                                            else if ($row['keterangani']=="8") {
                                            $keterangannya="Rapuh, menguning, sobek";
                                            }
                                            else if ($row['keterangani']=="9") {
                                            $keterangannya="Rusak";
                                            }

                                            if($row['tingkat_perkembangani']="1"){
                                                $tingkat_perkembangan="Asli";
                                            }
                                            else{
                                                $tingkat_perkembangan="Salinan";
                                            }


                                             
                                             $pisah=(explode(".",$row['lokasi_simpani']));

                                             echo '
                                                <tr>
                                                    <td>'.$row['no_itemi'].'<br/><hr/>'.$row['kode_klasifikasi'].'</td>
                                        <td>'.$row['pencipta_arsipi'].'</td>
                                        <td>'.substr($row['deskripsii'],0,200).'<br/><br/><strong>File :</strong>';

                                        if(!empty($row['file'])){
                                            echo ' <strong><a href="?page=fbkr  &act=fsm&no_item='.$row['no_itemi'].'&no_dentitif='.$no_dentitif.'">'.$row['file'].'</a></strong>';
                                        } else {
                                            echo '<em>Tidak ada file yang di upload</em>';
                                        } echo '</td>
                                       
                                                <td>'.$row['kurun_waktui'].'<br/><hr/>'.$tingkat_perkembangan.'</td>
                                                <td>'.$row['jumlahi'].' Lembar<br/><hr/>'.$keterangannya.'</td> 
                                                <td>Rak &nbsp&nbsp&nbsp: '.$pisah[0].'<br/>Boks &nbsp: '.$pisah[1].'<br/><hr/>'.$row['jangka_simpani'].'
                                                </td>';
                                              if($_SESSION['admin'] ==2 ){
                                                       echo'<td>
                                                      <button class="btn small blue-grey waves-effect waves-light"><i class="material-icons">error</i> No Action</button><td></tr>';
                                                    } 
                                                else{
                                                     echo'
                                                    <td><a class="btn small blue waves-effect waves-light" href="?page=bkr  &act=isikhusus&no_dentitif='.$no_dentitif.'&sub=edit&no_item='.$row['no_itemi'].'">
                                                            <i class="material-icons">edit</i> EDIT</a>
                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=bkr   &act=isikhusus&no_dentitif='.$no_dentitif.'&sub=del&no_item='.$row['no_itemi'].'"><i class="material-icons">delete</i> HAPUS</a>
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
                                        <th width="10%"><center>No Item<br/>Kode Klasifikasi</center></th>
                                        <th width="10%"><center>Pencipta Arsip<center></th>
                                        <th width="30%"><center>Deskripsi<center></th>
                                        <th width="14%"><center>Kurun Waktu<br/>Tingkat Perkembangan</center></th>
                                        <th width="10%"><center>Jumlah </br>Keterangan Berkas</center></th>
                                        <th width="12%"><center>Lokasi Simpan<br/>Nasib Akhir</center></th>
                                        <th width="14%">Tindakan <span class="right tooltipped" data-position="left" data-tooltip="Atur jumlah data yang ditampilkan"><a class="modal-trigger" href="#modal"><i class="material-icons" style="color: #333;">settings</i></a></span></th>

                                            <div id="modal" class="modal">
                                                <div class="modal-content white">
                                                    <h5>Jumlah data yang ditampilkan per halaman</h5>';
                                                    $query = mysqli_query($config, "SELECT id_sett,isi_berkas_khusus FROM tbl_sett");
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
                                                                            header("Location: ./admin.php?page=bkr  &act=isikhusus&no_dentitif=$no_dentitif");
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
                                
                             
                                $query2 = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden WHERE no_dentitifi =  '$no_dentitif' ORDER by no_itemi DESC LIMIT $curr, $limit");

                                        if(mysqli_num_rows($query2) > 0){
                                           
                                            while($row = mysqli_fetch_array($query2)){
                                          
                                           if ($row['keterangani']=="1") {
                                    $keterangannya="Baik";
                                    }
                                    else if ($row['keterangani']=="2") {
                                    $keterangannya="Rapuh";
                                    }
                                    else if ($row['keterangani']=="3") {
                                    $keterangannya= "Menguning";
                                    }
                                    else if ($row['keterangani']=="4") { 
                                   $keterangannya= "Sobek";
                                    }
                                    else if ($row['keterangani']=="5") {
                                   $keterangannya= "Rapuh,Menguning";
                                    }
                                    else if ($$row['keterangani']=="6") {
                                   $keterangannya= "Sobek,Menguning";
                                    }
                                    else  if ($row['keterangani']=="7") {
                                   $keterangannya= "Rapuh,Sobek";
                                    }
                                    else if ($row['keterangani']=="8") {
                                    $keterangannya="Rapuh, menguning, sobek";
                                    }
                                    else if ($row['keterangani']=="9") {
                                    $keterangannya="Rusak";
                                    }

                                            if($row['tingkat_perkembangani']="1"){
                                                $tingkat_perkembangan="Asli";
                                            }
                                            else{
                                                $tingkat_perkembangan="Salinan";
                                            }


                                             
                                             $pisah=(explode(".",$row['lokasi_simpani']));

                                             echo '
                                                <tr>
                                                    <td>'.$row['no_itemi'].'<br/><hr/>'.$row['kode_klasifikasi'].'</td>
                                        <td>'.$row['pencipta_arsipi'].'</td>
                                        <td>'.substr($row['deskripsii'],0,200).'<br/><br/><strong>File :</strong>';

                                        if(!empty($row['file'])){
                                            echo ' <strong><a href="?page=fbkr  &act=fsm&no_item='.$row['no_itemi'].'&no_dentitif='.$no_dentitif.'">'.$row['file'].'</a></strong>';
                                        } else {
                                            echo '<em>Tidak ada file yang di upload</em>';
                                        } echo '</td>
                                       
                                                <td>'.$row['kurun_waktui'].'<br/><hr/>'.$tingkat_perkembangan.'</td>
                                                <td>'.$row['jumlahi'].' Lembar<br/><hr/>'.$keterangannya.'</td> 
                                                <td>Rak &nbsp&nbsp&nbsp: '.$pisah[0].'<br/>Boks &nbsp: '.$pisah[1].'<br/><hr/>'.$row['jangka_simpani'].'
                                                </td>';
                                              if($_SESSION['admin'] ==2 ){
                                                       echo'<td>
                                                      <button class="btn small blue-grey waves-effect waves-light"><i class="material-icons">error</i> No Action</button><td></tr>';
                                                    } 
                                                else{
                                                     echo'
                                                    <td><a class="btn small blue waves-effect waves-light" href="?page=bkr  &act=isikhusus&no_dentitif='.$no_dentitif.'&sub=edit&no_item='.$row['no_itemi'].'">
                                                            <i class="material-icons">edit</i> EDIT</a>
                                                        <a class="btn small deep-orange waves-effect waves-light" href="?page=bkr   &act=isikhusus&no_dentitif='.$no_dentitif.'&sub=del&no_item='.$row['no_itemi'].'"><i class="material-icons">delete</i> HAPUS</a>
                                                    </td>
                                                     </tr>';
                                            }
                                }
                            } else {
                                echo '<tr><td colspan="7"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=bkr    &act=add">Tambah data baru</a></u></p></center></td></tr>';
                            }
                          echo '</tbody></table>
                        </div>
                    </div>
                    <!-- Row form END -->';

                    $query = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden WHERE no_dentitifi='$no_dentitif'");
                    $cdata = mysqli_num_rows($query);
                    $cpg = ceil($cdata/$limit);

                    echo '<br/><!-- Pagination START -->
                          <ul class="pagination">';

                    if($cdata > $limit ){

                        //first and previous pagging
                        if($pg > 1){
                            $prev = $pg - 1;
                            echo '<li><a href="?page=bkr    &act=isikhusus&no_dentitif='.$no_dentitif.'&pg=1"><i class="material-icons md-48">first_page</i></a></li>
                                  <li><a href="?page=bkr    &act=isikhusus&no_dentitif='.$no_dentitif.'&pg='.$prev.'"><i class="material-icons md-48">chevron_left</i></a></li>';
                        } else {
                            echo '<li class="disabled"><a href="#"><i class="material-icons md-48">first_page</i></a></li>
                                  <li class="disabled"><a href="#"><i class="material-icons md-48">chevron_left</i></a></li>';
                        }

                        //perulangan pagging
                        for ($i = 1; $i <= $cpg; $i++) {
                            if ((($i >= $pg - 3) && ($i <= $pg + 3)) || ($i == 1) || ($i == $cpg)) {
                                if ($i == $pg) echo '<li class="active waves-effect waves-dark"><a href="?page=bkr  &act=isikhusus&no_dentitif='.$no_dentitif.'&pg='.$i.'"> '.$i.' </a></li>';
                                else echo '<li class="waves-effect waves-dark"><a href="?page=bkr   &act=isikhusus&no_dentitif='.$no_dentitif.'&pg='.$i.'"> '.$i.' </a></li>';
                            }
                        }

                        //last and next pagging
                        if($pg < $cpg){
                            $next = $pg + 1;
                            echo '<li><a href="?page=bkr    &act=isikhusus&no_dentitif='.$no_dentitif.'&pg='.$next.'"><i class="material-icons md-48">chevron_right</i></a></li>
                                  <li><a href="?page=bkr    &act=isikhusus&no_dentitif='.$no_dentitif.'&pg='.$cpg.'"><i class="material-icons md-48">last_page</i></a></li>';
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
