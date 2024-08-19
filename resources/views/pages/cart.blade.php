@extends('layouts.app')

@section('title')
Cart
@endsection

@section('content')
<div class="container" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
    </nav>
    @if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session()->has('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle-fill"></i> {{ session('danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
</div>

<div class="container" data-aos="fade-down">
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Berat</th>
                        <th scope="col">Ukuran</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Bahan</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @php $sub_total = 0 @endphp 

                    @forelse($carts as $cart)
                      <tr>
                        <td>
                            <a href="/detail/{{$cart->product->slug}}"> 
                                <img src="{{ asset('storage/'.$cart->product->galleries->first()->photo) }}" style="width: 100px; height:100px" alt="">
                            </a>
                        </td>
                        <td class="cart-detail">{{ $cart->product->name }}</td>
                        <td class="cart-detail">@currency($cart->product->price)</td>
                        <td class="cart-detail">{{ $cart->product->weight }} gr</td>
                        @if($cart->clothing_size != null)
                        <td class="cart-detail">{{ $cart->clothing_size->size_name }}</td>
                        @else 
                        <td class="cart-detail">{{ $cart->accessories_size->size_name }}</td>
                        @endif
                        <td class="cart-detail">
                            <div class="row">
                                <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf 
                                    <button type="submit" name="kurang" value="1" class="btn-cart"><i class="bi bi-dash-circle"></i></button>
                                    <span class="px-2">{{$cart->quantity}}</span>
                                    <button type="submit" name="tambah" value="1" class="btn-cart"><i class="bi bi-plus-circle"></i></button>
                                </form>
                            </div>
                            <div>
                                @if($cart->clothing_size != null)
                                <small class="text-dark">sisa stok {{$cart->clothing_size->stock->stock}}</small> 
                                @else
                                <small class="text-dark">sisa stok {{$cart->accessories_size->stock->stock}}</small>
                                @endif
                            </div>
                        </td>
                        <td class="cart-detail">{{$cart->material}}</td>
                        <td class="cart-detail">@currency($cart->product->price * $cart->quantity)</td>
                        <td class="cart-detail">
                            <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin hapus cart?')">Hapus</button>
                            </form>
                        </td> 
                      </tr>

                    @php $sub_total += ($cart->product->price * $cart->quantity) @endphp

                    @empty
                    <tr><td colspan="8" class="text-center text-danger">Cart kosong</td></tr>
                    @endforelse
                    
                </tbody>
            </table> 
        </div>
    </div>

    <hr>

    <h6>Detail Pengiriman <span class="text-secondary">(Dikirim dari Kabupaten Bogor)</span></h6>
 
    <form action="{{ route('transaction.store') }}" method="POST" id="locations"  enctype="multipart/form-data">
        @csrf
        <!-- input type hidden digunakan untuk mengambil value sub_total -->
        <input type="hidden" name="sub_total" value="{{ $sub_total }}">
        <div class="mt-3" id="locations">
            <div class="row">
                    <div class="col-lg-12">
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="province_destination_id">Provinsi Tujuan</label>
                                    <select name="province_destination_id" id="province_destination_id" class="form-control" v-if="provinces_destination" v-model="province_destination_id" required>
                                        <option v-for="province in provinces_destination" :value="province.province_id">@{{ province.province }}</option>
                                    </select>
                                    <select v-else class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="city_destination_id">Kota/Kabupaten Tujuan</label>
                                    <select name="city_destination_id" id="city_destination_id" class="form-control" v-if="cities_destination" v-model="city_destination_id" required>
                                        <option v-for="city in cities_destination" v-bind:value="city.postal_code" :value="city.city_id">@{{ city.type }} @{{ city.city_name }}</option>
                                    </select>
                                    <select v-else class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="address">Alamat Lengkap</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="postal_code">Kode Pos</label>
                                    <input type="number" class="form-control" id="postal_code" name="postal_code" required>
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="mobile">Nomor Handphone</label>
                                    <input type="number" class="form-control" id="mobile" name="mobile" value="{{ auth()->user()->phone_number }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="weight">Total Berat (gram)</label>
                                    <input type="number" class="form-control" id="weight" name="weight" v-model="weight" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="courier">Kurir</label>
                                        <select class="form-control" name="courier" v-model="courier" required>
                                            <option value="jne">JNE</option>
                                            <option value="pos">POS</option>
                                            <option value="tiki">TIKI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                <label for="ongkir">Biaya Ongkir</label>
                                    <select name="ongkir" id="ongkir" class="form-control"  @click="getCostOngkir" v-model="ongkir" required>
                                        <option v-if="ongkirList" v-for="ongkir in ongkirList" :value="ongkir.cost[0].value">
                                            @{{ ongkir.service }} - Rp. @{{ Number(ongkir.cost[0].value).toLocaleString("id-ID") }} (@{{ ongkir.cost[0].etd }} hari)
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <hr>

        <div class="mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <h5 class="text-dark">@currency($sub_total)</h5>
                            <p class="text-muted">Sub Total</p>
                        </div>
                        <div class="col-lg-3">
                            <h5 class="text-dark" v-bind:value="ongkir">Rp. @{{ Number(ongkir).toLocaleString("id-ID") }}</h5>
                            <p class="text-muted">Biaya Ongkir</p>
                        </div>
                        <div class="col-lg-3">
                            <!-- input type hidden digunakan untuk mengambil value grand_total -->
                            <input type="hidden" name="grand_total" v-bind:value="subTotal + ongkir">
                            <h5 class="text-success">Rp. @{{ Number(subTotal + ongkir).toLocaleString("id-ID") }}</h5>
                            <p class="text-muted">Total Keseluruhan</p>
                        </div>
                        <div class="col-lg-3">
                            @if(count($carts) > 0)
                            <button type="submit" class="btn  btn-block btn-success px-4 py-3" onclick="return confirm('Apakah anda yakin ingin checkout?')">Checkout</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<!-- Axios adalah libary AJAX -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script> 
<script>
    var locations = new Vue({
        el: "#locations", 
        mounted() {
            AOS.init();
            this.getProvincesData();
        },
        data: {
            provinces_destination: null,
            cities_destination: null,
            city_origin_id: 78, 
            province_destination_id: null,
            city_destination_id: null,
            weight: {{ $weightTotal }},
            courier: null,
            ongkirList: null,
            ongkir: null,
            subTotal: {{ $sub_total }},
        },
        methods: {
           getProvincesData(){
            var self = this;
                axios.get('api/provinces') 
                    .then(function(response){
                        self.provinces_destination = response.data;
                    })
           },
           getCityDestinationData(){
            var self = this;
                axios.get('api/cities/' + self.province_destination_id)
                    .then(function(response){
                        self.cities_destination = response.data;
                    })
           },
           getCostOngkir(){
            var self = this;
            axios.post('api/checkOngkir/', {
                origin: self.city_origin_id,
                destination: self.city_destination_id,
                weight: self.weight,
                courier: self.courier
                }) 
                .then(function (response) {
                    self.ongkirList = response.data.data[0].costs
                }).catch(error => {
                    this.response = 'Error: ' + error.response.status
                })
           },
        },
        watch: {
            province_destination_id: function(val, oldVal){
                this.city_destination_id = null;
                this.getCityDestinationData();
                this.ongkir = null; 
            },
            city_destination_id: function(val, oldVal){
                this.ongkirList = null;                
                this.ongkir = null;                
            },
            courier: function(val, oldVal){
                this.ongkir = null;
                this.ongkirList = null;
                this.getCostOngkir();
            }
        },
    });
</script>
@endpush