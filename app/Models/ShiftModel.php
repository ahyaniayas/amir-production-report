<?php

namespace App\Models;

use CodeIgniter\Model;

class ShiftModel extends Model
{
  protected $table = 'shift';
  protected $primaryKey = 'id_shift';
  protected $allowedFields = ['nama_shift', 'jam_masuk', 'jam_keluar'];
}