<?php

namespace App\Models;

use CodeIgniter\Model;

class DryingModel extends Model
{
  protected $table = 'drying';
  protected $primaryKey = 'id_drying';
  protected $allowedFields = ['jenis_label'];
}