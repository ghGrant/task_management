<?php

namespace App\Http\Livewire;

use App\Models\TaskCategoriesModel;
use Livewire\Component;

class CreateTaskCategory extends Component
{
    public $entryDate, $user;

    public $taskCategoryNo, $taskCategory, $status;
    
    public function mount()
    {
        $this->user = auth()->user()->name;
        $this->entryDate = now()->format('Y-m-d H:i:s');
    }

    public function render()
    {
        // TASK NUMBER GENERATION
        $taskNum = TaskCategoriesModel::orderBy('created_at', 'desc')->first();
        if ($taskNum) {
            $baseCode1 = $taskNum->categoryNo;
            $this->taskCategoryNo = sprintf("%05d", $baseCode1 + 1);
        } else {
            $baseCode1 = 0;
            $this->taskCategoryNo = sprintf("%05d", $baseCode1 + 1);
        }

        return view('livewire.create-task-category',[
            'taskNum' => $taskNum,
        ]);
    }

    public function addTaskCategory()
    {
        $this->status = "ACTIVE";

        //SAVING OF DATA
        $newCategoryData = [
            'categoryNo' => $this->taskCategoryNo,
            'category' => $this->taskCategory,
            'status' => $this->status,
            'created_by' => $this->user,
            'created_at' => $this->entryDate,
        ];

        TaskCategoriesModel::create($newCategoryData);

        
        $this->dispatch('taskCategoryAdded');

        $this->reset(['taskCategory']);
    }
}
