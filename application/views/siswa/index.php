<br>
<br>

<p>Selamat Datang <strong><?= $username ?></strong> di Sistem Pembayaran SPP PKBM Budi Utama,  <br> Anda Login Sebagai <Strong>
<?php if($role == 2)
    { 
        echo "Siswa";
    }else{ 
    echo "Admin"; }
     ?></strong></p>

<?= anchor('home/histori','<button class="btn btn-success mx-2 btn-sm"><i class="fas fa-eye"> Lihat Histori Pembayaran</i></button>') ?>
<?= anchor('home/data_spp','<button class="btn btn-danger mx-2 btn-sm"><i class="fas fa-eye"> Lihat Data Tunggakan</i></button>') ?>