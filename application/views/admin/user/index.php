<div class="container-fluid">
    <?= $this->session->flashdata('msg')?>
    <?= anchor('dashboard/user_insert','<button class="btn btn-info btn-sm"><i class="fas fa-plus fa-sm"> Tambah User</i></button>') ?> 
    <table class="table table-bordered table-striped table-hover bg-light table-table-responsive-sm table-sm">
        <tr>
            <th>No</th>
            <th>NAMA</th>
            <th>USERNAME</th>
            <th>EMAIL</th>
            <th>ROLE</th>
            <th>STATUS</th>
            <th colspan="3">AKSI</th>
        </tr>
        <?php
        $no = 1;
        foreach ($user as $u){
            ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $u->nama_user ?></td>
            <td><?= $u->username ?></td>
            <td><?= $u->email ?></td>
            <td><?php if($u->user_akses == 1){
                echo 'Admin';
            }else{
                echo 'Siswa';
            }?></td>
            <td><?php if($u->user_status == 1){
                echo 'Aktif';
            }else{
                echo 'Nonaktif';
            }?></td>
            <td width="20px"><?= anchor('dashboard/user_activate/'.$u->id,'<div class="btn btn-sm btn-primary">
                <i class="fa fa-check"></i></div>') ?></td>
            <td width="20px"><?= anchor('dashboard/user_update/'.$u->id,'<div class="btn btn-sm btn-success">
                <i class="fa fa-edit"></i></div>') ?></td>
            <td width="20px"><?= anchor('dashboard/user_delete/'.$u->id,'<div class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i></div>') ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
