<div class="container-fluid">
    <form action="<?= base_url().'dashboard/spp_update_aksi/'?>" method="post">
    <?php foreach ($spp as $s) { ?>
    <div class="mb-3 mt-5">
    <label for="exampleDataList3" class="form-label">Siswa</label>
    <input type="hidden" name="id_spp" value="<?= $s->id_spp?>">
    <input class="form-control" name="id_siswa" list="datalistOptions" id="exampleDataList3" placeholder="Type to search...">
    <?= form_error('id_siswa','<div class="text-danger small ml-3">','</div>'); ?>
    <datalist id="datalistOptions">
        <?php foreach ($siswa as $sis) : ?>
        <option value="<?= $sis->id_siswa ?>"><?= $sis->id_siswa ?> - <?= $sis->nama ?></option>
        <?php endforeach; ?>
    </datalist>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Jatuh Tempo</label>
        <input type="date" name="jatuh_tempo" value="<?= $s->jatuh_tempo?>" class="form-control" id="exampleFormControlInput1" placeholder="Masukan Tahun">
        <?= form_error('jatuh_tempo','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="label1" class="form-label">Bulan</label>
        <input type="text" name="bulan" value="<?= $s->bulan?>" class="form-control" id="label1" placeholder="Masukan Bulan">
        <?= form_error('bulan','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="label2" class="form-label">No Bayar</label>
        <input type="text" name="no_bayar" value="<?= $s->no_bayar?>" class="form-control" id="label2" placeholder="Masukan Bulan">
        <?= form_error('no_bayar','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="tabel3" class="form-label">Tanggal Bayar</label>
        <input type="date" name="tgl_bayar" value="<?= $s->tgl_bayar?>" class="form-control" id="tabel3" placeholder="Masukan Bulan">
        <?= form_error('tgl_bayar','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="label4" class="form-label">Nominal</label>
        <input type="text" name="nominal" value="<?= $s->nominal?>" class="form-control" id="label4" placeholder="Masukan Nominal">
        <?= form_error('nominal','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <div class="mb-3">
        <label for="ket" class="form-label">Keterangan</label>
        <select name="ket" id="ket" value="<?= $s->ket ?>">
            <option value="">--Keterangan--</option>
            <option value="lunas">Lunas</option>
            <option value="cicilan">cicilan</option>
            <option value="belum_bayar">Belum Bayar</option>
        </select>
        <input type="text" name="ket" value="<?= $s->ket?>" class="form-control" id="ket" placeholder="Masukan Nominal">
        <?= form_error('ket','<div class="text-danger small ml-3">','</div>'); ?>
    </div>
    <button type="submit" class="btn btn-light mt-3 mb-lg-5">Submit</button>
    <?php } ?>
    </form>
</div>