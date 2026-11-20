<?php

namespace App\Livewire\Workspaces\Forms\Fields;

use App\Livewire\Concerns\LoadsWorkspaceForm;
use App\Livewire\Workspaces\Forms\Edit;
use App\Models\Fields;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use LoadsWorkspaceForm;

    public function mount(string $workspace, string $form): void
    {
        $this->loadForm($workspace, $form);
    }

    public function moveUp(int $fieldId): void
    {
        $this->move($fieldId, -1);
    }

    public function moveDown(int $fieldId): void
    {
        $this->move($fieldId, 1);
    }

    public function delete(int $fieldId): void
    {
        DB::transaction(function () use ($fieldId) {
            $this->formModel->fields()->whereKey($fieldId)->firstOrFail()->delete();
            $this->renumber($this->orderedFields()->pluck('id')->all());
        });
    }

    /**
     * Swap a field with its neighbour, then write positions 1..n again.
     */
    private function move(int $fieldId, int $step): void
    {
        DB::transaction(function () use ($fieldId, $step) {
            $ids = $this->orderedFields()->pluck('id')->all();
            $from = array_search($fieldId, $ids, true);
            abort_if($from === false, 404);

            $to = $from + $step;
            if (! isset($ids[$to])) {
                return;
            }

            [$ids[$from], $ids[$to]] = [$ids[$to], $ids[$from]];
            $this->renumber($ids);
        });
    }

    /**
     * @param  list<int>  $ids
     */
    private function renumber(array $ids): void
    {
        foreach ($ids as $index => $id) {
            Fields::whereKey($id)->update(['position' => $index + 1]);
        }
    }

    private function orderedFields()
    {
        return $this->formModel->fields()->orderBy('position')->orderBy('id')->get();
    }

    /**
     * The grey line under each field label.
     */
    public static function summary(Fields $field): string
    {
        $options = json_decode($field->options ?? '[]', true) ?: [];
        $rules = json_decode($field->rules ?? '[]', true) ?: [];

        if ($options) {
            return 'Seçenekler: '.implode(' · ', $options);
        }

        if (isset($rules['min']) || isset($rules['max'])) {
            return trim('Kural: '.(isset($rules['min']) ? 'en az '.$rules['min'] : '').(isset($rules['min'], $rules['max']) ? ', ' : '').(isset($rules['max']) ? 'en fazla '.$rules['max'] : ''));
        }

        if ($field->placeholder) {
            return 'Yer tutucu: '.$field->placeholder;
        }

        return match ($field->type) {
            'date' => 'Tarih seçici',
            'textarea' => 'Çok satırlı metin',
            default => 'Yer tutucu yok',
        };
    }

    public function render()
    {
        $fields = $this->orderedFields();
        $isFree = $this->workspaceModel->plan === 'free';

        return view('livewire.workspaces.forms.fields.index', [
            'form' => $this->formModel,
            'fields' => $fields,
            'isFree' => $isFree,
            'limit' => Create::FREE_FIELD_LIMIT,
            'submissionCount' => $this->formModel->submissions()->count(),
            'status' => Edit::STATUSES[$this->formModel->status] ?? Edit::STATUSES['draft'],
        ])
            ->extends('formcraft.fields')
            ->section('page');
    }
}
