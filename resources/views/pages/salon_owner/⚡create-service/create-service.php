<?php

use App\Livewire\Concerns\BuildsVariants;
use App\Models\ItemVariant;
use App\Models\Post;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads, BuildsVariants;

    public string $name = '';
    public ?int $service_category_id = null;
    public float $price = 0;
    public ?int $duration_minutes = null;
    public ?string $description = null;
    public $image = null;
    public string $status = 'draft';

    public ?string $newCategoryName = null;
    public ?int $tenantId = null;

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;

        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->tenantId = $tenant->id;
        $this->resetVariantBuilder();
    }

    protected function defaultVariantFields(): array
    {
        return ['price_adjustment' => 0, 'duration_adjustment' => 0];
    }

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'price' => 'required|numeric|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ];

        if ($this->hasVariants) {
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.price_adjustment'] = 'nullable|numeric';
            $rules['variants.*.duration_adjustment'] = 'nullable|integer';
            $rules['variantOptions.0.values.*.image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'variants.required' => 'Click "Generate Variants" to build your combinations first.',
        ];
    }

   #[Computed]
public function categories()
{
    return ServiceCategory::where('tenant_id', Auth::user()->tenant->id)
        ->select('id', 'name')
        ->orderBy('name')
        ->get();
}

    public function createCategory(): void
    {
        $this->validate([
            'newCategoryName' => [
                'required', 'string', 'max:255',
                Rule::unique('service_categories', 'name')->where('tenant_id', $this->tenantId),
            ],
        ]);

        $category = ServiceCategory::create([
            'tenant_id' => $this->tenantId,
            'name' => $this->newCategoryName,
            'status' => 'active',
        ]);

        $this->newCategoryName = '';
        $this->service_category_id = $category->id;
        unset($this->categories);
        $this->dispatch('category-created');

        session()->flash('message', 'Category created successfully!');
    }

    public function save(): void
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $imagePath = $this->image?->store('services', 'public');
                $service = Service::create([
                    'tenant_id' => $this->tenantId,
                    'service_category_id' => $this->service_category_id,
                    'name' => $this->name,
                    'image' => $imagePath,
                    'price' => $this->price,
                    'duration_minutes' => $this->duration_minutes,
                    'description' => $this->description,
                    'is_active' => $this->status === 'published',
                ]);

                if ($this->hasVariants && !empty($this->variants)) {
                    $valueImagePaths = $this->storeVariantValueImages('service-variants');

                    foreach ($this->variants as $i => $variant) {
                        $sku = 'SRV-' . strtoupper(Str::random(8)) . '-' . ($i + 1);
                        
                        ItemVariant::create([
                            'tenant_id' => $this->tenantId,
                            'service_id' => $service->id,
                            'product_id' => null,
                            'attributes' => $variant['attributes'],
                            'sku' => $sku,
                            'stock' => null, // Services don't have stock
                            'price_adjustment' => $variant['price_adjustment'] ?? 0,
                            'duration_adjustment' => $variant['duration_adjustment'] ?? 0,
                            'image' => $this->variantImagePathFor($variant['attributes'], $valueImagePaths),
                            'is_optional' => false,
                        ]);
                    }
                }

                Post::create([
                    'tenant_id' => $this->tenantId,
                    'created_by' => Auth::id(),
                    'service_category_id' => $this->service_category_id,
                    'product_category_id' => null,
                    'type' => 'service',
                    'inventory_type' => Service::class,
                    'inventory_id' => $service->id,
                    'name' => $this->name,
                    'image' => $imagePath,
                    'price' => $this->price,
                    'description' => $this->description,
                    'status' => $this->status,
                ]);
            });

            $count = $this->hasVariants ? count($this->variants) : 0;
            session()->flash('message', 'Service created successfully' . ($count ? " with {$count} option(s)!" : '!'));

            $this->reset(['name', 'service_category_id', 'price', 'duration_minutes', 'description', 'image', 'status', 'hasVariants']);
            $this->resetVariantBuilder();

        } catch (\Exception $e) {
            Log::error('Error saving service', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'tenant_id' => $this->tenantId
            ]);
            session()->flash('error', 'Failed to save service. Error: ' . $e->getMessage());
        }
    }

    public function editService(int $postId)
    {
        return redirect()->route('owner.update_service', $postId);
    }
};