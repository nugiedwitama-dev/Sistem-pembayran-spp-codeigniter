<div class="card p-2 shadow-sm border-bottom-primary">
    <div class="card-header bg-white">
        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
            <?= $user['nama_user']; ?>
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 mb-4 mb-md-0">
                <img src="<?= base_url('dist') ?>assets/img/avatar/<?= $user['foto'] ?>" alt="" class="img-thumbnail rounded mb-2">
                <a href="<?= base_url('dashboard/setting'); ?>" class="btn btn-sm btn-block btn-primary"><i class="fa fa-edit"></i> Edit Profile</a>
                <a href="<?= base_url('dashboard/ubahpassword'); ?>" class="btn btn-sm btn-block btn-primary"><i class="fa fa-lock"></i> Ubah Password</a>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <tr>
                        <th width="200">Username</th>
                        <td><?= $user['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $user['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td class="text-capitalize">
                            <?php if($user['user_akses'] == 1) {
                                echo 'Admin';
                            } else{
                                echo 'Siswa';
                            }
                            ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>