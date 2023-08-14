<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

  /**
   * Get the owner that owns the Project
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function owner(): BelongsTo
  {
      return $this->belongsTo(User::class);
  }
}
