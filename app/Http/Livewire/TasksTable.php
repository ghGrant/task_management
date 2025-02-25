<?php

namespace App\Http\Livewire;

use App\Models\TaskCategoriesModel;
use App\Models\TasksPageModel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Support\Facades\Log;

class TasksTable extends DataTableComponent
{
    protected $model = TasksPageModel::class;

    public array $selectedRows = [];

    protected $listeners = ['processSelected', 'deleteSelected'];


    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('taskNo')) {
                return [
                    'class' => 'bg-green-500',
                ];
            }
            return [];
        });

        $this->setTrAttributes(function ($row, $index) {
            if ($index % 2 === 0) {
                return [
                    'default' => true,
                    'class' => 'bg-gray-200',
                ];
            }
            return ['default' => true];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($column->isField('taskNo') && $row->total < 1000) {
                return [
                    'class' => 'bg-red-500 text-black text-align-center',
                ];
            } elseif ($column->isField('taskNo') && $row->total >= 1000) {
                return [
                    'class' => 'bg-green-500 text-white align-items-center w-100',
                ];
            }
            return [];
        });

        $this->setTableAttributes([
            'class' => 'table table-striped table-hover',
            'style' => 'width: 100%; white-space: nowrap;'
        ]);

        $this->setTableWrapperAttributes([
            'class' => 'table-responsive',
            'style' => 'overflow-x: auto; white-space: nowrap;'
        ]);

        $this->setPaginationMethod('simple');
        $this->setColumnSelectStatus(false);
    }

    public function processSelected()
    {
        if (!empty($this->selectedRows)) {
            TasksPageModel::whereIn('id', $this->selectedRows)->update(['status' => 'COMPLETED']);

            $this->selectedRows = [];

            $this->dispatch('refreshTable');
        }
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedRows)) {
            TasksPageModel::whereIn('id', $this->selectedRows)->update(['status' => 'DELETED']);

            $this->selectedRows = [];

            $this->dispatch('refreshTable');
        }
    }

    public function builder(): Builder
    {
        return TasksPageModel::query()->with('category');
    }

    public function category()
    {
        return $this->belongsTo(TaskCategoriesModel::class, 'taskCategory', 'id');
    }

    protected function getListeners()
    {
        return [
            'taskAdded' => '$refresh',
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Select', 'id')
                ->format(fn($value, $row) => view('livewire.checkbox', [
                    'id' => $row->id
                ]))
                ->setLabelAttributes(['class' => 'text-2md text-center'])
                ->sortable(),

            Column::make('Task No.', 'taskNo')
                ->setLabelAttributes(['class' => 'text-2md text-center'])
                ->sortable()
                ->searchable(),

            Column::make('Task Assigned to', 'taskName')
                ->setLabelAttributes(['class' => 'text-2md text-center'])
                ->sortable()
                ->searchable()
                ->format(fn($value, $row) => view('livewire.editable-select', [
                    'id' => $row->id,
                    'field' => 'taskName',
                    'value' => $row->taskName,
                    'options' => \App\Models\User::select('id', 'name')->get(),
                    'optionLabel' => 'name'
                ])),

            Column::make('Task Name', 'task')
                ->sortable()
                ->searchable()
                ->format(fn($value, $row) => view('livewire.editable-input', [
                    'id' => $row->id,
                    'field' => 'task',
                    'value' => $value
                ])),

            Column::make('Task Category', 'taskCategory')
                ->sortable()
                ->searchable()
                ->format(fn($value, $row) => view('livewire.editable-select', [
                    'id' => $row->id,
                    'field' => 'taskCategory',
                    'value' => $row->taskCategory,
                    'options' => \App\Models\TaskCategoriesModel::select('id', 'category')->get(),
                    'optionLabel' => 'category'
                ])),



            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Remarks', 'remarks')
                ->sortable()
                ->searchable()
                ->format(fn($value, $row) => view('livewire.editable-input', [
                    'id' => $row->id,
                    'field' => 'remarks',
                    'value' => $value
                ])),

            Column::make('Created By', 'created_by')->sortable()->searchable(),
            Column::make('Date Created', 'created_at')->sortable()->searchable(),
        ];
    }

    public function updateTask($id, $field, $value)
    {
        $task = TasksPageModel::find($id);
        if ($task) {
            $task->$field = $value;
            $task->save();
        }
    }
}
