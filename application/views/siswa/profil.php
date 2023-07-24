<h2 class="mt-5 mb-3">Profile</h2>
    <?php foreach ($profile as $p){
            ?>
           <p>
               Username : <?= $p->username ?>
           </p>
           <p>
               Email : <?= $p->email ?>
           </p> 
           <p>
               Nama : <?= $p->nama_user ?>
           </p>
           <p>
            Role : <?php if($p->user_akses == 1){
                echo 'Admin';
            }else{
                echo 'Siswa';
            }?>
           </p>
    <?php } ?>
