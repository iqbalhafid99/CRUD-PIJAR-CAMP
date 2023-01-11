<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "pijarcamp";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //if tombol enter diklik
    if(isset($_POST['bsimpan']))
    {

        //data simpan baru atau edit
        if($_GET['hal']=="edit"){
            //data di edit
            $edit = mysqli_query($koneksi, "UPDATE produk set
                                            nama_produk = '$_POST[tproduk]',
                                            harga = '$_POST[tharga]',
                                            jumlah = '$_POST[tjumlah]',
                                            keterangan = '$_POST[tketerangan]'
                                            WHERE no = '$_GET[no]'
                                            ");

            if($edit) // if edit sukses
            {
                echo "<script> 
                
                    alert('Berhasil mengedit data!');
                    document.location='index.php';

                </script>";
            }
            else{

                echo "<script> 
                
                    alert('Gagal!');
                    document.location='index.php';

                </script>";
            }
        } else {
            //data disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, harga, jumlah, keterangan) 
                                        VALUES ('$_POST[tproduk]', 
                                                '$_POST[tharga]',
                                                '$_POST[tjumlah]',
                                                '$_POST[tketerangan]');
             ");

            if($simpan) // if enter sukses
            {
                echo "<script> 
                
                    alert('Berhasil menginput data!');
                    document.location='index.php';

                </script>";
            }
            else{

                echo "<script> 
                
                    alert('Gagal!');
                    document.location='index.php';

                </script>";
            }
        }

        

    }

    //if tombol hapus/ubah di klik

    if(isset($_GET['hal']))
    {
        //jika edit data
        if($_GET['hal' ] == "edit" )
        {
            //tampilkan data yang akan di edit
            $tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE no = '$_GET[no]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $vNamaProduk = $data ['nama_produk'];
                $vHarga = $data ['harga'];
                $vJumlah = $data ['jumlah'];
                $vKet = $data ['keterangan'];
            }
        } else if ($_GET['hal'] == "hapus")
        {
            //data dihapus
            $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE no = '$_GET[no]' ");
            if($hapus){
                echo "<script> 
                
                    alert('Berhasil Terhapus!');
                    document.location='index.php';

                </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENJUALAN WARUNGKU</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-3">PENJUALAN WARUNGKU</h1>

        <!-- Awal card Form -->
            <div class="card mt-5">
            <div class="card-header bg-success text-white ">
                Form input barang yang telah terjual
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-grup">
                        <label class="label m-2" for="" >Nama Produk</label>
                        <input type="text" name="tproduk" value="<?=@$vNamaProduk?>" class="form-control" placeholder="Masukan nama produk di sini!" required>
                    </div>
                    <div class="form-grup">
                        <label class="label m-2" for="" >Harga</label>
                        <input type="text" name="tharga" value="<?=@$vHarga?>" class="form-control" placeholder="Input Harga" required>
                    </div>
                    <div class="form-grup">
                        <label class="label m-2" for="" >Jumlah</label>
                        <input type="text" name="tjumlah" value="<?=@$vJumlah?>" class="form-control" placeholder="Input Jumlah" required>
                    </div>
                    <div class="form-grup">
                        <label class="label m-2" for="" >keterangan</label>
                        <textarea class="form-control" name="tketerangan" id="" cols="15" rows="5" placeholder="Masukan keterangan jika ada"><?=@$vKet?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success mt-3" name="bsimpan">Enter</button>
                    <button type="reset" class="btn btn-danger mt-3" name="hapus">Delete</button>
                </form>
            </div>
            </div>        
        <!-- Akhir card Form -->


        <!-- Awal card Table -->
        <div class="card mt-5">
            <div class="card-header bg-warning text-white ">
                Data Penjualan Bulan Januari
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Edit</th>
                    </tr>
                    <?php
                    $no = 1;
                        $tampil = mysqli_query($koneksi, "SELECT * from produk order by nama_produk desc");
                        while($data = mysqli_fetch_array($tampil)) :

                    ?>
                    <tr>
                        <td>  <?=  $no++;  ?>  </td>
                        <td>  <?=  $data['nama_produk']  ?>  </td>
                        <td>  <?=  $data['harga']  ?>  </td>
                        <td>  <?=  $data['jumlah']  ?>  </td>
                        <td><?=  $data['keterangan']  ?></td>
                        <td>
                            <a href="index.php?hal=edit&no=<?=$data['no']?>" class="btn btn-success m-2">Ubah</a>
                            <a href="index.php?hal=hapus&no=<?=$data['no']?>" onclick="return confirm('Apakah yakin ingin menghapus?')" class="btn btn-danger m-2">Hapus</a>
                        </td>
                    </tr>

                    <?php endwhile; //penutup while ?>

                </table>
            </div>
            </div>        
        <!-- Akhir card Table -->



    </div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>