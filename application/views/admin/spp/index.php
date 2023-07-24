<div class="container-fluid">
    <?= $this->session->flashdata('msg')?>
    <table class="table table-bordered table-striped table-hover bg-light table-table-responsive-lg table-sm">
        <tr>
            <th style="font-size: 12px">No</th>
            <th style="font-size: 12px">NAMA SISWA</th>
            <th style="font-size: 12px">JATUH TEMPO</th>
            <th style="font-size: 12px">BULAN</th>
            <th style="font-size: 12px">NO BAYAR</th>
            <th style="font-size: 12px">TANGGAL BAYAR</th>
            <th style="font-size: 12px">NOMINAL</th>
            <th style="font-size: 12px">KETERANGAN</th>
            <th style="font-size: 12px" colspan="2">AKSI</th>
        </tr>
        <?php
        $no = 1;
        foreach ($spp as $s){
            ?>
        <tr>
            <td style="font-size: 12px"><?= $no++ ?></td>
            <td style="font-size: 12px"><?= $s->nama ?></td>
            <td style="font-size: 12px"><?= $s->jatuh_tempo ?></td>
            <td style="font-size: 12px"><?= $s->bulan ?></td>
            <td style="font-size: 12px"><?= $s->no_bayar ?></td>
            <td style="font-size: 12px"><?= $s->tgl_bayar ?></td>
            <td style="font-size: 12px"><?= $s->nominal ?></td>
            <td style="font-size: 12px"><?= $s->ket ?></td>
            <td style="font-size: 12px" width="20px"><?= anchor('dashboard/spp_update/'.$s->id_spp,'<div class="btn btn-sm btn-success">
                <i class="fa fa-edit"></i></div>') ?></td>
            <td style="font-size: 12px" width="20px"><?= anchor('dashboard/spp_delete/'.$s->id_spp,'<div class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i></div>') ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
