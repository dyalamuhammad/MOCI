<?php
require_once 'element/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- koneksi koneksi ke navbar -->
    <?php include 'element/navbar.php'; ?>
    <!-- [ Header ] start -->
    <?php include 'element/header.php'; ?>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard Analytics</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Absensi QCC</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Monitoring Keaktifan Circle</h5>
                            <span class="d-block m-t-5">Hallo sahabat <code>Berikut data monitoring keaktifan
                                    circle</span>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Circle</th>
                                            <th>Npk Fasilitator</th>
                                            <th>Nama Fasilitator </th>
                                            <th>Npk Tema Leader</th>
                                            <th>Nama Tema Leader</th>
                                            <th>Judul</th>
                                            <th>L1</th>
                                            <th>L2</th>
                                            <th>L3</th>
                                            <th>L4</th>
                                            <th>L5</th>
                                            <th>L6</th>
                                            <th>L7</th>
                                            <th>L8</th>
                                            <th>NQI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $batas = 25;
                                $halaman = (isset($_GET['halaman']))?(int)$_GET['halaman'] : 1;
                                $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
                                $no = $halaman_awal+1;	               
                                $previous = $halaman - 1;
                                $next = $halaman + 1;  
                                $data = mysqli_query($con,"SELECT karyawan.npk AS npk, 

                                karyawan.nama AS nama, 

                                circle_qcc.id_circle AS ci, 
                                circle_qcc.nama_circle AS nc, 
                                circle_qcc.npk_leader AS cl,
                                circle_qcc.id_facilitator AS cf, 
                                circle_qcc.l1 AS c1,
                                circle_qcc.l2 AS c2,
                                circle_qcc.l3 AS c3,
                                circle_qcc.l4 AS c4,
                                circle_qcc.l5 AS c5,
                                circle_qcc.l6 AS c6,
                                circle_qcc.l7 AS c7,
                                circle_qcc.l8 AS c8,
                                circle_qcc.nqi AS cq,
                                
                                register_periode.id_periode AS pp,
                                register_periode.periode AS rp, 
                                facilitator.npk_facilitator AS pf,
                                facilitator.nama_facilitator AS ff,

                                anggota.id_anggota AS ai,
                                anggota.npk_anggota AS an,
                                anggota.id_circle AS ai,
                                anggota.periode AS ap,
                                anggota.l1 AS a1,
                                anggota.l2 AS a2,
                                anggota.l3 AS a3,
                                anggota.l4 AS a4,
                                anggota.l5 AS a5,
                                anggota.l6 AS a6,
                                anggota.l7 AS a7,
                                anggota.l8 AS a8,
                                anggota.nqi AS aq,

                                notulen_qcc.id_notulen AS ni,
                                notulen_qcc.id_circle AS nic,
                                notulen_qcc.id_step AS nis,
                                notulen_qcc.id_periode AS nip,
                                notulen_qcc.judul AS nij,
                                notulen_qcc.notulen AS nin


                                FROM circle_qcc 
                                LEFT JOIN karyawan ON circle_qcc.npk_leader = karyawan.npk
                                LEFT JOIN anggota ON anggota.id_circle = circle_qcc.id_circle
                                LEFT JOIN notulen_qcc ON notulen_qcc.id_circle = circle_qcc.id_circle
                                -- LEFT JOIN circle_qcc ON circle_qcc.npk_leader = karyawan.npk as npk
                                LEFT JOIN facilitator ON facilitator.id_facilitator = circle_qcc.id_facilitator
                                LEFT JOIN register_periode ON register_periode.periode = circle_qcc.periode WHERE circle_qcc.id_circle = '$_GET[id]'GROUP BY circle_qcc.nama_circle ")or die (mysqli_error($con));

                                while ($sc = mysqli_fetch_assoc ($data)){

                                    $qryNotulen = "SELECT notulen_qcc.id_notulen AS ni, 
                                        notulen_qcc.id_circle AS nic,
                                        notulen_qcc.id_step AS nis,
                                        notulen_qcc.id_periode AS nip,
                                        notulen_qcc.judul AS nij,
                                        notulen_qcc.notulen AS nin
                                        FROM notulen_qcc WHERE notulen_qcc.id_circle = '$sc[ci]'   ";
                                    
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $sc['rp'] ?></td>
                                            <td><?= $sc['nc'] ?></td>
                                            <td><?= $sc['pf'] ?></td>
                                            <th><?= $sc['ff'] ?></th>
                                            <td><?= $sc['cl'] ?></td>
                                            <th><?= $sc['nama'] ?></th>
                                            <td><?= $sc['nij'] ?></td>
                                            <?php
                                        for($idx = 1 ; $idx <= 9; $idx++){
                                            $id_step = "langkah ".$idx;
                                            
                                            if($idx == 9 ){
                                                $id_step = "Nqi";
                                            }
                                            $qry_notulen = $qryNotulen." AND notulen_qcc.id_step = '$id_step' ";
    
                                            $datanot = mysqli_query($con,$qry_notulen)or die (mysqli_error($con));
                                            if(mysqli_num_rows($datanot) > 0){
                                                $sql_not = mysqli_fetch_assoc($datanot);
                                                $not = $sql_not['nin'];
                                                $disabled = "";
                                                ?>
                                            <td class="td-actions text-right">
                                                <a <?= $disabled ?> href="assets/images/notulen/<?= $not ?>"
                                                    target ="blank">
                                                    <i class="material-icons">note_add</i>
                                                </a>
                                            </td>

                                            <?php
                                            }else{
                                                $not="#";
                                                $disabled = "disabled";
                                                ?>
                                            <td class="td-actions text-right">
                                                <button <?= $disabled ?> <i class="material-icons">note_add</i>
                                                </button>
                                            </td>

                                            <?php

                                            }

                                           
                                        }

                                        ?>


                                        </tr>
                                        <?php  
                                    }                          
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-body">
                                    <a href ="data_circle.php" type="button" class="btn btn-danger"><i
                                            class="feather mr-2 icon-slash"></i>Batal</a>
                                    <a href = "cetak.php" class="btn btn-primary"><i
                                            class="feather mr-2 icon-thumbs-up"></i>Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- table card-1 start -->
            <!-- Warning Section Ends -->

            <!-- Required Js -->
            <script src="assets/js/vendor-all.min.js"></script>
            <script src="assets/js/plugins/bootstrap.min.js"></script>
            <script src="assets/js/pcoded.min.js"></script>

            <head>
                <!-- Other meta tags and stylesheets -->
                <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


                <!-- Apex Chart -->
                <!-- <script src="assets/js/plugins/apexcharts.min.js"></script> -->


                <!-- custom-chart js -->
                <!-- <script src="assets/js/pages/dashboard-main.js"></script> -->
</body>


</html>
