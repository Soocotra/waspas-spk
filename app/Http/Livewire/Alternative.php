<?php

namespace App\Http\Livewire;

use App\Models\Alternative as ModelsAlternative;
use App\Models\alternativeCriteria;
use App\Models\Criteria;
use Livewire\Component;
use WireUi\Traits\Actions;

class Alternative extends Component
{
    use Actions;
    public $alternatives = null;
    public $projectId;
    public $alternativeName;
    public $simpleModal;
    public $criterias;
    public $alternativeId;
    public $setAlternative;
    public $displayAlternatifCriterias;
    public $criteriaVals;
    public $results = [];
    public         $criteriaCount = false;
    public function render()
    {
        $this->results = [];
        $this->criterias = Criteria::where('project_id', $this->projectId)->get();
        $this->alternatives = ModelsAlternative::where('project_id', $this->projectId)->get();
        $projectId = $this->projectId;
        $this->criteriaCount = alternativeCriteria::whereHas('criteria', function ($q) use ($projectId) {
            return $q->where('project_id', $projectId);
        })->count() == $this->criterias->count() * $this->alternatives->count();

        if ($this->criterias->isNotEmpty() && $this->alternatives->isNotEmpty() && $this->criteriaCount) {
            $this->results = $this->decide();
            usort($this->results, function ($a, $b) {
                return strcmp(number_format($b->qi, 10, '.', ''), number_format($a->qi, 10, '.', ''));
            });
        }
        return view('livewire.alternative');
    }

    public function openModal()
    {
        $this->alternativeName = null;
        $this->criteriaVals = null;
        $this->setAlternative = null;

        $this->simpleModal = true;
    }

    public function rules()
    {

        return [
            'alternativeName' => 'required|unique:alternatives,name' . ($this->setAlternative != null ? ',' . $this->setAlternative->id : ''),
            'criteriaVals.*' => 'required'
        ];
    }

