<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
?>
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-box-open mr-2"></i>Product List
        </h1>
        <a href="/product/create" class="btn-primary flex items-center">
            <i class="fas fa-plus mr-2"></i>Create Product
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div class="w-full md:w-1/3 mb-4 md:mb-0">
            <div class="relative">
                <input type="text" placeholder="Search products..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="absolute right-0 top-0 mt-2 mr-4">
                    <i class="fas fa-search text-gray-500"></i>
                </button>
            </div>
        </div>

        <div class="w-full md:w-auto flex flex-wrap justify-end space-x-2">
            <select class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <option value="1">Category 1</option>
                <option value="2">Category 2</option>
            </select>

            <select class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- Products Table -->
    <div class="overflow-x-auto bg-white rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 table-hover">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <i class="fas fa-info-circle mr-2"></i>No products found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $product->id; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?php echo $product->name; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm text-green-800 bg-green-100 rounded-full">
                                    $<?php echo number_format($product->price, 2); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate"><?php echo $product->description; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                                    <?php echo $product->category_name; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (isset($product->image) && !empty($product->image)): ?>
                                    <img src="<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>"
                                        class="h-10 w-10 rounded-full object-cover border">
                                <?php else: ?>
                                    <span class="px-2 py-1 text-sm text-gray-800 bg-gray-100 rounded-full">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <a href="/product/show?id=<?php echo $product->id; ?>" class="btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/product/edit?id=<?php echo $product->id; ?>" class="btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/product/delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                                        <button type="submit" class="btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-6">
        <div class="flex items-center">
            <span class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
            </span>
        </div>
        <div class="flex space-x-2">
            <a href="#" class="px-3 py-1 border rounded hover:bg-gray-50">Previous</a>
            <a href="#" class="px-3 py-1 border rounded bg-blue-500 text-white">1</a>
            <a href="#" class="px-3 py-1 border rounded hover:bg-gray-50">2</a>
            <a href="#" class="px-3 py-1 border rounded hover:bg-gray-50">Next</a>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = '/product/delete?id=' + id;
        }
    }
</script>

<?php
// Lưu nội dung HTML từ bộ đệm vào biến $content
$content = ob_get_clean();

// Bao gồm layout và chèn nội dung
include __DIR__ . '/../layout/layout.php';
?>