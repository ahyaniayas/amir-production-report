<?php

namespace App\Models;

use CodeIgniter\Model;

class MixingModel extends Model
{
  protected $table = 'mixing';
  protected $primaryKey = 'id_mixing';
  protected $allowedFields = ['jenis_roti'];
}