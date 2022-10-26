<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
  protected $table = 'laporan';
  protected $primaryKey = 'id_laporan';
  protected $allowedFields = ['tanggal', 'nama_shift', 'tipe_laporan', 'no_planprod', 'produk', 'qty', 'qty_stok', 'qty_limbah', 'jenis_oven', 'no_mesin', 'operator', 'kendala', 'user', 'id_divisi', 'divisi'];
}
