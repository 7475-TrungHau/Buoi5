<?php
ob_start(); // Start output buffering
?>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-info-circle mr-2"></i>Product Details
        </h1>
        <a href="/product" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition-all flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image Section -->
        <div class="flex justify-center">
            <div class="relative group">
                <img src="<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>"
                    class="rounded-lg shadow-md w-full h-auto object-cover max-h-[400px] transform group-hover:scale-[1.02] transition-transform duration-300">
                <div class="absolute inset-0 rounded-lg bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="flex flex-col">
            <div class="mb-4">
                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    <?php echo $product->name; ?>
                </span>
            </div>

            <h2 class="text-4xl font-bold text-gray-800 mb-4"><?php echo $product->name; ?></h2>

            <div class="flex items-center mb-6">
                <span class="text-3xl font-bold text-blue-600">$<?php echo number_format($product->price, 2); ?></span>
                <?php if (isset($product->old_price) && $product->old_price > $product->price): ?>
                    <span class="ml-3 text-lg text-gray-500 line-through">$<?php echo number_format($product->old_price, 2); ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-6 border-t border-b border-gray-200 py-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Description</h3>
                <div class="text-gray-600 leading-relaxed">
                    <?php echo nl2br(htmlspecialchars($product->description)); ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-auto flex space-x-3">
                <a href="/product/edit/<?php echo $product->id; ?>"
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition-colors flex items-center justify-center">
                    <i class="fas fa-edit mr-2"></i>Edit Product
                </a>
                <button type="button"
                    onclick="confirmDelete(<?php echo $product->id; ?>)"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition-colors flex items-center justify-center">
                    <i class="fas fa-trash-alt mr-2"></i>Delete
                </button>
            </div>
        </div>
    </div>

    <?php
    /* 
    // Temporarily commented out - Additional Information Section
    // Uncomment when needed
    if (isset($product->created_at) || isset($product->updated_at) || isset($product->sku) || isset($product->stock)): 
    ?>
        <div class="mt-10 border-t border-gray-200 pt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Additional Information</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <?php if (isset($product->sku)): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">SKU</p>
                        <p class="font-medium"><?php echo $product->sku; ?></p>
                    </div>
                <?php endif; ?>

                <?php if (isset($product->stock)): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Stock</p>
                        <p class="font-medium"><?php echo $product->stock; ?> units</p>
                    </div>
                <?php endif; ?>

                <?php if (isset($product->created_at)): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Added on</p>
                        <p class="font-medium"><?php echo date('M d, Y', strtotime($product->created_at)); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (isset($product->updated_at)): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="font-medium"><?php echo date('M d, Y', strtotime($product->updated_at)); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php 
    endif;
    */
    ?>
</div>

<script>
    function confirmDelete(productId) {
        if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            window.location.href = '/product/delete/' + productId;
        }
    }
</script>

<?php
// Save HTML content from buffer to $content variable
$content = ob_get_clean();

// Include layout and insert content
include __DIR__ . '/../layout/layout.php';
?>