<main role="main" class="ml-sm-auto px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-lg-10">
      <?= $this->session->flashdata('pesan'); ?>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="alert alert-info" role="alert"><i class="fas fa-info"></i> Masukan NIS / NAMA anda untuk melihat DATA spp.</div>
          <?= form_open(''); ?>
          <div class="input-group mb-3">
          <input class="form-control" name="nis" list="datalistOptions" id="exampleDataList3" placeholder="MASUKAN NIS / NAMA SISWA">
            <?= form_error('nis','<div class="text-danger small ml-3">','</div>'); ?>
          <datalist id="datalistOptions">
          <?php foreach ($siswas as $sis) : ?>
            <option value="<?= $sis->nis ?>"><?= $sis->nis ?> - <?= $sis->nama ?></option>
          <?php endforeach; ?>
          </datalist>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </div>
          <small class="muted text-danger"><?= form_error('nis'); ?></small>
          <?= form_close(); ?>
        </div>
      </div>

      <?php if($this->input->post('nis')) : ?>
      <!-- Biodata Siswa -->
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h4 class="text-center">Biodata Siswa</h4>
          <table class="table">
            <tr>
              <th>NIS</th>
              <td>:</td>
              <td><?= $siswa['nis']; ?></td>
            </tr>
            <tr>
              <th>Nama Siswa</th>
              <td>:</td>
              <td><?= $siswa['nama']; ?></td>
            </tr>
            <tr>
              <th>Kelas</th>
              <td>:</td>
              <td><?= $siswa['kelas']; ?></td>
            </tr>
            <tr>
              <th>Tahun Ajaran</th>
              <td>:</td>
              <td><?= $siswa['tahun_ajaran']; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /Biodata Siswa -->

      
      <!-- Spp Siswa -->
      <div class="row">
        <div class="col-md">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="font-size: 12px;">No</th>
                <td style="font-size: 12px;">Bulan</th>
                <td style="font-size: 12px;">Jatuh Tempo</th>
                <td style="font-size: 12px;">No Bayar</th>
                <td style="font-size: 12px;">Tanggal Bayar</th>
                <td style="font-size: 12px;">Jumlah</th>
                <td style="font-size: 12px;">Keterangan</th>
              </tr>
              <?php $no = 1; foreach($spp as $s) : ?>
                 <tr>
                   <td style="font-size: 12px;"><?= $no++; ?></td>
                   <td style="font-size: 12px;"><?= $s['bulan']; ?></td>
                   <td style="font-size: 12px;"><?= $s['jatuh_tempo']; ?></td>
                   <td style="font-size: 12px;"><?= $s['no_bayar']; ?></td>
                   <td style="font-size: 12px;"><?= $s['tgl_bayar']; ?></td>
                   <td style="font-size: 12px;"><?= $s['nominal']; ?></td>
                   <td style="font-size: 12px;"><?= $s['ket']; ?></td>
                   <td>
                 </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
      <!-- /Spp Siswa -->
      <?php endif; ?>

    </div>
  </div>
</main>