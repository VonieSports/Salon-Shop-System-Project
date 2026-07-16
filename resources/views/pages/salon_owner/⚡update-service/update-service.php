<?php

use App\Models\ItemVariant;
use App\Models\Post;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layoust.salon_owner')] class extends Component
{

   use WithFileUploads;

    public $postId;
    public $name;
    public $description;
    public $status;
    public $image;
    public $existingImage;

    public $serviceId;
    public $category_id;
    public $price;
    public $duration_minutes;

    public $hasVariants = false;
    public $variants = [];
    public $existingVariants = [];
    public $variantImages = [];

    public $post;
    public $service;

    public function mount($id): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->postId = $id;

        $this->post = Post::where('tenant_id', $tenant->id)
            ->where('created_by', Auth::id())
            ->where('type', 'service')
            ->where('id', $id)
            ->firstOrFail();

        $this->service = Service::where('tenant_id', $tenant->id)
            ->where('id', $this->post->inventory_id)
            ->firstOrFail();

        $this->name = $this->post->name;
        $this->description = $this->post->description;
        $this->status = $this->post->status;
        $this->existingImage = $this->post->image;

        $this->serviceId = $this->service->id;
        $this->category_id = $this->service->service_category_id;
        $this->price = $this->service->price;
        $this->duration_minutes = $this->service->duration_minutes;

        $this->existingVariants = ItemVariant::where('service_id', $this->serviceId)
            ->where('tenant_id', $tenant->id)
            ->get()
            ->toArray();

        $this->hasVariants = count($this->existingVariants) > 0;
        $this->variants = $this->existingVariants;
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'variantImages.*' => 'nullable|image|max:2048',
        ];

        if ($this->hasVariants) {
            $rules['variants.*.price_adjustment'] = 'nullable|numeric';
            $rules['variants.*.duration_adjustment'] = 'nullable|integer';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $imagePath = $this->existingImage;
            if ($this->image) {
                if ($this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }
                $imagePath = $this->image->store('services', 'public');
            }

            $this->post->update([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
                'image' => $imagePath,
                'price' => $this->price,
            ]);

            $this->service->update([
                'service_category_id' => $this->category_id,
                'name' => $this->name,
                'image' => $imagePath,
                'price' => $this->price,
                'duration_minutes' => $this->duration_minutes,
                'description' => $this->description,
                'is_active' => $this->status === 'published',
            ]);

            $this->syncVariants();
        });

        session()->flash('message', 'Service updated successfully!');
        return redirect()->route('owner.service_management');
    }

    private function syncVariants(): void
    {
        if (!$this->hasVariants) {
            ItemVariant::where('service_id', $this->serviceId)
                ->where('tenant_id', Auth::user()->tenant->id)
                ->delete();
            return;
        }

        $currentIds = collect($this->variants)
            ->filter(fn($v) => isset($v['id']))
            ->pluck('id')
            ->toArray();

        ItemVariant::where('service_id', $this->serviceId)
            ->where('tenant_id', Auth::user()->tenant->id)
            ->whereNotIn('id', $currentIds)
            ->delete();

        foreach ($this->variants as $index => $variant) {
            $variantImagePath = $variant['image'] ?? null;
            
            if (isset($this->variantImages[$index]) && $this->variantImages[$index]) {
                if ($variantImagePath && !str_contains($variantImagePath, 'temporary')) {
                    Storage::disk('public')->delete($variantImagePath);
                }
                $variantImagePath = $this->variantImages[$index]->store('service-variants', 'public');
            } elseif (isset($variant['existing_image']) && $variant['existing_image']) {
                $variantImagePath = $variant['existing_image'];
            }

            $data = [
                'tenant_id' => Auth::user()->tenant->id,
                'service_id' => $this->serviceId,
                'product_id' => null,
                'attributes' => $variant['attributes'],
                'stock' => null,
                'price_adjustment' => $variant['price_adjustment'] ?? 0,
                'duration_adjustment' => $variant['duration_adjustment'] ?? 0,
                'image' => $variantImagePath,
                'is_optional' => false,
            ];

            if (isset($variant['id']) && $variant['id']) {
                ItemVariant::where('id', $variant['id'])->update($data);
            } else {
                $data['sku'] = 'SRV-' . strtoupper(Str::random(8));
                ItemVariant::create($data);
            }
        }
    }

    public function removeImage()
{
    if ($this->existingImage) {
        Storage::disk('public')->delete($this->existingImage);
        $this->existingImage = null;
    }
    $this->image = null;
    session()->flash('message', 'Image removed successfully.');
}

    #[Computed]
    public function categories()
    {
        return ServiceCategory::where('tenant_id', Auth::user()->tenant->id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

public $showConfirmationModal = false;
public $confirmationTitle = 'Remove this Image?';
public $confirmationMessage = 'This action cannot be undone. The image will be permanently deleted.';
public $confirmationAction = null;
public $confirmationData = null;

public function confirmRemoveVariantImage($index)
{
    $this->confirmationTitle = 'Remove this Image?';
    $this->confirmationMessage = 'This action cannot be undone. The image will be permanently deleted.';
    $this->confirmationAction = 'removeVariantImage';
    $this->confirmationData = $index;
    $this->showConfirmationModal = true;
}

public function confirmAction()
{
    if ($this->confirmationAction === 'removeVariantImage' && $this->confirmationData !== null) {
        $this->removeVariantImage($this->confirmationData);
    }
    $this->showConfirmationModal = false;
    $this->confirmationData = null;
    $this->confirmationAction = null;
}

public function cancelConfirmation()
{
    $this->showConfirmationModal = false;
    $this->confirmationData = null;
    $this->confirmationAction = null;
}

public function removeVariantImage($index)
{
    if (isset($this->variants[$index]['image']) && $this->variants[$index]['image']) {
        Storage::disk('public')->delete($this->variants[$index]['image']);
    }
    $this->variants[$index]['image'] = null;
    $this->variants[$index]['existing_image'] = null;
    unset($this->variantImages[$index]);
    
    session()->flash('message', 'Image removed successfully.');
}
};