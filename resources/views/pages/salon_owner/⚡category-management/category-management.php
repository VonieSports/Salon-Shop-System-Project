<?php

use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.salon_owner')] class extends Component
{
    public $type = 'product';
    public $categories = [];
    public $editMode = false;
    public $editingId = null;
    public $name = '';
    public $search = '';

    public function mount($type = 'product')
    {
        $this->type = $type;
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $tenantId = Auth::user()->tenant->id;
        
        if ($this->type === 'product') {
            $this->categories = ProductCategory::where('tenant_id', $tenantId)
                ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy('name')
                ->get();
        } else {
            $this->categories = ServiceCategory::where('tenant_id', $tenantId)
                ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy('name')
                ->get();
        }
    }

    public function updatedSearch()
    {
        $this->loadCategories();
    }

    public function edit($id)
    {
        $this->editMode = true;
        $this->editingId = $id;
        
        $category = $this->categories->firstWhere('id', $id);
        if ($category) {
            $this->name = $category->name;
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $tenantId = Auth::user()->tenant->id;
        
        if ($this->type === 'product') {
            ProductCategory::where('tenant_id', $tenantId)
                ->where('id', $this->editingId)
                ->update(['name' => $this->name]);
        } else {
            ServiceCategory::where('tenant_id', $tenantId)
                ->where('id', $this->editingId)
                ->update(['name' => $this->name]);
        }

        $this->reset(['editMode', 'editingId', 'name']);
        $this->loadCategories();
        session()->flash('message', 'Category updated successfully!');
    }

    public function delete($id)
    {
        $tenantId = Auth::user()->tenant->id;
        
        if ($this->type === 'product') {
            ProductCategory::where('tenant_id', $tenantId)
                ->where('id', $id)
                ->delete();
        } else {
            ServiceCategory::where('tenant_id', $tenantId)
                ->where('id', $id)
                ->delete();
        }

        $this->loadCategories();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function cancelEdit()
    {
        $this->reset(['editMode', 'editingId', 'name']);
    }
};