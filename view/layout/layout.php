<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .table-hover tr:hover {
            background-color: #f3f4f6;
        }

        .btn-primary {
            @apply bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow transition-all;
        }

        .btn-success {
            @apply bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-3 rounded shadow transition-all;
        }

        .btn-info {
            @apply bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-1 px-3 rounded shadow transition-all;
        }

        .btn-danger {
            @apply bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded shadow transition-all;
        }

        /* Add some margin to the main content */
        main {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Add some padding to the form */
        .form-container {
            padding: 20px;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <?php include __DIR__ . '/header.php'; ?>

    <main class="flex-grow container mx-auto px-4 py-6">
        <div class="form-container">
            <?php echo $content; ?>
        </div>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>

    <script>
        // Highlight current navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');
            navLinks.forEach(link => {
                if (currentPath.includes(link.getAttribute('href'))) {
                    link.classList.add('text-blue-300', 'font-bold');
                }
            });
        });
    </script>
</body>

</html>