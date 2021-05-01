<div class="card">
    <div class="card-header">
        Form Input
        <a class="card-header-down float-right">
            <span data-feather="chevron-down"></span>
        </a>
    </div>
    <div class="card-body card-form"
        style="display: none;"
        >
        <div class="row">
            <div class="col-md-3" id="wrap-barcode">
                <img src="/img/temp_barcode.PNG" id="barcode" class="img img-reponsive" style="width: 100%">
                <p id="label-barcode" class="text-center">{{ $data->maxKode }}</p>
            </div>
            <div class="col-md-8 offset-md-1 pt-1">
                <form method="POST" action="/api/v1/barang" class="form form-horizontal" id="form-submit">
                    @csrf
                    @method('POST')
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="kode" name="kode" class="form-control" placeholder="Kode Barang" value="{{ $data->maxKode }}" required>
                            <label id="kode-has-value" class="error kode-has-value" for="kode" style="display: none;"></label>
                            <label for="kode">Item Code </label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="jenis" name="jenis" class="form-control" placeholder="Jenis Barang" required>
                            <label for="jenis">Item Kind</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="merk" name="merk" class="form-control" placeholder="Merk Barang" required>
                            <label for="merk">Item Brand</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="type" name="type" class="form-control" placeholder="Type Barang" required>
                            <label for="type">Item Type</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="serial_number" name="serial_number" class="form-control" placeholder="Serial Number" required>
                            <label for="serial_number">Serial Number</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="harga" name="harga" class="form-control rupiah" placeholder="Harga Barang" required>
                            <label for="harga">Item Price</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-square float-right" id="submit"><span class="fa fa-check-circle"></span> Save</button>
                    <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel" data-max-kode="true" data-action="/api/v1/barang"> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
