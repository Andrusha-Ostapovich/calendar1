<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  use HasFactory;
  protected $fillable = [
    'title', 'start', 'end', 'color', 'user_id'
  ];
  public function is_completed()
  {
    // Перевіряємо, чи подія завершилася
    return $this->end < now();
  }

  public function is_started()
  {
    // Перевіряємо, чи подія почалася
    return $this->start <= now() && $this->end >= now();
  }
}
