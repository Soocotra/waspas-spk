<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class History extends Component
{
    use Actions;
    public $simpleModal = false;
    public $projectName;
    public function render()
    {
        return view('livewire.history');
    }

    public function openModal()
    {

        $this->simpleModal = true;
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

    public function saveProject()
    {
        $this->validate();
        $project = Project::create(
            [
                'name' => $this->projectName,
                'user_id' => Auth::user()->id
            ]
        );
        $this->simpleModal = false;
        $this->render();
        if ($project) {
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
