<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class DetailCaseHeader extends Component
{
    use Actions;
    public $project;
    public $simpleModal;
    public $projectName;


    public function render()
    {
        return view('livewire.detail-case-header');
    }

    public function rules()
    {
        return
            ['projectName' => 'required'];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function openEditProject()
    {
        $this->simpleModal = true;
    }

    public function editProject()
    {
        $this->validate();
        $this->project->update([
            'name' => $this->projectName
        ]);
        $this->simpleModal = false;

        if ($this->project) {
            $this->notification()->success(
                $title = 'Kasus berhasil disimpan',
                $description = 'Isi data lebih lanjut untuk diolah'
            );

            // return redirect(route('case-detail', $project->id));
        } else {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Gagal membuat Kasus'
            );
        }
    }
}