    public function messages()
    {
        return [

            'criteriaVals.*.required' => 'Criteria value is required'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function deleteCriteria(Alternative $alternative)
    {
        try {
            $alternative->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Kriteria Berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Gagal menghapus kriteria'
            );
        }
    }

    public function saveAlternative()
    {
        $this->validate();
        try {
            $alternative = ModelsAlternative::create([
                'name' => $this->alternativeName,
                'project_id' => $this->projectId,
            ]);
            dd($this->criteriaVals);
            if ($alternative) {
                foreach ($this->criteriaVals as $key => $criteria) {
                    alternativeCriteria::create(
                        [
                            'value' => $criteria,
                            'alternative_id' => $alternative->id,
                            'criteria_id' => array_keys($this->criteriaVals, $criteria)[0]
                        ]
                    );
                }
            }
            $this->simpleModal = false;
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Alternatif Berhasil Disimpan'
            );
        } catch (\Throwable $th) {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Gagal menghapus Alternatif'
            );
        }
    }

    public function deleteAlternative(ModelsAlternative $alternative)
    {
        try {
            $alternative->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Alternatif Berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->notification()->error(
                $title = 'Terjadi kesalahan',
                $description = 'Gagal menghapus Alternatif'
            );
        }
    }

    public function editAlternative(ModelsAlternative $alternative)
    {
        $criteriaValues = alternativeCriteria::where('alternative_id', $alternative->id)->get();
        $this->alternativeName = $alternative->name;
        foreach ($criteriaValues as $key => $value) {
            $this->criteriaVals[$value->criteria_id] = $value->value;
        }
        $this->setAlternative = $alternative;
        $this->simpleModal = true;
    }

    public function deleteConfirm(ModelsAlternative $alternative)
    {
        $this->notification()->confirm([
            'title'       => 'Hapus Alternatif',
            'description' => 'Kamu yakin ingin menghapus Alternatif ' . $alternative->name,
            'icon'        => 'question',
            'accept' => [
                'label' => 'Ya, Hapus',
                'method' => 'deleteAlternative',
                'params' => $alternative
            ],
            'reject' => [
                'label' => 'Batal',
                'method' => 'cancel'
            ]
        ]);
    }
    public function putAlternative()
    {
        // dd($this->criteriaVals);

        $this->validate();
        try {
            $updated = $this->setAlternative->update([
                'name' => $this->alternativeName
            ]);
            if ($updated) {
                foreach ($this->criteriaVals as $key => $criteria) {
                    $alternatifCriterias = AlternativeCriteria::where('alternative_id', $this->setAlternative->id)
                        ->where('criteria_id', array_keys($this->criteriaVals, $criteria)[0])
                        ->first();

                    if ($alternatifCriterias != null) {
                        $alternatifCriterias->update([
                            'value' => $criteria
                        ]);
                    } else {
                        alternativeCriteria::create(
                            [
                                'value' => $criteria,
                                'alternative_id' => $this->setAlternative->id,
                                'criteria_id' => array_keys($this->criteriaVals, $criteria)[0]
                            ]
                        );
                    }
                }
            }
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Alternatif Berhasil diedit'
            );
            $this->render();
            $this->simpleModal = false;
        } catch (\Throwable $th) {
            $this->simpleModal = false;
            $this->notification()->error(
                $title = 'Terjadi kesalahan ',
                $description = 'Gagal mengubah Alternatif'
            );
        }
    }

    public function decide()
    {
        $weights = Criteria::where('project_id', $this->projectId)->orderBy('created_at', 'asc')->pluck('weight');
        $sumWeight = Criteria::where('project_id', $this->projectId)->sum('weight');
        $newWeights = [];
        $temp = [];
            $x = [];
        $y = [];
        foreach ($weights as $key => $weight) {
            $newWeights[] = $weight / $sumWeight;
        }

        // PROSES NORMALISASI
        foreach ($this->criterias as $key => $criteria) {
            $maxY = AlternativeCriteria::where('criteria_id', $criteria->id)->orderBy('value', 'desc')->pluck('value')->first();
            $minY = AlternativeCriteria::where('criteria_id', $criteria->id)->orderBy('value', 'asc')->pluck('value')->first();
            $y = [];

            foreach ($this->alternatives as $key => $alternative) {
                $cell = AlternativeCriteria::where('criteria_id', $criteria->id)
                    ->where('alternative_id', $alternative->id)->first();
                if ($cell != null) {
                    if ($cell->criteria->type_id == 1) {
                        array_push($y, $cell->value / $maxY);
                    } else {
                        array_push($y, $minY / $cell->value);
                    }
                }
            }
            array_push($x, $y);
            
        }
        //PROSES PERANGKINGAN
        foreach ($this->alternatives as $key => $alternative) {
            $test = 0;
            $Qi = null;
            $formula2 = 1;
            $formula1 = null;

            for ($j = 0; $j < sizeof($x); $j++) {
                if ($x[$j] != null) {
                    if ($j < sizeof($x)) {
                        $formula1 += ($x[$j][$key] * $newWeights[$j]);
                        $formula2 *= (pow($x[$j][$key], $newWeights[$j]));
                        $test++;
                    }
                } else {
                    $formula2 = 0;
                    $formula1 = 0;
                }
            }
            $Qi = 0.5 * ($formula1 + $formula2);

            array_push($temp, (object)[
                'alt_id' => $alternative->id,
                'alt' => $alternative->name,
                'qi' => $Qi
            ]);
        }

        usort($temp, function ($a, $b) {
            return strcmp(number_format($b->qi, 10, '.', ''), number_format($a->qi, 10, '.', ''));
        });
        $rank = 1;
        foreach ($temp as $key => $value) {
            ModelsAlternative::find($value->alt_id)->update([
                'rank' => $rank
            ]);
            $rank++;
        }
        
        return $temp;
    }
}
