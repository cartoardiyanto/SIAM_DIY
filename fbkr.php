<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
         $no_dentitifi =$_REQUEST['no_dentitif'];
        $no_itemi = mysqli_real_escape_string($config, $_REQUEST['no_item']);
       
        $query = mysqli_query($config, "SELECT * FROM tbl_isi_berkas_koresponden WHERE no_itemi='$no_itemi' AND no_dentitifi = '$no_dentitifi'");
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

                echo '
                    <div class="row jarak-form">
                        <ul class="collapsible white" data-collapsible="accordion">
                        <i class="material-icons md-prefix md-36 right white-text">expand_more</i>
                            <li><div class="collapsible-header green white-text">
                               <span class="add" >Tampilkan detail File Isi Berkas</span></div>
                                    <div class="collapsible-body white">
                                        <div class="col m12 white">
                                            <table>
                                                <tbody>
                                                <tr>
                                                        <td width="13%">No Dentitif</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['no_dentitifi'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">No Item</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['no_itemi'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Kode Klasifikasi</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['kode_klasifikasi'].'</td>
                                                    </tr>
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
                                                        <td width="13%">Kurun Waktu</br>Keterangan</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['kurun_waktui'].'</br>'.$tingkat_perkembangan.'</br>'.$row['jumlahi'].' Lembar</br>'.$keterangannya.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Lokasi Simpan</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['lokasi_simpani'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="13%">Jangka Simpan Dan Nilai Akhir</td>
                                                        <td width="1%">:</td>
                                                        <td width="86%">'.$row['jangka_simpani'].'</td
                                                    </tr>
                                              
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                       
                        <button onclick="window.history.back()" class="btn-large blue waves-effect waves-light left"><i class="material-icons">arrow_back</i> KEMBALI</button> 
                        ';

                        
                        if(empty($row['file'])){
                            echo '';
                        } else {

                            $ekstensi = array('jpg','png','jpeg');
                            $ekstensi2 = array('doc','docx');
                            $file = $row['file'];
                            $x = explode('.', $file);
                            $eks = strtolower(end($x));

                            if(in_array($eks, $ekstensi) == true){
                                echo '<img class="gbr" data-caption="'.date('d M Y', strtotime($row['tgl_diterima'])).'" src="./upload/berkas_koresponden/'.$row['file'].'"/>';
                            } else {

                                if(in_array($eks, $ekstensi2) == true){
                                    echo '
                                    <div class="gbr">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="col s9 left">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <p>File lampiran isi berkas ini bertipe <strong>document</strong>, silakan klik link dibawah ini untuk melihat file lampiran tersebut.</p>
                                                        </div>
                                                        <div class="card-action">
                                                            <strong>Lihat file :</strong> <a class="blue-text" href="./upload/berkas_koresponden/'.$row['file'].'" target="_blank">'.$row['file'].'</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col s3 right">
                                                    <img class="file" src="./asset/img/word.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="gbr">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="col s9 left">
                                                    <div class="card">
                                                        <div class="card-content">
                                                            <p>File lampiran isi berkas ini bertipe <strong>PDF</strong>, silakan klik link dibawah ini untuk melihat file lampiran tersebut.</p>
                                                        </div>
                                                        <div class="card-action">
                                                            <strong>Lihat file :</strong> <a class="blue-text" href="./upload/berkas_koresponden/'.$row['file'].'" target="_blank">'.$row['file'].'</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col s3 right">
                                                    <img class="file" src="./asset/img/pdf.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                        } echo '
                    </div>';
            }
        }
    }

?>