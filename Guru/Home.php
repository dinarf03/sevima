<?php
// jumlah mapel yang diampu
$mapel = mysqli_num_rows(mysqli_query($con,"SELECT id_mapel FROM tb_roleguru WHERE id_guru='$sesi' "));
// perangkat
$perangkat = mysqli_num_rows(mysqli_query($con,"SELECT id_tugas FROM tb_tugas WHERE id_guru='$sesi' "));

// materi
$materi = mysqli_num_rows(mysqli_query($con,"SELECT id_materi FROM tb_materi
  INNER JOIN tb_roleguru ON tb_materi.id_roleguru=tb_roleguru.id_roleguru
  WHERE tb_roleguru.id_guru='$sesi' "));
// ujian
$objektif = mysqli_num_rows(mysqli_query($con,"SELECT id_ujian FROM ujian WHERE id_guru='$sesi' "));
$essay = mysqli_num_rows(mysqli_query($con,"SELECT id_ujianessay FROM ujian_essay WHERE id_guru='$sesi' "));
$ujian = $objektif+$essay;
?>

<div class="content-wrapper">
  <h3>
    <!-- <img class="menu-icon" src="../vendor/images/menu_icons/01.png" width="20"> -->
    <b>Dashboard</b>
    <small class="text-muted">Guru</small>
  </h3>
  <hr>
  <div class="row">
    <div class="col-md-9 col-xs-12">
      <div class="row">
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 grid-margin stretch-card">
          <div class="card card-statistics" style="background-color: #00BCD4;border-radius: 10px;">
            <div class="card-body">
              <div class="clearfix">
                <div class="float-left">
                  <i class="fa fa-globe icon-lg"></i>
                </div>
                <div class="float-right">
                  <p class="card-text text-right font-weight-bold">Jumlah Pelajaran></p>
                  <div class="fluid-container">
                    <h3 class="card-title font-weight-bold text-center mb-0"><?=$mapel; ?></h3>
                  </div>
                </div>
              </div>
              <hr>
              <a href="?page=mapel" class="text-white"><i class="fa fa-chevron-circle-right text-white" aria-hidden="true"></i> Views</a>
            </div>
          </div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 grid-margin stretch-card">
          <div class="card card-statistics" style="background-color: #9C27B0;border-radius: 10px;">
            <div class="card-body">
              <div class="clearfix">
                <div class="float-left">
                  <i class="fa fa-file-text-o icon-lg text-white"></i>
                </div>
                <div class="float-right">
                  <p class="card-text text-right font-weight-bold text-white">Jumlah Tugas</p>
                  <div class="fluid-container">
                    <h3 class="card-title font-weight-bold text-center mb-0 text-white"><?=$perangkat; ?></h3>
                  </div>
                </div>
              </div>
              <hr>
              <a href="?page=tugas&act=view" class="text-white"><i class="fa fa-chevron-circle-right text-white" aria-hidden="true"></i> Views</a>
            </div>
          </div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 grid-margin stretch-card">
          <div class="card card-statistics" style="background-color: #FF5722;border-radius: 10px;">
            <div class="card-body">
              <div class="clearfix">
                <div class="float-left">
                  <i class="fa fa-file-text-o icon-lg text-white"></i>
                </div>
                <div class="float-right">
                  <p class="card-text text-right font-weight-bold text-white">Jumlah Materi</p>
                  <div class="fluid-container">
                    <h3 class="card-title font-weight-bold text-center mb-0 text-white"><?=$materi; ?></h3>
                  </div>
                </div>
              </div>
              <hr>
              <a href="?page=materi" class="text-white"><i class="fa fa-chevron-circle-right text-white" aria-hidden="true"></i> Views</a>
            </div>
          </div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 grid-margin stretch-card">
          <div class="card card-statistics" style="background-color: #212121;border-radius: 10px;">
            <div class="card-body">
              <div class="clearfix">
                <div class="float-left">
                  <i class="fa fa-pencil icon-lg text-white"></i>
                </div>
                <div class="float-right">
                  <p class="card-text text-right font-weight-bold text-white">Jumlah Ujian</p>
                  <div class="fluid-container">
                    <h3 class="card-title font-weight-bold text-center mb-0 text-white"><?=$ujian; ?></h3>
                  </div>
                </div>
              </div>
              <hr>
              <a href="?page=ujian" class="text-white"><i class="fa fa-chevron-circle-right text-white" aria-hidden="true"></i> Views</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
