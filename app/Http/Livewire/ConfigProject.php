<?php

namespace App\Http\Livewire;

use App\Models\alternativeCriteria;
use App\Models\Criteria;
use App\Models\Type;
use Exception;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use WireUi\Traits\Actions;

class ConfigProject extends Component
{
    use Actions;
    public $criterias = null;
    public $simpleModal = false;
    public $weight;
    public $setCriteria;
    public $types;
    public $type;
    public $projectId;
    public $criteriaName;
    public $editModal = false;
    public $criteriaId;
    public function render()
    {
        $this->types = Type::all();
        $this->criterias = Criteria::where('project_id', $this->projectId)->get();
        return view('livewire.config-project');
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        return [
            'criteriaName' => 'required',
            'weight' => 'required|numeric|max:5|min:1',
            'type' =>   'required'
        ];
    }


    public function openModal()
    {
        $this->criteriaId;
        $this->setCriteria = null;
        $this->weight = null;
        $this->type = 1;
        $this->simpleModal = true;
    }
    public function saveCriteria()
    {
        $this->validate();
        $criteria = Criteria::create([
            'name' => $this->criteriaName,
            'weight' => $this->weight,
            'type_id' => $this->type,
            'project_id' => $this->projectId
        ]);

        $this->render();

        $this->simpleModal = false;
        if ($criteria) {
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Kriteria Berhasil disimpan'
            );
        } else {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Gagal membuat kriteria'
            );
        }
        redirect(route('case-detail', $this->projectId));
    }

    public function editCriteria(Criteria $criteria)
    {
        $this->setCriteria = $criteria;
        $this->criteriaName = $criteria->name;
        $this->weight = $criteria->weight;
        $this->type = $criteria->type->id;
        $this->simpleModal = true;
    }
    public function deleteConfirm(Criteria $criteria)
    {
        $alternatifCriterias = alternativeCriteria::where('criteria_id', $criteria->id)->count();
        $criteriasCount = Criteria::where('project_id', $this->projectId)->count();
        if ($alternatifCriterias > 0 && $criteriasCount == 1) {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Kriteria tidak boleh kosong ketika alternatif telah diisi'
            );
        } else {
            $this->notification()->confirm([
                'title'       => 'Hapus Kriteria',
                'description' => 'Kamu yakin ingin menghapus kriteria ' . $criteria->name,
                'icon'        => 'question',
                'accept' => [
                    'label' => 'Ya, Hapus',
                    'method' => 'deleteCriteria',
                    'params' => $criteria
                ],
                'reject' => [
                    'label' => 'Batal',
                    'method' => 'cancel'
                ]
            ]);
        }
    }

    public function deleteCriteria(Criteria $criteria)
    {
        try {
            $criteria->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Kriteria Berhasil dihapus'
            );
            redirect(route('case-detail', $this->projectId));
        } catch (\Throwable $th) {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Gagal menghapus kriteria'
            );
        }
    }

    public function putCriteria()
    {
        try {
            $this->validate();
            $this->setCriteria->update([
                'name' => $this->criteriaName,
                'weight' => $this->weight,
                'type_id' => $this->type,
                'project_id' => $this->projectId
            ]);
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Kriteria Berhasil diedit'
            );
            $this->simpleModal = false;
            redirect(route('case-detail', $this->projectId));
        } catch (\Throwable $th) {
            $this->simpleModal = false;
            $this->notification()->error(
                $title = 'Terjadi kesalahan ',
                $description = 'Gagal mengubah kriteria'
            );
        }
    }
}
