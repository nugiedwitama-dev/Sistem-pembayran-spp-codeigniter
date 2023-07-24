<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
      <?php if(validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>
      <?= $this->session->flashdata('pesan'); ?>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md">
          
          <?= form_open('dashboard/ubahDataWali'); ?>
          <?php foreach ($guruWali as $GW):
            ?>
              <input type="hidden" name="id_kelas" id="id_kelas" value="<?= $GW->id_kelas; ?>">
            <?php endforeach ?>
          <div class="form-group">
            <label for="kelas">Kelas</label>
            <?php foreach ($guruWali as $G):
            ?>
            <input type="text" name="kelas" id="kelas" class="form-control" value="<?= $G->kelas; ?>" readonly>
            <?php endforeach ?>
            <small class="muted text-danger"><?= form_error('kelas'); ?></small>
          </div>
          <div class="form-group">
            <label for="nama">Nama Guru</label>
            <select name="nama" id="nama" class="form-control">
              <option value="">-- Pilih Guru --</option>
              <?php foreach($guru as $g) : ?>
                <?php if($g['id_guru'] == $guruWali['id_guru']) : ?>
                <option value="<?= $g['id_guru']; ?>" selected><?= $g['nama_guru']; ?></option>
                <?php else : ?>
                  <option value="<?= $g['id_guru']; ?>"><?= $g['nama_guru']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
            <small class="muted text-danger"><?= form_error('nama'); ?></small>
          </div>
          <div class="form-group">
            <a href="<?= base_url('dashboard/wali'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
            <button type="submit" class="btn btn-dark">Ubah</button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    </div>
  </div>
</div>