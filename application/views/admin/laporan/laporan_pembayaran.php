<style>
	@media print {
		.no-print{display: none;}
	}
</style>
<div class="container py-4">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<h4 class="text-center">PKBM Budi Utama</h4>
				<small class="text-center">Laporan Pembayaran</small>
				<p class="ml-2">Dari Tanggal : <?= date('d-m-Y', strtotime($mulaiTgl)); ?><br>
					Sampai Tanggal : <?= date('d-m-Y', strtotime($sampaiTgl)); ?>
				</p>
				<table class="table table-bordered text-center">
					<tr>
						<th style="font-size: 10px;">No</th>
						<th style="font-size: 10px;">NIS</th>
						<th style="font-size: 10px;">Siswa</th>
						<th style="font-size: 10px;">Kelas</th>
						<th style="font-size: 10px;">No.Bayar</th>
						<th style="font-size: 10px;">Pembayaran Bulan</th>
						<th style="font-size: 10px;">Jumlah</th>
						<th style="font-size: 10px;">Keterangan</th>
					</tr>
					<?php $total = 0; $no = 1; foreach($bayar as $b) : ?>
						<tr>
							<td style="font-size: 10px;"><?= $no++; ?></td>
							<td style="font-size: 10px;"><?= $b['nis']; ?></td>
							<td style="font-size: 10px;"><?= $b['nama']; ?></td>
							<td style="font-size: 10px;"><?= $b['kelas']; ?></td>
							<td style="font-size: 10px;"><?= $b['no_bayar']; ?></td>
							<td style="font-size: 10px;"><?= $b['bulan']; ?></td>
							<td style="font-size: 10px;"><?= $b['nominal']; ?></td>
							<td style="font-size: 10px;"><?= $b['ket']; ?></td>
						</tr>
						<?php $total += $b['nominal']; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="6"><strong>Total</strong></td>
						<td>Rp.<?= number_format($total, 0, ',', '.'); ?></td>
					</tr>
				</table>
				<div class="row">
					<div class="col-md-2">
						<a href="" onclick="window.print()" class="btn btn-secondary btn-sm no-print"><i class="fas fa-print"></i> Cetak</a>
					</div>
					<div class="col-md-2">
						<a href="<?= base_url('dashboard/laporan_excel/' . $mulaiTgl . '/' . $sampaiTgl); ?>" class="btn btn-success btn-sm no-print" target="_blank"><i class="fas fa-excel"></i> Cetak</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 offset-md-9">
						<table>
							<tr>
								<td></td>
								<td>
									<p>Banyumas, Jawa Tengah <?= date('d-m-Y'); ?><br>
									Operator</p>
									<br><br>
									<p>_______________________</p>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	window.print();
</script>