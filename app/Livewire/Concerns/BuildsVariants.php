<?php

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Log;

trait BuildsVariants
{
    public bool $hasVariants = false;
    public array $variantOptions = [];
    public array $newOptionValue = [];
    public array $variants = [];

    protected int $maxVariantTypes = 3;
    protected int $maxValuesPerType = 20;
    protected int $maxCombinations = 100;

    protected function resetVariantBuilder(): void
    {
        $this->variantOptions = [['name' => '', 'values' => []]];
        $this->newOptionValue = [''];
        $this->variants = [];
    }

    public function updatedHasVariants(bool $value): void
    {
        if (!$value) {
            $this->resetVariantBuilder();
        }
    }

    public function updated($name, $value): void
    {
        if (preg_match('/^variantOptions\.0\.values\.(\d+)\.image$/', $name, $m)) {
            $file = $this->variantOptions[0]['values'][(int) $m[1]]['image'] ?? null;
            if ($file) {
                $this->variantOptions[0]['values'][(int) $m[1]]['preview'] = $file->temporaryUrl();
            }
        }
    }

    public function addVariantOption(): void
    {
        if (count($this->variantOptions) >= $this->maxVariantTypes) {
            session()->flash('error', "You can add up to {$this->maxVariantTypes} variant types.");
            return;
        }

        $this->variantOptions[] = ['name' => '', 'values' => []];
        $this->newOptionValue[] = '';
    }

    public function removeVariantOption(int $index): void
    {
        unset($this->variantOptions[$index], $this->newOptionValue[$index]);
        $this->variantOptions = array_values($this->variantOptions);
        $this->newOptionValue = array_values($this->newOptionValue);

        if (empty($this->variantOptions)) {
            $this->resetVariantBuilder();
            return;
        }

        $this->variants = [];
    }

    public function addOptionValue(int $optionIndex): void
    {
        $value = trim($this->newOptionValue[$optionIndex] ?? '');

        if ($value === '') {
            return;
        }

        $existing = array_map(fn ($v) => strtolower($v['value']), $this->variantOptions[$optionIndex]['values']);

        if (in_array(strtolower($value), $existing, true)) {
            $this->newOptionValue[$optionIndex] = '';
            session()->flash('error', 'This value already exists.');
            return;
        }

        if (count($this->variantOptions[$optionIndex]['values']) >= $this->maxValuesPerType) {
            session()->flash('error', "Maximum {$this->maxValuesPerType} values per variant type.");
            return;
        }

        $this->variantOptions[$optionIndex]['values'][] = ['value' => $value, 'image' => null, 'preview' => null];
        $this->newOptionValue[$optionIndex] = '';
    }

    public function removeOptionValue(int $optionIndex, int $valueIndex): void
    {
        if (!isset($this->variantOptions[$optionIndex]['values'][$valueIndex])) {
            return;
        }

        unset($this->variantOptions[$optionIndex]['values'][$valueIndex]);
        $this->variantOptions[$optionIndex]['values'] = array_values($this->variantOptions[$optionIndex]['values']);
    }

    protected function firstOptionName(): ?string
    {
        $name = trim($this->variantOptions[0]['name'] ?? '');
        return $name !== '' ? $name : null;
    }

    public function variantThumbnail(array $attributes): ?string
    {
        $firstOptionName = $this->firstOptionName();

        if (!$firstOptionName || !isset($attributes[$firstOptionName]) || empty($this->variantOptions[0]['values'])) {
            return null;
        }

        foreach ($this->variantOptions[0]['values'] as $valueData) {
            if ($valueData['value'] === $attributes[$firstOptionName]) {
                return $valueData['preview'] ?? null;
            }
        }

        return null;
    }

    public function generateVariants(): void
    {
        try {
            $grouped = collect($this->variantOptions)
                ->filter(fn ($o) => trim($o['name']) !== '' && count($o['values']) > 0)
                ->mapWithKeys(fn ($o) => [trim($o['name']) => collect($o['values'])->pluck('value')->toArray()])
                ->toArray();

            if (empty($grouped)) {
                session()->flash('error', 'Add at least one variant type with values first.');
                return;
            }

            $combinations = $this->cartesianProduct($grouped);

            if (count($combinations) > $this->maxCombinations) {
                session()->flash('error', count($combinations) . " combinations is too many — max {$this->maxCombinations}.");
                return;
            }

            $existing = collect($this->variants)->keyBy(fn ($v) => $this->combinationKey($v['attributes']));
            $defaults = $this->defaultVariantFields();

            $this->variants = collect($combinations)->map(function ($attributes) use ($existing, $defaults) {
                $previous = $existing->get($this->combinationKey($attributes));

                return array_merge(
                    ['attributes' => $attributes],
                    $defaults,
                    array_intersect_key($previous ?? [], $defaults)
                );
            })->toArray();

            session()->flash('message', count($this->variants) . ' variant combination(s) generated.');
        } catch (\Exception $e) {
            Log::error('Error generating variants', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to generate variants. Please try again.');
        }
    }

    protected function defaultVariantFields(): array
    {
        return ['price_adjustment' => 0];
    }

    private function cartesianProduct(array $optionGroups): array
    {
        $result = [[]];

        foreach ($optionGroups as $optionName => $values) {
            $appended = [];
            foreach ($result as $combination) {
                foreach ($values as $value) {
                    $appended[] = $combination + [$optionName => $value];
                }
            }
            $result = $appended;
        }

        return $result;
    }

    private function combinationKey(array $attributes): string
    {
        ksort($attributes);
        return json_encode($attributes);
    }

    protected function storeVariantValueImages(string $disk): array
    {
        $firstOptionName = $this->firstOptionName();
        $paths = [];

        if ($firstOptionName && !empty($this->variantOptions[0]['values'])) {
            foreach ($this->variantOptions[0]['values'] as $valueData) {
                if (!empty($valueData['image'])) {
                    $paths[$valueData['value']] = $valueData['image']->store($disk, 'public');
                }
            }
        }

        return $paths;
    }

    protected function variantImagePathFor(array $attributes, array $valueImagePaths): ?string
    {
        $firstOptionName = $this->firstOptionName();

        if (!$firstOptionName || !isset($attributes[$firstOptionName])) {
            return null;
        }

        return $valueImagePaths[$attributes[$firstOptionName]] ?? null;
    }
}