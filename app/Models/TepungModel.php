<?php

namespace App\Models;

use CodeIgniter\Model;

class TepungModel extends Model
{
  protected $table = 'ayaktepung';
  protected $primaryKey = 'id_ayaktepung';
  protected $allowedFields = ['jenis_tepung'];
}