<div class="container-fluid">
    <form action="<?= base_url().'dashboard/user_insert_aksi/'?>" method="post">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama_user" class="form-control" id="nama" placeholder="Masukan Nama User">
        <?= form_error('nama_user','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput2" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" id="exampleFormControlInput2" placeholder="Masukan Username">
        <?= form_error('username','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput3" class="form-label">Email</label>
        <input type="text" name="email" class="form-control" id="exampleFormControlInput3" placeholder="Masukan Email">
        <?= form_error('email','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput4" class="form-label">Password</label>
        <input type="text" name="password" class="form-control" id="exampleFormControlInput4" placeholder="Masukan Password">
        <?= form_error('password','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <label for="exampleFormControlInput5" class="form-label">Role</label>
    <select name="user_akses" id="exampleFormControlInput5">
        <option value="">--Pilih Role</option>
        <option value="1">Admin</option>
        <option value="2">Siswa</option>
    </select>
    <?= form_error('user_akses','<div class="text-danger small ml-3">','</div>'); ?>
    <label for="exampleFormControlInput6" class="form-label">Status</label>
    <select name="user_status" id="exampleFormControlInput6">
        <option value="">--Pilih User Status</option>
        <option value="1">Aktif</option>
        <option value="2">Nonaktif</option>
    </select>
    <?= form_error('user_akses','<div class="text-danger small ml-3">','</div>'); ?>
    <button type="submit" class="btn btn-light mt-3 mb-lg-5">Submit</button>
    </form>
</div>