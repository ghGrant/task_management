<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksPageModel extends Model
{
    public $table = 'tasks';
    protected $guarded = [];

    // ✅ Define the category relationship
    public function category()
    {
        return $this->belongsTo(TaskCategoriesModel::class, 'taskCategory', 'id');
    }
}
