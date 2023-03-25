<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order_Detail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Income::factory(100)->create();
        Expense::factory(100)->create();
        // \App\Models\User::factory(10)->create();

        Category::create([
            "nama" => "Skin Care",
            "gambar" => "J1.jpeg",
            "pic_path" => "/uploads/categories/J1.jpeg"
        ]);
        Category::create([
            "nama" => "Make Up",
            "gambar" => "J2.jpeg",
            "pic_path" => "/uploads/categories/J2.jpeg"
        ]);
        Category::create([
            "nama" => "Body Care",
            "gambar" => "T1.jpeg",
            "pic_path" => "/uploads/categories/T1.jpeg"
        ]);
        Category::create([
            "nama" => "Hair Care",
            "gambar" => "T2.jpeg",
            "pic_path" => "/uploads/categories/T2.jpeg"
        ]);
        Category::create([
            "nama" => "Lainnya",
            "gambar" => "T3.jpeg",
            "pic_path" => "/uploads/categories/T3.jpeg"
        ]);

        Brand::create([
            "nama" => "Avoskin",
            "gambar" => "avoskin.png",
            "pic_path" => "/uploads/brands/avoskin.png"
        ]);
        Brand::create([
            "nama" => "ESQA",
            "gambar" => "esqa.png",
            "pic_path" => "/uploads/brands/esqa.png"
        ]);
        Brand::create([
            "nama" => "L'OREAL",
            "gambar" => "loreal.jpeg",
            "pic_path" => "/uploads/brands/loreal.jpeg"
        ]);
        Brand::create([
            "nama" => "Maybelline",
            "gambar" => "maybelline.jpeg",
            "pic_path" => "/uploads/brands/maybelline.jpeg"
        ]);
        Brand::create([
            "nama" => "Somethinc",
            "gambar" => "somethinc.jpeg",
            "pic_path" => "/uploads/brands/somethinc.jpeg"
        ]);
        Brand::create([
            "nama" => "The Body Shop",
            "gambar" => "tbs.jpeg",
            "pic_path" => "/uploads/brands/tbs.jpeg"
        ]);

        Product::create([
            "nama" => "Your Skin Bae Alpha Arbutin 3% + Grapeseed",
            "category_id" => 1,
            "brand_id" => 1,
            "gambar" => "product-1.jpg",
            "pic_path" => "/uploads/products/product-1.jpg",
            "harga" => 139000,
            "stok" => 100,
            "deskripsi" => "Your Skin Bae Alpha Arbutin 3% + Grapeseed Serum	

            Salah satu best seller serum Avoskin dari Your Skin Bae series yang memadukan active ingredient Alpha Arbutin 3% dan ekstrak natural Grapeseed untuk mencerahkan kulit, memudarkan noda bekas jerawat kehitaman (PIH), dan mengurangi tampilan pori-pori. Alpha Arbutin merupakan brightening agent yang paling efektif dan aman untuk kulit. Sedangkan Grapeseed mengandung antioksidan untuk menjaga sel kulit tetap kencang dan sehat.
            
            Dapat digunakan untuk semua jenis kulit dan bisa dipakai untuk usia mulai dari 15 tahun.
            
            Cara Penggunaan:
            - Setelah mencuci muka dan memakai toner/essence, oleskan beberapa tetes serum ke wajah dan pijat perlahan.
            - Gunakan moisturizer untuk memberikan hidrasi ekstra. 
            - Untuk perlindungan kulit, akhiri rutinitas skincare pagi dengan sunscreen.
            - Serum ini bisa digunakan di pagi dan malam hari.
            
            Alpha Arbutin 3% dan Ekstrak Grapeseed	
            
            Bahan-bahan:
            Aqua, Alpha-Arbutin, Butylene Glycol, Glycerin, Hydroxyethyl Cellulose, Phenoxyethanol, Chlorphenesin, Vitis Vinifera (Grape) Seed Extract, Disodium EDTA.
            
            - Sensitive skin friendly
            - Alcohol Free
            - Cruelty Free"
        ]);
        Product::create([
            "nama" => "The Great Shield Essence Sunscreen 30ml",
            "category_id" => 1,
            "brand_id" => 1,
            "gambar" => "product-2.jpeg",
            "pic_path" => "/uploads/products/product-2.jpeg",
            "harga" => 169000,
            "stok" => 100,
            "deskripsi" => "The Great Shield Sunscreen SPF 50 PA++++ NEW FORMULA (30 ml)	

            Sunscreen dengan SPF 50 PA++++ New Formula merupakan waterbased sunscreen yang bertekstur ringan dengan tampilan hasil akhir yang matte dan minimal whitecast. Chemical sunscreen ini hadir dengan kandungan utama yaitu Allantoin, Chamomile Flower Extract, Sodium Hyaluronate (HA), 3-O-Ethyl Ascorbic Acid, dan Silica for sebum/oil reducer yang berfungsi untuk melindungi kulit dari paparan sinar UVA dan UVB, membantu menenangkan kulit, membantu mencegah tampilan penuaan dini, mengurangi tampilan pori-pori, merawat elastisitas dan kesehatan kulit. 
            
            Dapat digunakan untuk semua jenis kulit dan bisa dipakai untuk usia mulai dari 15 tahun. (Ibu Hamil dan Menyusui harap berkonsultasi dengan terlebih dahulu dengan ahli)
            
            Cara Penggunaan:
            - Gunakan secara merata pada wajah sebanyak 2 jari di pagi hari pada step terakhir skincare sebelum beraktivitas
            - Reapply setiap 4 jam sekali untuk proteksi yang optimal
            
            Sunscreen Agents:
            - Diethylamino Hydroxybenzoyl Hexyl Benzoate 
            - Ethylhexyl Triazone
            - Polysilicone-15
            - Bis-Ethylhexyloxyphenol Methoxyphenyl Triazine
            - Terephthalylidene Dicamphor Sulfonic Acid
            
            Bahan-bahan:
            Water, Butyloctyl Salicylate, Diethylamino Hydroxybenzoyl Hexyl Benzoate, Nylon-12, Dibutyl Adipate, Phenethyl Benzoate, Ethylhexyl Triazone, Polysilicone-15, Bis-Ethylhexyloxyphenol Methoxyphenyl Triazine, Silica, Polyglyceryl-6 Stearate, Terephthalylidene Dicamphor Sulfonic Acid, 1,2-Hexanediol, C20-22 Alkyl Phosphate, Tromethamine, Caprylic/Capric Triglyceride, C20-22 Alcohols, Hydroxyacetophenone, Sodium Polyacryloyldimethyl Taurate, Polyacrylate Crosspolymer-6, Hydrogenated C6-20 Polyolefin, Butylene Glycol, PVP, Polyglyceryl-6 Behenate, Sodium Hyaluronate, 3-O-Ethyl Ascorbic Acid, Allantoin, HDI/Trimethylol Hexyllactone Crosspolymer, Anthemis Nobilis Flower Extract, t-Butyl Alcohol.
            
            Klaim Product:
            - Cruelty Free
            - Vegan
            - Sensitive Skin Friendly"
        ]);
        Product::create([
            "nama" => "Goddess Eyeshadow Palette a Peach",
            "category_id" => 2,
            "brand_id" => 2,
            "gambar" => "product-3.jpg",
            "pic_path" => "/uploads/products/product-3.jpg",
            "harga" => 195000,
            "stok" => 100,
            "deskripsi" => "The Goddess Eyeshadow Palette captures the alluring everyday colors with 9 highly pigmented shadows in four finishes."
        ]);
        Product::create([
            "nama" => "Wonder Woman Believe in Wonder: Cheek Palette",
            "category_id" => 2,
            "brand_id" => 2,
            "gambar" => "product-4.jpeg",
            "pic_path" => "/uploads/products/product-4.jpeg",
            "harga" => 295000,
            "stok" => 100,
            "deskripsi" => "Wonder Woman Believe in Wonder Cheek Palette

            Wonder Woman Believe in Wonder: Champion Cheek Palette ini merupakan face palette yang terdiri dari Bronzer, Blush dan Highlighter.
            Bronzer: Bronzer matte yang tepat untuk warna kulit medium dengan yellow-olive undertone
            Blush: Memberikan rona pipi dengan blush matte berwarna warm peach
            Highlighter: Highlighter dengan warna golden yellow yang natural untuk wajah yang glowing&#34;
            
            Wonder Woman Believe in Wonder: Confident Cheek Palette ini merupakan face palette yang terdiri dari Bronzer, Blush dan Highlighter.
            Bronzer: Bronzer matte yang tepat untuk warna kulit medium hingga gelap
            Blush: Memberikan rona pipi dengan blush matte berwarna dark pink
            Highlighter: Highlighter dengan warna pink champagne yang natural untuk wajah yang glowing"
        ]);
        Product::create([
            "nama" => "Extraordinary Oil Gold",
            "category_id" => 4,
            "brand_id" => 3,
            "gambar" => "product-5.png",
            "pic_path" => "/uploads/products/product-5.png",
            "harga" => 170000,
            "stok" => 100,
            "deskripsi" => "Extraordinary Oil adalah serum perawatan rambut intensif dari LOreal Paris. Rambut akan secara intensif ternutrisi, dan terlindungi, dan memberikan hasil rambut yang halus, lembut, tampak berkilau, tanpa memberikan hasil akhir yang lepek secara seketika.
            Rambut tampak sempurna, seketika!
            Menggunakan formula yang diperkaya dengan 6 ekstrak bunga langka: Lotus, Chamomile, Rose, Tiare, Linseed, Soybean. Penggunaan multifungsi: Gunakan 3 hingga 4 tetes sebelum keramas untuk menutrisi secara intensif, atau sebelum mengeringkan rambut menggunakan alat pengering rambut untuk melindungi rambut, atau sebagai sentuhan akhir untuk meningkatkan kilau dan intensitas warna rambut
            
            BENEFIT : 
            
             Lebih dari sekedar vitamin rambut
             Menutrisi batang hingga ujung rambut
             Melindungi rambut
             Menyempurnakan penataan akhir rambut
             Perpaduan 6 ekstrak bunga: Lotus, Chamomile, Rose, Tiare, Linseed, Soybean
             Menyempurnakan penataan akhir rambut
            
            Cara pemakaian:                                                                  
            
            1. Oleskan secara merata melalui batang dan ujung rambut basah atau kering
            2. Gunakan sebelum keramas untuk makanan mewah, sebelum styling untuk melindungi dan mengubah rambut Anda dan sebagai sentuhan akhir untuk kelembutan mewah dan bersinar mewah
            
            Berat isi produk: 100 ml"
        ]);
        Product::create([
            "nama" => "L'Oreal Professionel Hairspa Deep Nourishing Shampoo",
            "category_id" => 4,
            "brand_id" => 3,
            "gambar" => "product-6.jpg",
            "pic_path" => "/uploads/products/product-6.jpg",
            "harga" => 198791,
            "stok" => 100,
            "deskripsi" => "L'Oreal Professionnel Hair Spa Deep Nourishing Shampoo adalah shampo untuk perawatan rambut kering & rusak.

            Hasil: Rambut terlihat sehat & berkilau alami.
            
            Manfaat:
            • Menutrisi rambut rusak & melembutkan rambut kering.
            • Diperkaya dengan WATER LILY EXTRACT untuk mengembalikan kesehatan rambut, menyingkirkan kotoran pada rambut, dan membuat kilau rambut alami.
            • Menggunakan air murni yang sudah dipurifikasi demi kesehatan rambut.
            
            Cara Pemakaian:
            Cuci rambut dengan shampo Hair Spa yang sesuai dengan kondisi rambut lalu pijat dengan lembut. Bilas.
            
            BPOM: NA11181001445
            
            Shelf Life: 24 bulan"
        ]);
        Product::create([
            "nama" => "Maybelline Superstay Vinyl Ink - Liquid Lipstick",
            "category_id" => 2,
            "brand_id" => 4,
            "gambar" => "product-7.jpg",
            "pic_path" => "/uploads/products/product-7.jpg",
            "harga" => 129900,
            "stok" => 100,
            "deskripsi" => "<p>NEXT LEVEL TINT! SUPERSTAY VINYL INK DARI MAYBELLINE NEW YORK
            16 Jam pigmented, lembap dengan aloe vera, tidak transfer!
            Tint kini dalam teknologi Superstay
            Lip paling transferproof & tahan lama dengan Vinyl Finish
            Cara pakai:
            1. SHAKE = Kocok kemasan minimal 5 detik
            2. SWIPE = Aplikasikan dan diamkan hinga benar-benar kering
            3. 16 JAM PIGMENTED = Vinyl look yang trendy tanpa transfer
            Packaging: Mewah dengan emboss dan warna sesuai shade, aplikator ramping yang memudahkan pengaplikasian
            Pilihan Warna dengan color-lock formula:
            10 LIPPY - Brownish Nude Red
            15 PEACHY - Light Nude Coral
            30 UNRIVALED - Deep Berry Pink
            35 CHEEKY - Light Nude Pink
            40 WITTY - Mauve Pink
            50 WICKED - Red 
            60 MISCHIEVOUS - Nude Coral
            65 SAUCY - Nude Brownish Pink&#34;
            20 COY
            25 RED HOT</p>"
        ]);
        Product::create([
            "nama" => "Maybelline Matte Foundation Fit Me Pump Matte Pore",
            "category_id" => 2,
            "brand_id" => 4,
            "gambar" => "product-8.jpg",
            "pic_path" => "/uploads/products/product-8.jpg",
            "harga" => 165900,
            "stok" => 100,
            "deskripsi" => "Maybelline Matte Foundation Fit Me Pump Matte Pore
            <p>
            Keunggulan:
            - Blotting Micro Powder  menyerap minyak, hasil bebas kilap
            - Blurring Micro Powder  menyamarkan pori dan membuat wajah terlihat lebih halus
            - Tahan hingga 12 jam
            - Mengandung SPF 22
            - Non-comedogenic: tidak menyumbat pori-pori
            </p>
            <p>
            Tersedia dalam 10 shades yang 99% fit warna kulit wanita Indonesia:
            Fair Skintone, Red-ish Undertone:
            - 115 Ivory
            - 120 Classic Ivory 
            - 125 Nude Beige 
            </p>
            <p>
            Fair Skintone, Yellow Undertone:
            - 128 Warm Nude 
            - 123 Soft Nude
            </p>
            <p>
            Medium Skintone, Neutral Undertone:
            - 220 Natural Beige
            - 132 Light Bisque
            </p>
            <p>
            Medium Skintone, Yellow Undertone:
            - 228 Soft Tan 
            - 138 Warm Cashew
            - 190 Golden Natural            
            </p>
            <p>
            Cara pemakaian:
            Gunakan secara merata pada bagian wajah dan leher dengan menggunakan jari, spons atau brush
            </p>
            <p>
            Pro tips:
            - Mudah teroksidasi (berubah warna satu tingkat lebih gelap setelah beberapa saat diaplikasikan), sehingga disarankan memilih warna 1 tingkat lebih cerah dari warna asli kulit
            - Gunakan Fit Me Matte & Poreless Primer sebelum foundation agar makeup lebih tahan lama dan lebih halus
            </p>
            <p>
            Cocok untuk:
            Kulit normal cenderung berminyak
            </p>
            <p>
            Kandungan:
            AQUA / WATER ,CYCLOHEXASILOXANE ,NYLON-12 ,ISODODECANE ,ALCOHOL DENAT. ,CYCLOPENTASILOXANE ,PEG-10 DIMETHICONE ,CETYL PEG/PPG-10/1 D
            </p>"
        ]);
        Product::create([
            "nama" => "SOMETHINC Salmon DNA + Marine Collagen Elixir",
            "category_id" => 1,
            "brand_id" => 5,
            "gambar" => "product-9.jpeg",
            "pic_path" => "/uploads/products/product-9.jpeg",
            "harga" => 155000,
            "stok" => 100,
            "deskripsi" => "Salmon DNA + Marine Collagen Elixir 
            <p>
            Skin Booster Elixir yang diformulasikan dengan 62% Deep Sea Water, Pseudoalteromonas Ferment Extract, Hydrolyzed Marine Collagen dan Pearl yang mampu menghidrasi & menyeimbangkan produksi minyak serta DNA Salmon yang berperan untuk memperkuat skin barrier & membantu mencegah tanda penuaan dini.
            </p>
            <p>
            Ukuran: 20 ml
            No BPOM: NA18210102583
            </p>
            <p>
            Manfaat:
            Menjaga keremajaan & elastisitas kulit 
            Menghidrasi kulit
            Membantu meratakan tekstur kulit
            </p>
            <p>
            Hero Ingredients:
            DNA Salmon: Membantu menyamarkan pori-pori, membantu meningkatkan elastisitas & keremajaan kulit
            Pseudoalteromonas Ferment Extract: Menghidrasi kulit & membantu mencegah penuaan dini pada kulit
            Hydrolyzed Marine Collagen: Kolagen dari laut yang mudah diserap oleh kulit
            Pearl: membantu memperbaiki tekstur & mencerahkan kulit
            Adenosine & Biotin: Melembabkan kulit & membantu menstimulasi regenerasi sel kulit
            Deep Sea Water (65%): Menjaga hidrasi kulit, mengontrol kelebihan sebum & mengurangi inflamasi pada kulit 
            </p>
            <p>
            Jenis kulit: semua jenis kulit
            Cara pemakaian: 
            Bersihkan wajah 
            Oleskan 5 - 10 tetes serum ke telapak tangan. 
            Tekan perlahan telapak tangan ke wajah, tepuk-tepuk serum dengan gerakan ke luar & ke atas sampai merata ke wajah. 
            Tunggu selama 1-3 menit hingga produk terserap sepenuhnya. Dapat digunakan setiap hari (malam & siang)
            </p>
            <p>
            Your skin will love this because it's:
            pH 6-7 (tingkat keasamannya netral sehingga aman untuk kulit sensitif)
            NON-Comedogenic Certified
            Dermatologist Tested
            Hypoallergenic
            Fungal Acne Safe
            Suitable for Teenager (boleh dipakai dari umur 17 tahun keatas)
            </p>"
        ]);
        Product::create([
            "nama" => "SOMETHINC Bakuchiol R-Cover Firming Body Creme",
            "category_id" => 3,
            "brand_id" => 5,
            "gambar" => "product-10.jpeg",
            "pic_path" => "/uploads/products/product-10.jpeg",
            "harga" => 75000,
            "stok" => 100,
            "deskripsi" => "Bakuchiol R-Cover Firming Body Crème

            <p>3-in-1 Body Creme untuk membantu MENYAMARKAN STRETCH MARK dalam 28* hari! Diperkaya dengan kandungan Bakuchiol, Chlorella Extract, & cross-linked Hyaluronic Acid yang menjaga kekencangan sekaligus menghidrasi kulit agar tetap lembab & elastis. Nyaman digunakan sepanjang hari dengan tekstur ringan, mudah menyerap, & tidak lengket.</p>
            
            (*hasil uji in vivo bahan aktif dengan penggunaan rutin 2x sehari)
            <p>
            Ukuran: 100ml
            No BPOM: NA18210110239
            Jenis kulit: Semua jenis kulit
            </p>
            <p>
            Manfaat:
            Mengencangkan & menyamarkan stretch mark secara signifikan setelah 28 hari
            Memberi efek firming untuk kulit kendur & mengurangi munculnya hiperpigmentasi tanpa mengiritasi kulit
            Menyamarkan tanda-tanda penuaan, keriput, membantu regenerasi sel kulit
            Menjaga kelembaban kulit dan elastisitas kulit
            </p>
            <p>
            Vegan Friendly
            Dermatologist Tested
            Non-Irritation Formula
            Suitable for teenager (bisa digunakan dari umur 17 tahun keatas)
            </p>
            <p>
            Ingredients: 
            Water, Ethylhexyl Stearate, Pentylene Glycol, Polyglyceryl-3 Methylglucose Distearate, Glycerin, Glyceryl Stearate, 1,2-Hexanediol, Propylene Glycol, Stearyl Alcohol, Cetyl Alcohol, Hydroxyethyl Acrylate/Sodium Acryloyldimethyl Taurate Copolymer, Caprylyl Glycol, Carbomer, Tromethamine, Olea Europaea (Olive) Fruit Oil, Hydroxyethylcellulose, Bakuchiol, Camellia Sinensis Leaf Extract, Chlorella Vulgaris Extract, Sorbitan Isostearate, Polysorbate 60, Disodium EDTA, Myristyl Alcohol, Acetyl Glucosamine, Sodium Hyaluronate, Lauryl Alcohol, Hydroxyacetophenone, Sodium Hyaluronate Crosspolymer
            </p>"
        ]);
        Product::create([
            "nama" => "The Body Shop Moringa Shower Gel 250ml",
            "category_id" => 3,
            "brand_id" => 6,
            "gambar" => "product-11.jpg",
            "pic_path" => "/uploads/products/product-11.jpg",
            "harga" => 129000,
            "stok" => 100,
            "deskripsi" => "<p>Pembersih tubuh bertekstur gel dengan aroma moringa yang lembut dan menyegarkan. Diperkaya dengan Community Trade honey dari Ethiopia dan moringa seed oil dari Rwanda.</p>	

            <p>How to use:
            Tuangkan pada telapak tangan dan aplikasikan pada tubuh, atau gunakan bath lily untuk busa yang melimpah. Bilas dengan air. Gunakan bath lily untuk menghasilkan busa yang melimpah.</p>
            
            <p>Lengkapi perawatan tubuh Anda dengan rangkaian Moringa dari The Body Shop lainnya.</p>"
        ]);
        Product::create([
            "nama" => "The Body Shop New Strawberry Body Mist 100ml",
            "category_id" => 5,
            "brand_id" => 6,
            "gambar" => "product-12.jpg",
            "pic_path" => "/uploads/products/product-12.jpg",
            "harga" => 189000,
            "stok" => 100,
            "deskripsi" => "<p>Pengharum tubuh dalam format body mist dengan aroma strawberry yang manis dan menyegarkan. Terbuat dari denatured alcohol dan 97% natural origin ingredients. Cocok untuk digunakan sehari-hari.</p>

            <p>How to use:
            Semprotkan pada seluruh tubuh terutama titik-titik nadi setelah mandi atau sesuai kebutuhan. Gunakan juga pelembap tubuh dengan keharuman senada untuk membuat keharuman bertahan lama.</p>
            
            <p>Lengkapi perawatan tubuh Anda dengan rangkaian Strawberry dari The Body Shop lainnya.</p>"
        ]);

        User::create([
            "nama" => "Eren Yeager",
            "email" => "erenyeager@gmail.com",
            "password" => bcrypt('eren'),
            "hp" => "08123456789",
            "alamat" => "Hati Mikasa"
        ]);
        User::create([
            "nama" => "Mikasa Ackerman",
            "email" => "mikasaackerman@gmail.com",
            "password" => bcrypt('mikasa'),
            "hp" => "08123456987",
            "alamat" => "Hati Eren"
        ]);

        Admin::create([
            "nama" => "admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt('admin')
        ]);

        Order::create([
            "user_id" => 1,
            "jumlah" => 1,
            "total" => 139000,
            "jenis" => "online",
            "status" => "Menunggu konfirmasi",
            "bukti_transfer" => "bukti_transfer(1).jpg",
            "bukti_transfer_path" => "/uploads/payments/bukti_transfer(1).jpg",
        ]);

        Order::create([
            "user_id" => 2,
            "jumlah" => 2,
            "total" => 338000,
            "jenis" => "pickup",
            "status" => "Menunggu konfirmasi",
            "bukti_transfer" => "bukti_transfer(2).jpg",
            "bukti_transfer_path" => "/uploads/payments/bukti_transfer(2).jpg",
        ]);

        Order::create([
            "user_id" => 1,
            "jumlah" => 3,
            "total" => 585000,
            "jenis" => "online",
            "status" => "Menunggu konfirmasi",
            "bukti_transfer" => "bukti_transfer(3).jpg",
            "bukti_transfer_path" => "/uploads/payments/bukti_transfer(3).jpg",
        ]);

        Order_Detail::create([
            "order_id" => 1,
            "product_id" => 1,
            "jumlah" => 1,
        ]);

        Order_Detail::create([
            "order_id" => 2,
            "product_id" => 2,
            "jumlah" => 2,
        ]);

        Order_Detail::create([
            "order_id" => 3,
            "product_id" => 3,
            "jumlah" => 3,
        ]);

        Cart::create([
            "user_id" => 1
        ]);
        Cart::create([
            "user_id" => 2
        ]);
    }
}
