<?php

namespace App\Http\Livewire;

use App\Models\TaskCategoriesModel;
use Livewire\Component;

class TaskCategories extends Component
{

    //DASHBOARD
    public $taskCategoryNo, $entryDate, $user;
    public $showEntries = 10, $sortBy = 'desc', $sortColumn = "created_at";

    //ADD NEW TASK
    public $taskNameID, $taskCategory, $status, $createdBy;

    //COMPLETE TASK
    public $selectedCategory = [];

    //EDIT TASK
    public $editTaskID, $editTaskNo, $editTask, $editTaskName, $editTaskCategory, $editRemarks, $taskEdit;

    //FOR DELETE TASK
    public $confirmDelete = false;

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

        $tasks = TaskCategoriesModel::where('status', "ACTIVE")
            ->orderBy($this->sortColumn, $this->sortBy);
        $tasks = $tasks->paginate($this->showEntries);

        $allCategories = TaskCategoriesModel::orderBy($this->sortColumn, $this->sortBy)
        ->get();


        return view(
            'livewire.task-categories',
            [
                'tasks' => $tasks,
                'taskNum' => $taskNum,
                'allCategories' => $allCategories
            ]
        );
    }

    public function getStatus($status)
    {
        if ($status == 'ACTIVE') {
            $color = "bg-success";
        } else {
            $color = "bg-danger";
        }

        return $color;
    }

    public function addTaskCategory()
    {
        $this->status = "ACTIVE";

        //VALIDATION FIELDS
        // $validated = $this->validate([
        //     'task'  => 'required',
        //     'taskCategory'  => 'required',
        //     'taskName' => 'required',
        // ]);


        //SAVING OF DATA
        $newCategoryData = [
            'categoryNo' => $this->taskCategoryNo,
            'category' => $this->taskCategory,
            'status' => $this->status,
            'created_by' => $this->user,
            'created_at' => $this->entryDate,
        ];

        TaskCategoriesModel::create($newCategoryData);

        // $this->dispatch('close-modal');
    }
}
