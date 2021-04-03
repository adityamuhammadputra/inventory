<div class="card">
    <div class="card-header">Form Input</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3" id="wrap-barcode">
                <img src="/img/barcode/IP001.svg" id="barcode" class="img img-reponsive" style="width: 100%">
            </div>
            <div class="col-md-8 offset-md-1">
                <form method="POST" action="" class="form form-horizontal">
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="kode" name="kode" class="form-control" placeholder="Email address" required="" value="IP001">
                            <label for="kode">Kode Barang</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="jenis" name="jenis" class="form-control" placeholder="Email address" required="">
                            <label for="jenis">Jenis Barang</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="merk" name="merk" class="form-control" placeholder="Email address" required="">
                            <label for="merk">Merk Barang</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="type" name="type" class="form-control" placeholder="Email address" required="">
                            <label for="type">Type Barang</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="serial_number" name="serial_number" class="form-control" placeholder="Email address" required="">
                            <label for="serial_number">Serial Number</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="number" id="harga" name="harga" class="form-control" placeholder="Email address" required="">
                            <label for="harga">Harga Barang</label>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-square float-right" id="submit"><span class="fa fa-check-circle"></span> Save</button>
                </form>
            </div>

        </div>

    </div>
</div>
