<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Project;
use WireUi\Traits\Actions;

class ProjectTable extends DataTableComponent
{
    use Actions;
    protected $model = Project::class;
    public $projectId;
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('case-detail', $row);
            });
        $this->setRefreshVisible();

        $this->setColumnSelectDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make('Actions')->label(
                function ($row, Column $column) {
                    return view('action-button', ['row' => $row]);
                }
            )->unclickable()

        ];
    }

    public function deleteConfirm($projectId)
    {
        $project = Project::find($projectId);

        $this->notification()->confirm([
            'title'       => 'Hapus Kasus',
            'description' => 'Kamu yakin ingin menghapus Kasus ' . $project->name,
            'icon'        => 'question',
            'accept' => [
                'label' => 'Ya, Hapus',
                'method' => 'deleteCase',
                'params' => $project
            ],
            'reject' => [
                'label' => 'Batal',
                'method' => 'cancel'
            ]
        ]);
    }

    public function deleteCase(Project $project)
    {
        try {
            $project->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Kasus Berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->notification()->error(
                $title = 'Terjadi kesalahan' . $th,
                $description = 'Gagal menghapus Kasus'
            );
        }
    }
}
