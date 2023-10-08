<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

  public function tasks()
  {
    return $this->hasMany(Task::class);
  }

  public function addTask($body)
  {
    $this->tasks()->create(['body' => $body]);

  }

 /**
  * Get all of the activity for the Project
  *
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  */
 public function activity(): HasMany
 {
     return $this->hasMany(Activity::class);
 }
}
