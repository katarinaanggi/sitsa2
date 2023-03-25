<section class="section container-p-y container-xxl">
  <h3>Lihat Semua Produk dari Merek {{ $title }}</h3>
  <div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach ($products as $product)
      <div class="col">
        <div class="card h-100">
          <img src="{{ $product->pic_path }}" class="card-img-top"/>
          <div class="card-body">
            <h5 class="card-title">{{ $product->nama }}</h5>
            <p class="card-text">Rp{{ number_format($product->harga,0, ',' , '.') }}</p>
            <p class="card-text">Stok : {{ $product->stok }} pcs</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>    
</section>