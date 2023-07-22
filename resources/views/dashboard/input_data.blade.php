<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ $sub }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active">{{ $sub }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card mb-3">
                    <div class="card-header">Input Data</div>
                    <div class="card-body">
                        @include('layouts.alert')
                        <form action="/dashboard/input_data" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="barang" class="form-label">Barang</label>
                                <select name="barang" id="barang" class="form-control">
                                    @php
                                        $query = DB::SELECT("SELECT * FROM barang order by id DESC");
                                    @endphp
                                    @foreach($query as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <select name="lokasi" id="lokasi" class="form-control">
                                    @php
                                        $query = DB::SELECT("SELECT * FROM lokasi order by id DESC");
                                    @endphp
                                    @foreach($query as $data)
                                    <option value="{{ $data->kode_lokasi }}">{{ $data->nama_lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_transaksi" class="form-label">No Transaksi</label>
                                <input maxlength="15" type="text" name="no_transaksi" id="no_transaksi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Riwayat</div>
                    <div class="card-body">
                        @php
                            $kurir_id = DB::TABLE("kurir")->where("name", session()->get('username'))->value("id");
                            $count = DB::TABLE("pengiriman")->where("kurir_id", $kurir_id)->count();
                        @endphp
                        @if($count == 0)
                        <p class="text-center">Tidak ada data.</p>
                        @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No Pengiriman</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $query = DB::SELECT("SELECT * FROM pengiriman where kurir_id = '$kurir_id' ORDER by id DESC");
                                    @endphp
                                    @foreach($query as $data)
                                    @php    
                                        $lokasi = DB::TABLE("lokasi")->where("kode_lokasi", $data->lokasi_id)->value("nama_lokasi");
                                        $barang = DB::TABLE("barang")->where("kode_barang", $data->barang_id)->value("nama_barang");
                                    @endphp
                                    <tr>
                                        <td>{{ $data->id }}</td>
                                        <td>{{ $data->no_pengiriman }}</td>
                                        <td>{{ $data->tanggal }}</td>
                                        <td>{{ $lokasi }}</td>
                                        <td>{{ $barang }}</td> 
                                        <td>{{ $data->jumlah_barang }}</td>
                                        <td>Rp. {{ number_format($data->harga_barang,0,',','.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>

            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    @include('partials.script')
</body>

</html>
