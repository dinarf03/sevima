
<?php
session_start();
include "../config/koneksi.php";

echo '<div class="grup">
<div class="kiri">
 <div class="top-heading">

<h4>Daftar Ujian</h4></div> <br>';

//Cek jumlah ujian pada tanggal sekarang
$tgl = date('Y-m-d');
$qujian = mysqli_query($mysqli, "SELECT * FROM ujian t1, kelas_ujian t2 WHERE t1.tanggal='$tgl' AND t1.id_ujian=t2.id_ujian AND t2.id_kelas='$_SESSION[kelas]' AND t2.aktif='Y'");
$tujian = mysqli_num_rows($qujian);
$rujian = mysqli_fetch_array($qujian);

//Jika tidak ada ujian aktif tampilkan pesan
if($tujian < 1){
   echo '
   <div class="alert alert-info">Belum ada ujian Pada Tanggal Sekarang Untuk Kelas Kamu. Jika ada kesalahan hubungi Operator! perbaiki tanggal ujian atau kelas ujian</div>';
}

//Jika ada dua atau lebih ujian aktif tampilkan pada tabel
else{
   echo '<div class="table-responsive">
          <table class="table table-striped" id="data">
            <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Pelajaran</th>
              <th>Jenis Ujian</th>
              <th>Aksi</th>
            </tr>
            </thead>
          <tbody>';

    $qujian = mysqli_query($mysqli, "SELECT * FROM kelas_ujian
      INNER JOIN tb_master_kelas ON kelas_ujian.id_kelas=tb_master_kelas.id_kelas
      INNER JOIN tb_master_jurusan ON kelas_ujian.id_jurusan=tb_master_jurusan.id_jurusan
      INNER JOIN ujian ON kelas_ujian.id_ujian=ujian.id_ujian
      INNER JOIN tb_master_mapel ON ujian.id_mapel=tb_master_mapel.id_mapel

    WHERE ujian.tanggal='$tgl' AND ujian.id_ujian=kelas_ujian.id_ujian AND kelas_ujian.id_kelas='$_SESSION[kelas]' AND kelas_ujian.id_jurusan='$_SESSION[jurusan]' AND kelas_ujian.aktif='Y'
    ");
   $no = 1;
   while($r = mysqli_fetch_array($qujian)){

      $kelas_ujian = array();
      $qkelas_ujian = mysqli_query($mysqli, "SELECT * FROM tb_master_kelas t1, kelas_ujian t2

       WHERE  t1.id_kelas=t2.id_kelas AND t2.id_ujian='$r[id_ujian]'");
      while($rku = mysqli_fetch_array($qkelas_ujian)){
         $kelas_ujian[] = $rku['kelas'];
      }

    echo'
    <tr>
    <td><b>'.$no.'</b></td>
    <td><b>'.$r['judul'].'</b></td>
    <td><b>'.$r['mapel'].'</b></td>
    ';
       $jenis = mysqli_query($mysqli, "SELECT * FROM tb_jenisujian WHERE id_jenis='$r[id_jenis]'");
       $ju = mysqli_fetch_array($jenis);
       echo '<td><b>'.$ju['jenis_ujian'].'</b></td>';


    //Jika nilai sudah ada tampilkan tombol Sudah Mengerjakan, jika belum ada tampilkan tombol Kerjakan
    $qnilai = mysqli_query($mysqli, "SELECT * FROM nilai WHERE id_ujian='$r[id_ujian]' AND id_siswa='$_SESSION[id_siswa]' ");
    $tnilai = mysqli_num_rows($qnilai);
    $rnilai = mysqli_fetch_array($qnilai);

    if($tnilai>0 and $rnilai['nilai'] != "")
    echo '<td bgcolor= bordercolordark="#00FF33" >
    <a onclick="show_nilai('.$r['id_ujian'].')"  class="btn btn-block"><i class="fa fa-search"></i> Lihat Nilai</a>';

    elseif($tnilai>0 and $rnilai['sisa_waktu'] != "")
    echo '<td bgcolor="#FF3300">
    <a onclick="show_ujian('.$r['id_ujian'].')"  class="btn btn-block"><i class="fa fa-check-circle-o"></i> Lanjutkan</a>';

    else echo '<td bgcolor="#FFFF00">
    <a onclick="show_detail('.$r['id_ujian'].')" class="btn btn-block"><i class="fa fa-edit"></i> Kerjakan</a>';
    echo '</td>
    </tr>';

    $no++;
    }

    echo '</tbody>
    </table>
    </div>';
}
?>
<br>

  <!-- INFORMASI MENGENAI MATERI terpost -->
    <?php
    $no=1;
    $sqlmtr = mysqli_query($mysqli,"SELECT * FROM tb_materi

      INNER JOIN tb_roleguru ON tb_materi.id_roleguru=tb_roleguru.id_roleguru

    INNER JOIN tb_master_mapel ON tb_roleguru.id_mapel=tb_master_mapel.id_mapel

    INNER JOIN tb_master_semester ON tb_roleguru.id_semester=tb_master_semester.id_semester

   WHERE tb_roleguru.id_kelas='$_SESSION[kelas]' AND tb_roleguru.id_jurusan='$_SESSION[jurusan]' AND public='Y' AND tb_materi.tgl_entry='$tgl' ORDER BY tb_materi.id_materi DESC LIMIT 5 ");
    $jml = mysqli_num_rows($sqlmtr);
  foreach ($sqlmtr as $row) { ?>
  <div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Baru!</strong> Materi <b><?=$row['mapel'] ?> </b> Untuk kelas kamu ! <a href="?page=materi&act=mapel&ID=<?=$row['id_mapel']; ?>&mp=<?=$row['mapel']; ?>">Lihat</a>
  </div>
  <?php
   }
   ?>

<?php


   echo '</div> ';
   ?>
    <div class="card">
         <!-- <div class="card-body wrap" style="margin-left:20px;background-color:#F5F5F5;border-radius:20px; overflow: scroll;height: 600px;">
        <h4><b><i class="fa fa-wechat text-success"></i></b> <b class="text-success">Chat</b> Box</h4>
      <center> -->
<!-- <a href="https://api.whatsapp.com/send?phone=628127577440&text=Halo%20Admin,%20Saya%20mau%20daftar%20jadi%20agenpos%20mohon%20petunjuk%20lebih%20lanjut....."><img src="https://1.bp.blogspot.com/-d9e_wOY69MY/WRM3fYv--rI/AAAAAAAAIDM/aMGRV5d2yTcdEy7KT4kOY6Ok1IZPWvDqQCLcB/s200/Cara%2BMudah%2BMembuat%2BLink%2BWhatsapp%2BLangsung%2BChat%2Bdi%2BWebsite%2B-%2Blogo.png" style="width: 30px;" / /></a> --></center>

        <!-- <hr>s -->




      </div>
    </div>
   <?php
   echo'</div>';
?>
