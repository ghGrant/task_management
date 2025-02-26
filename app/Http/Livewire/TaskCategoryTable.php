<?php

namespace App\Http\Livewire;

use App\Models\TaskCategoriesModel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TaskCategoryTable extends DataTableComponent
{
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

    protected function getListeners()
    {
        return [
            'taskCategoryAdded' => '$refresh',
        ];
    }

    public function builder(): Builder
    {
        return TaskCategoriesModel::query();
    }

    public function columns(): array
    {
        return [
            Column::make('Category No.', 'categoryNo')
                ->setLabelAttributes(['class' => 'text-2md text-center'])
                ->sortable()
                ->searchable(),

            Column::make('Category', 'category')
                ->sortable()
                ->searchable()
                ->format(fn($value, $row) => view('livewire.editable-input', [
                    'id' => $row->id,
                    'field' => 'category',
                    'value' => $value
                ])),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable()
                ->format(fn($value, $row) => view('livewire.editable-select', [
                    'id' => $row->id,
                    'field' => 'status',
                    'value' => $row->status,
                    'options' => ["ACTIVE", "INACTIVE"]
                ])),


            Column::make('Created By', 'created_by')->sortable()->searchable(),
            Column::make('Date Created', 'created_at')->sortable()->searchable(),
        ];
    }

    public function updateTask($id, $field, $value)
    {
        $task = TaskCategoriesModel::find($id);
        if ($task) {
            $task->$field = $value;
            $task->save();
        }
    }
}
