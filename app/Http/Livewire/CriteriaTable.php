<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Criteria;
use Illuminate\Database\Eloquent\Builder;

class CriteriaTable extends DataTableComponent
{
    protected $model = Criteria::class;

    public $projectId;
    public function builder(): Builder
    {
        return Criteria::query()
            ->where('project_id', $this->projectId);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setRefreshVisible();
        $this->setSearchVisibilityDisabled();
        $this->setColumnSelectDisabled();
        $this->setPaginationDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make('Actions')->label(
                function ($row, Column $column) {
                    return view('action-button');
                }
            )->unclickable()
        ];
    }
}
