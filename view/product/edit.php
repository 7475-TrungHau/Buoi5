<?php
ob_start(); // Start output buffering
?>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-edit mr-2"></i>Edit Product
        </h1>
        <a href="/product" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition-all flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <form action="/product/update" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="id" value="<?php echo $product->id; ?>">

        <!-- Product Name -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product->name); ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter product name">
                <?php if (isset($errors['name'])): ?>
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?php echo $errors['name']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" name="price" id="price" step="0.01" min="0" value="<?php echo $product->price; ?>" required
                        class="w-full pl-7 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="0.00">
                </div>
                <?php if (isset($errors['price'])): ?>
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?php echo $errors['price']; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Category and Image -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select a category</option>
                    <?php
                    foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id ?>" <?php echo $product->category_id == $category->id ? 'selected' : ''; ?>>
                            <?php echo $category->name ?>
                        </option>
                    <?php }
                    ?>
                </select>
                <?php if (isset($errors['category_id'])): ?>
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?php echo $errors['category_id']; ?></p>
                <?php endif; ?>
            </div>

            <div class="md:col-span-2">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>

                <!-- Image Source Selection -->
                <div class="mb-3">
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="image_source" value="file" checked class="form-radio" onclick="toggleImageSource('file')">
                            <span class="ml-2">Upload Image</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="image_source" value="url" class="form-radio" onclick="toggleImageSource('url')">
                            <span class="ml-2">Image URL</span>
                        </label>
                    </div>
                </div>

                <!-- File Upload Option -->
                <div id="file-upload-option" class="flex items-center">
                    <div class="w-full">
                        <label class="flex flex-col items-center px-4 py-2 bg-white text-blue-500 rounded-lg border border-blue-500 cursor-pointer hover:bg-blue-500 hover:text-white transition-colors">
                            <i class="fas fa-cloud-upload-alt text-xl mb-1"></i>
                            <span class="text-sm">Choose file</span>
                            <input type="file" name="image" id="image-file" class="hidden" accept="image/*" onchange="previewImage(this, 'file')">
                        </label>
                    </div>
                    <div class="ml-4">
                        <img id="file-preview" src="#" alt="Preview" class="h-16 w-16 object-cover rounded-lg border hidden">
                    </div>
                </div>

                <!-- URL Option -->
                <div id="url-upload-option" class="hidden flex items-center">
                    <div class="w-full">
                        <input type="url" name="image_url" id="image-url" placeholder="https://example.com/image.jpg"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="previewImage(this, 'url')">
                    </div>
                    <div class="ml-4">
                        <img id="url-preview" src="#" alt="Preview" class="h-16 w-16 object-cover rounded-lg border hidden">
                    </div>
                </div>

                <p class="text-gray-500 text-xs mt-1">Supported formats: JPG, PNG, GIF (Max size: 2MB)</p>
                <p class="text-gray-500 text-xs mt-1">Leave blank to keep the current image.</p>
                <?php if (isset($errors['image'])): ?>
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?php echo $errors['image']; ?></p>
                <?php endif; ?>
            </div>

            <script>
                function toggleImageSource(source) {
                    if (source === 'file') {
                        document.getElementById('file-upload-option').classList.remove('hidden');
                        document.getElementById('url-upload-option').classList.add('hidden');
                    } else {
                        document.getElementById('file-upload-option').classList.add('hidden');
                        document.getElementById('url-upload-option').classList.remove('hidden');
                    }
                }

                function previewImage(input, type) {
                    const previewId = type === 'file' ? 'file-preview' : 'url-preview';
                    const preview = document.getElementById(previewId);

                    if (type === 'file') {
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    } else {
                        // URL type
                        if (input.value) {
                            preview.src = input.value;
                            preview.classList.remove('hidden');
                            preview.onerror = function() {
                                preview.classList.add('hidden');
                                alert('Invalid image URL');
                            }
                        }
                    }
                }
            </script>
        </div>
</div>

<!-- Description -->
<div>
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
    <textarea name="description" id="description" rows="5" required
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        placeholder="Enter product description"><?php echo htmlspecialchars($product->description); ?></textarea>
    <?php if (isset($errors['description'])): ?>
        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?php echo $errors['description']; ?></p>
    <?php endif; ?>
</div>

<!-- Form Actions -->
<div class="flex justify-end space-x-3 border-t border-gray-200 pt-5">
    <button type="button" onclick="window.location='/product'"
        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
        Cancel
    </button>
    <button type="submit"
        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow transition-colors">
        <i class="fas fa-save mr-2"></i>Save Changes
    </button>
</div>
</form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/layout.php';
?>