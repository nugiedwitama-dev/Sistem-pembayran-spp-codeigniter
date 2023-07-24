
  
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Pembayaran SPP</p>
                    <h5 class="font-weight-bolder mt-2">

                        Rp <?= $total ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Pengguna Aktif</p>
                    <h5 class="font-weight-bolder mt-2">
                      <?php echo $pengguna ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Siswa Aktif</p>
                    <h5 class="font-weight-bolder mt-2">
                      <?php echo $jumlah_siswa ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Grafik Pembayaran SPP</h6>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
        <div class="card ">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">5 Pembayaran Terakhir</h6>
              </div>
            </div>
            <div class="table-responsive">
        <table class="table align-items-center ">
        <tr>
            <th>No</th>
            <th>NAMA SISWA</th>
            <th>TANGGAL BAYAR</th>
            <th>JUMLAH BAYAR</th>
            <th>STATUS</th>
        </tr>
        <?php
        $no = 1;
        foreach ($transaksi as $p){
            ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $p->nama ?></td>
            <td><?= $p->tgl_bayar ?></td>
            <td><?= $p->nominal ?></td>>
            <td><?= $p->ket ?></td>
           
        </tr>
        <?php } ?>
    </table>

            </div>
          </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card ">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">SPP Cicilan</h6>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center ">
        <tr>
            <th>No</th>
            <th>NAMA SISWA</th>
            <th>TANGGAL BAYAR</th>
            <th>JUMLAH BAYAR</th>
            <th>TUNGGAKAN</th>
            <th>STATUS</th>
        </tr>
        <?php
        $no = 1;
        foreach ($nunggak as $n){
            ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $n->nama ?></td>
            <td><?= $n->tgl_bayar ?></td>
            <td><?= $n->nominal ?></td>
            <td><?= $n->nominal*50/100 ?></td>
            <td><?= $n->ket ?></td>
           
        </tr>
        <?php } ?>
    </table>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">SPP Belum Bayar</h6>
            </div>
            <div class="card-body p-3">
            <div class="table-responsive">
              <table class="table align-items-center ">
        <tr>
            <th>No</th>
            <th>NAMA SISWA</th>
            <th>TANGGAL BAYAR</th>
            <th>JUMLAH BAYAR</th>
            <th>TUNGGAKAN</th>
            <th>STATUS</th>
        </tr>
        <?php
        $no = 1;
        foreach ($galbay as $g){
            ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $g->nama ?></td>
            <td><?= $g->tgl_bayar ?></td>
            <td><?= $g->nominal ?></td>
            <td><?= $g->nominal ?></td>
            <td><?= $g->ket ?></td>
           
        </tr>
        <?php } ?>
    </table>
              </table>
            </div>
            </div>
          </div>
        </div>
      </div>
