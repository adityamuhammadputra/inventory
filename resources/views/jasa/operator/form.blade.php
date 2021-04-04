<div class="card">
    <div class="card-header">
        Form Input
        <a class="card-header-down float-right">
            <span data-feather="chevron-down"></span>
        </a>
    </div>
    <div class="card-body card-add"
        {{-- style="display: none;" --}}
        >
        <div class="row">
            <div class="col-md-3">
                <img src="/img/operator.jpg" class="img img-reponsive" style="width: 100%">
            </div>

            <div class="col-md-9 pt-4">
                <form method="POST" action="/api/v1/jasa?model={{ $data->model }}" class="form form-horizontal" id="form-submit">
                    @csrf
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <select name="vendor_id" id="vendor_id" class="form-control" required>
                                @foreach ($data->vendor as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            <label for="vendor_id">--Pilih Vendor--</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="kode" name="kode" class="form-control" placeholder="KodeOperator" value="" required>
                            <label id="kode-has-value" class="error kode-has-value" for="kode" style="display: none;"></label>
                            <label for="kode">Kode Petugas</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Operator" required>
                            <label for="nama">Nama Petugas</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="harga" name="harga" class="form-control rupiah" placeholder="Harga Operator" required>
                            <label for="harga">Harga Petugas</label>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <textarea id="tugas" name="tugas" class="form-control" placeholder="Tugas Operator" required></textarea>
                            <label for="tugas">Tugas</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <button type="submit" class="btn btn-primary btn-square float-right mt-4" id="submit"><span class="fa fa-check-circle"></span> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
