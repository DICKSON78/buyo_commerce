@extends('layouts.dashboards.seller')

@section('contents')
<!-- Product Creation Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl mx-auto shadow-xl">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </button>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Create New Product</h2>
            </div>
            <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Progress Steps -->
        <div class="px-6 pt-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">1</div>
                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Basic Info</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm">2</div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Details</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm">3</div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Media</span>
                </div>
            </div>
        </div>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            
            <!-- Step 1: Basic Information -->
            <div id="step1" class="step-content p-6">
                <!-- Product Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" 
                           placeholder="What are you selling?" required>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Product Type</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="product-type-option">
                            <input type="radio" name="product_type" value="physical" checked class="hidden">
                            <div class="option-content p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-center cursor-pointer transition-all hover:border-green-500">
                                <i class="fas fa-box text-gray-400 text-lg mb-1"></i>
                                <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">Physical</span>
                            </div>
                        </label>
                        
                        <label class="product-type-option">
                            <input type="radio" name="product_type" value="digital" class="hidden">
                            <div class="option-content p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-center cursor-pointer transition-all hover:border-green-500">
                                <i class="fas fa-file-pdf text-gray-400 text-lg mb-1"></i>
                                <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">Digital</span>
                            </div>
                        </label>
                        
                        <label class="product-type-option">
                            <input type="radio" name="product_type" value="ticket" class="hidden">
                            <div class="option-content p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-center cursor-pointer transition-all hover:border-green-500">
                                <i class="fas fa-ticket-alt text-gray-400 text-lg mb-1"></i>
                                <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">Ticket</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Next Button -->
                <button type="button" onclick="nextStep(2)" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-colors">
                    Continue
                </button>
            </div>

            <!-- Step 2: Pricing & Details -->
            <div id="step2" class="step-content p-6 hidden">
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Price (TZS) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">TZS</span>
                        <input type="number" name="price" value="{{ old('price') }}" 
                               class="w-full border border-gray-300 dark:border-gray-600 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" 
                               placeholder="0.00" step="0.01" min="0" required>
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 1) }}" 
                           class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" 
                           placeholder="How many?" min="0" required>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="4" 
                              class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 resize-none" 
                              placeholder="Describe your product..." required>{{ old('description') }}</textarea>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex space-x-3">
                    <button type="button" onclick="prevStep(1)" class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 py-3 rounded-xl font-medium transition-colors">
                        Back
                    </button>
                    <button type="button" onclick="nextStep(3)" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-colors">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 3: Media Upload -->
            <div id="step3" class="step-content p-6 hidden">
                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Product Images</label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-green-500 dark:hover:border-green-400 transition-colors cursor-pointer" onclick="document.getElementById('product-images').click()">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Tap to upload photos</p>
                        <p class="text-gray-500 dark:text-gray-500 text-xs">PNG, JPG up to 5MB</p>
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="product-images">
                    </div>
                </div>

                <!-- Image Preview -->
                <div id="image-preview" class="grid grid-cols-3 gap-3 mb-6 hidden">
                    <!-- Images will be previewed here -->
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-3">
                    <button type="button" onclick="prevStep(2)" class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 py-3 rounded-xl font-medium transition-colors">
                        Back
                    </button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-colors">
                        Post Product
                    </button>
                </div>

                <!-- Save as Draft -->
                <button type="button" onclick="saveAsDraft()" class="w-full mt-3 bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-xl font-medium transition-colors">
                    Save as Draft
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Main Dashboard Content (Your existing dashboard) -->
<div class="max-w-7xl mx-auto px-2 sm:px-4 pt-4 pb-20">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Seller Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome back, Track your Customers and Orders.</p>
            </div>
        </div>
        <!-- Add Product Button - Opens Modal -->
        <button onclick="openProductModal()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2 w-fit">
            <i class="fas fa-plus-circle"></i>
            <span>Add Product</span>
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 dark:bg-green-900 dark:border-green-700 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Rest of your existing dashboard content remains exactly the same -->
    <!-- Tabs Navigation -->
    <div class="mb-6">
        <div class="flex space-x-4 border-b border-gray-200 dark:border-gray-700" role="tablist">
            <button id="overviewTab" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-t-md focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="true" aria-controls="overview-section">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </button>
            <button id="productsTab" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-t-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="products-section">
                <i class="fas fa-boxes mr-2"></i> Manage Products
            </button>
            <button id="ordersTab" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-t-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="orders-section">
                <i class="fas fa-shopping-cart mr-2"></i> View Orders
            </button>
            <button id="messagesTab" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-t-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="messages-section">
                <i class="fas fa-comments mr-2"></i> Customer Messages
            </button>
        </div>
    </div>

    <!-- Your existing dashboard sections continue here... -->
    <!-- I'll keep them exactly as they are in your original code -->

