<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
    <script type="text/javascript">
        window.tailwind.config = {
            darkMode: ['class'],
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))'
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))'
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))'
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))'
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))'
                        },
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style type="text/tailwindcss">
        @layer base {
            :root {
                --background: 0 0% 100%;
                --foreground: 240 10% 3.9%;
                --card: 0 0% 100%;
                --card-foreground: 240 10% 3.9%;
                --popover: 0 0% 100%;
                --popover-foreground: 240 10% 3.9%;
                --primary: 240 5.9% 10%;
                --primary-foreground: 0 0% 98%;
                --secondary: 240 4.8% 95.9%;
                --secondary-foreground: 240 5.9% 10%;
                --muted: 240 4.8% 95.9%;
                --muted-foreground: 240 3.8% 46.1%;
                --accent: 240 4.8% 95.9%;
                --accent-foreground: 240 5.9% 10%;
                --destructive: 0 84.2% 60.2%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 5.9% 90%;
                --input: 240 5.9% 90%;
                --ring: 240 5.9% 10%;
                --radius: 0.5rem;
            }
            .dark {
                --background: 240 10% 3.9%;
                --foreground: 0 0% 98%;
                --card: 240 10% 3.9%;
                --card-foreground: 0 0% 98%;
                --popover: 240 10% 3.9%;
                --popover-foreground: 0 0% 98%;
                --primary: 0 0% 98%;
                --primary-foreground: 240 5.9% 10%;
                --secondary: 240 3.7% 15.9%;
                --secondary-foreground: 0 0% 98%;
                --muted: 240 3.7% 15.9%;
                --muted-foreground: 240 5% 64.9%;
                --accent: 240 3.7% 15.9%;
                --accent-foreground: 0 0% 98%;
                --destructive: 0 62.8% 30.6%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 3.7% 15.9%;
                --input: 240 3.7% 15.9%;
                --ring: 240 4.9% 83.9%;
            }
        }
    </style>
    
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-green-500 text-white p-4 rounded mb-4">
        Product added successfully!
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        Error: <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<div class="min-h-screen bg-background text-foreground p-4">
    <div class="max-w-2xl mx-auto bg-card p-8 rounded-lg shadow-lg transition-transform transform hover:scale-105">
        <div class="flex items-center mb-6">
            <i class="fas fa-shopping-cart mr-3"></i>
            <h1 class="text-4xl font-bold text-primary">Add New Product</h1>
        </div>
        <form action="add_product.php" method="POST" id="product_form" class="space-y-6">
            <div>
                <label for="sku-1" class="block text-sm font-medium text-muted-foreground">SKU</label>
                <input id="sku" name="sku" type="text" placeholder="Enter SKU" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-muted-foreground">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter product name" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-muted-foreground">Price</label>
                <input type="number" id="price" name="price" placeholder="Enter price" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
            </div>
            <div>
                <label for="productType" class="block text-sm font-medium text-muted-foreground">Product Type</label>
                <select id="productType" name="productType" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
                    <option value="">Select a type</option>
                    <option value="DVD">DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>
                </select>
            </div>
            <div id="additionalFields" class="space-y-4"></div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-primary text-primary-foreground p-3 rounded-md shadow-md hover:bg-primary/80 transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Save
                </button>
                <button type="button" class="bg-destructive text-destructive-foreground p-3 rounded-md shadow-md hover:bg-destructive/80 transition duration-200 flex items-center" onclick="window.location.href='index.php'">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('productType').addEventListener('change', function() {
        const additionalFields = document.getElementById('additionalFields');
        additionalFields.innerHTML = '';
        switch (this.value) {
            case 'DVD':
                additionalFields.innerHTML = `
                    <div class="transition-opacity duration-500 opacity-0" id="dvdFields">
                        <label for="size" class="block text-sm font-medium text-muted-foreground">Size (MB)</label>
                        <input type="number" id="size" name="size" placeholder="Enter size in MB" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
                    </div>
                `;
                setTimeout(() => document.getElementById('dvdFields').classList.add('opacity-100'), 0);
                break;
            case 'Book':
                additionalFields.innerHTML = `
                    <div class="transition-opacity duration-500 opacity-0" id="bookFields">
                        <label for="weight" class="block text-sm font-medium text-muted-foreground">Weight (KG)</label>
                        <input type="number" id="weight" name="weight" placeholder="Enter weight in KG" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
                    </div>
                `;
                setTimeout(() => document.getElementById('bookFields').classList.add('opacity-100'), 0);
                break;
            case 'Furniture':
                additionalFields.innerHTML = `
                    <div class="transition-opacity duration-500 opacity-0" id="furnitureFields">
                        <label for="height" class="block text-sm font-medium text-muted-foreground">Height (CM)</label>
                        <input type="number" id="height" name="height" placeholder="Enter height in CM" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
                    </div>
                    <div class="transition-opacity duration-500 opacity-0" id="furnitureFields2">
                        <label for="width" class="block text-sm font-medium text-muted-foreground">Width (CM)</label>
                        <input type="number" id="width" name="width" placeholder="Enter width in CM" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
                    </div>
                    <div class="transition-opacity duration-500 opacity-0" id="furnitureFields3">
                        <label for="length" class="block text-sm font-medium text-muted-foreground">Length (CM)</label>
                        <input type="number" id="length" name="length" placeholder="Enter length in CM" class="mt-1 block w-full p-3 border border-border rounded-md bg-input text-foreground shadow-sm focus:ring focus:ring-primary transition duration-200 hover:border-primary" required>
                    </div>
                `;
                setTimeout(() => {
                    document.getElementById('furnitureFields').classList.add('opacity-100');
                    document.getElementById('furnitureFields2').classList.add('opacity-100');
                    document.getElementById('furnitureFields3').classList.add('opacity-100');
                }, 0);
                break;
        }
    });
</script>
<footer class="bg-gray-100 text-center py-4 w-full fixed bottom-0">
    <p class="text-gray-600">Scandiweb Test assignment</p>
</footer>
</body>
</html>