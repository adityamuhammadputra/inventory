<div class="card">
    <div class="card-header">
        Form Input
        <a class="card-header-down float-right">
            <span data-feather="chevron-down"></span>
        </a>
    </div>
    <div class="card-body card-add"
        style="display: none;"
        >
        <div class="row">
            <div class="col-md-3">
                <img src="/img/vendor.png" class="img img-reponsive" style="width: 100%">
            </div>

            <div class="col-md-9 pt-4">
                <form method="POST" action="/api/v1/jasa?model={{ $data->model }}" class="form form-horizontal" id="form-submit">
                    @csrf
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="kode" name="kode" class="form-control" placeholder="Kode Vendor" value="" required>
                            <label id="kode-has-value" class="error kode-has-value" for="kode" style="display: none;"></label>
                            <label for="kode">Kode Vendor</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Vendor" value="" required>
                            <label for="nama">Nama vendor</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="number" id="kontak" name="kontak" class="form-control" placeholder="Nama Vendor" required>
                            <label for="kontak">Kontak</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="harga" name="harga" class="form-control rupiah" placeholder="Harga Vendor" required>
                            <label for="harga">Harga Vendor</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <textarea id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan Vendor" required></textarea>
                            <label for="keterangan">Keterangan</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <button class="btn btn-primary btn-square float-right mt-4" id="submit"><span class="fa fa-check-circle"></span> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