</div>

<script>
    // Modal Functions
    function openProductModal() {
        document.getElementById('productModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetForm();
    }

    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function resetForm() {
        // Reset to step 1
        showStep(1);
        
        // Reset form fields
        document.getElementById('productForm').reset();
        
        // Clear image preview
        document.getElementById('image-preview').innerHTML = '';
        document.getElementById('image-preview').classList.add('hidden');
    }

    // Step Navigation
    function showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(step => {
            step.classList.add('hidden');
        });
        
        // Show current step
        document.getElementById('step' + stepNumber).classList.remove('hidden');
        
        // Update progress indicators
        updateProgress(stepNumber);
    }

    function nextStep(next) {
        // Basic validation before proceeding
        if (validateStep(next - 1)) {
            showStep(next);
        }
    }

    function prevStep(prev) {
        showStep(prev);
    }

    function updateProgress(currentStep) {
        // Reset all steps
        const steps = document.querySelectorAll('[class*="flex items-center space-x-2"]');
        steps.forEach((step, index) => {
            const number = step.querySelector('div');
            const text = step.querySelector('span');
            
            if (index + 1 === currentStep) {
                number.className = 'w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm';
                text.className = 'text-sm font-medium text-gray-800 dark:text-gray-200';
            } else if (index + 1 < currentStep) {
                number.className = 'w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm';
                text.className = 'text-sm font-medium text-gray-800 dark:text-gray-200';
            } else {
                number.className = 'w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm';
                text.className = 'text-sm font-medium text-gray-500 dark:text-gray-400';
            }
        });
    }

    function validateStep(step) {
        switch(step) {
            case 1:
                const name = document.querySelector('input[name="name"]');
                const category = document.querySelector('select[name="category_id"]');
                
                if (!name.value.trim()) {
                    alert('Please enter a product name');
                    name.focus();
                    return false;
                }
                
                if (!category.value) {
                    alert('Please select a category');
                    category.focus();
                    return false;
                }
                break;
                
            case 2:
                const price = document.querySelector('input[name="price"]');
                const description = document.querySelector('textarea[name="description"]');
                
                if (!price.value || parseFloat(price.value) <= 0) {
                    alert('Please enter a valid price');
                    price.focus();
                    return false;
                }
                
                if (!description.value.trim()) {
                    alert('Please enter a product description');
                    description.focus();
                    return false;
                }
                break;
        }
        return true;
    }

    // Image Preview Functionality
    const imageInput = document.getElementById('product-images');
    const imagePreview = document.getElementById('image-preview');

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            imagePreview.classList.remove('hidden');

            for (let file of this.files) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative group';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                            <button type="button" onclick="removeImage(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        imagePreview.appendChild(previewItem);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    function removeImage(button) {
        button.closest('.relative').remove();
        if (imagePreview.children.length === 0) {
            imagePreview.classList.add('hidden');
        }
    }

    // Product Type Selection
    document.querySelectorAll('.product-type-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.product-type-option .option-content').forEach(content => {
                content.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
                content.classList.add('border-gray-200', 'dark:border-gray-600');
            });
            
            // Add active class to selected option
            const content = this.querySelector('.option-content');
            content.classList.remove('border-gray-200', 'dark:border-gray-600');
            content.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        });
    });

    // Save as Draft
    function saveAsDraft() {
        const form = document.getElementById('productForm');
        const draftInput = document.createElement('input');
        draftInput.type = 'hidden';
        draftInput.name = 'status';
        draftInput.value = 'draft';
        form.appendChild(draftInput);
        form.submit();
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'productModal') {
            closeProductModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProductModal();
        }
    });
</script>

<style>
    .product-type-option input:checked + .option-content {
        border-color: #10b981;
        background: #f0fdf4;
    }
    
    .dark .product-type-option input:checked + .option-content {
        background: #064e3b;
        border-color: #10b981;
    }
    
    .step-content {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection