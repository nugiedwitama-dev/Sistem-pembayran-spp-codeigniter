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
				<table class="table table-bordered text-center">
					<tr>
						<th style="font-size: 10px">No</th>
						<th style="font-size: 10px">NIS</th>
						<th style="font-size: 10px">Siswa</th>
						<th style="font-size: 10px">Kelas</th>
						<th style="font-size: 10px">Tagihan Bulan</th>
						<th style="font-size: 10px">Jumlah Tagihan</th>
						<th style="font-size: 10px">Keterangan</th>
					</tr>
					<?php $total = 0; $no = 1; foreach($tunggakan as $b) : ?>
						<tr>
							<td style="font-size: 10px"><?= $no++; ?></td>
							<td style="font-size: 10px"><?= $b['nis']; ?></td>
							<td style="font-size: 10px"><?= $b['nama']; ?></td>
							<td style="font-size: 10px"><?= $b['kelas']; ?></td>
							<td style="font-size: 10px"><?= $b['bulan']; ?></td>
							<td style="font-size: 10px"><?= $b['nominal']; ?></td>
							<td style="font-size: 10px">Belum Bayar</td>
						</tr>
						<?php $total += $b['nominal']; ?>
					<?php endforeach; ?>
					<tr>
						<td colspan="5"><strong>Total</strong></td>
						<td colspan="2">Rp.<?= number_format($total, 0, ',', '.'); ?></td>
					</tr>
				</table>
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