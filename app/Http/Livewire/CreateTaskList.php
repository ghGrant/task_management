<?php

namespace App\Http\Livewire;

use App\Models\TaskCategoriesModel;
use App\Models\TasksPageModel;
use App\Models\User;
use Livewire\Component;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CreateTaskList extends Component
{
    protected $model1 = TasksPageModel::class;

    public $entryDate, $user;

    public $taskNameID, $taskName, $taskNo, $task, $taskCategory, $status, $remarks, $createdBy;

    public function mount()
    {
        $this->user = auth()->user()->name;
        $this->entryDate = now()->format('Y-m-d H:i:s');
    }

    public function render()
    {
        $taskNum = TasksPageModel::orderBy('created_at', 'desc')->first();
        if ($taskNum) {
            $baseCode1 = $taskNum->taskNo;
            $this->taskNo = sprintf("%05d", $baseCode1 + 1);
        } else {
            $baseCode1 = 0;
            $this->taskNo = sprintf("%05d", $baseCode1 + 1);
        }

        //GET USERS
        $userName = User::where('name', '!=', "Admin")
            ->get();

        //GET CATEGORIES
        $categories = TaskCategoriesModel::where('status', '!=', "INACTIVE")
        ->get();
        return view('livewire.create-task-list', [
            'userName' => $userName,
            'categories' => $categories,
        ]);
    }

    public function addTask()
    {
        if ($this->user == "Admin") {
            $this->status = "ON-GOING";
        } else {
            $this->status = "OPEN";
        }

        //SAVING OF DATA
        $newTaskData = [
            'taskNo' => $this->taskNo,
            'taskName' => $this->taskName,
            'task' => $this->task,
            'taskCategory' => $this->taskCategory,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'created_by' => $this->user,
            'created_at' => $this->entryDate,
        ];

        TasksPageModel::create($newTaskData);

        $this->dispatch('taskAdded');

        $this->reset(['task', 'taskName', 'taskCategory', 'remarks']);

    }

    
}