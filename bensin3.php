<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Bahan Bakar</title>
</head>
<body>
    
<style>
        /* Gaya untuk memisahkan input dan hasil */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            background-color:gray;
            width: 60%;
            border-radius:20px;
            padding:10px;
            margin:10px;
        }
        .divider {
            display: flex;
            padding:10px;
            margin:10px;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            background-color: #ccc;
            width: 60%;
            border-radius:20px;
            justify-content: flex-start; 
        }
        h1{
            font-size:20px;
        }
    </style>
    <center>
    <div class="divider">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis = $_POST["jenisBahanBakar"];
    $jumlah = $_POST["jumlahLiter"];

    class Shell {
        protected $harga;
        protected $jumlah;
        protected $jenis;
        protected $ppn;
    
        public function __construct($jenis, $harga, $jumlah) {
            $this->jenis = $jenis;
            $this->harga = $harga;
            $this->jumlah = $jumlah;
            $this->ppn = 0.10; // PPN 10%
        }
    
        public function hitungSubtotal() {
            return $this->harga * $this->jumlah;
        }
    
        public function hitungPpn() {
            return $this->hitungSubtotal() * $this->ppn;
        }
    }
    
    class Beli extends Shell {
        public function hitungTotal() {
            return $this->hitungSubtotal() + $this->hitungPpn();
        }
    
        public function buktiTransaksi() {
            echo "Anda membeli bahan bakar minyak tipe $this->jenis<br>";
            echo "Dengan jumlah : $this->jumlah Liter<br>";
            echo "Total yang harus anda bayar Rp. ".number_format($this->hitungTotal(), 0, ',', '.')."<br>";
        }
    }

    class Pembeli extends Beli {
        private $namaPembeli;

        public function __construct($jenis, $harga, $jumlah, $namaPembeli) {
            parent::__construct($jenis, $harga, $jumlah);
            $this->namaPembeli = $namaPembeli;
        }

        public function tampilkanPembeli() {
            echo "Transaksi dilakukan oleh: $this->namaPembeli<br>";
        }

        public function buktiTransaksiLengkap() {
            $this->tampilkanPembeli();
            $this->buktiTransaksi();
        }
    }

    $beli = new Pembeli($jenis, 16130, $jumlah, $_POST['namaPembeli']); // Menambahkan nama pembeli dari input form
    $beli->buktiTransaksiLengkap();
}
?>
</div>
<div class="container">
    <h1>FuelEnrico</h1>
<form method="POST" action="">
    <!-- Input untuk nama pembeli -->
    Masukkan Nama Pembeli:
    <input type="text" id="namaPembeli" name="namaPembeli" required><br>

    <!-- Input untuk jumlah liter -->
    Masukkan Jumlah Liter: 
    <input type="number" id="jumlahLiter" name="jumlahLiter" min="1" required><br>

    <!-- Pilih Tipe Bahan Bakar -->
    <select id="jenisBahanBakar" name="jenisBahanBakar">
        <option value='Shell V-Power'>Shell Super</option>
        <option value='pertaMAX'>pertaMAX</option>
        <option value='pertaLITE'>pertaLITE</option>
        <option value='perturbo'>perturbo</option>
        <!-- Tambahkan opsi lain sesuai kebutuhan -->
    </select><br>

    <input type='submit' value='Beli'>
</form>
    </div>
    </center>
</body>
</html>
