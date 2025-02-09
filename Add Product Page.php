<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Scandiweb Test Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            margin-right: 10px;
        }
        #error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Add New Product</h1>
    <form id="product_form">
        <div id="error-message" style="display:none;"></div>

        <!-- SKU Field -->
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" required>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <!-- Price Field -->
        <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>

        <!-- Product Type Selector -->
        <div class="form-group">
            <label for="productType">Product Type</label>
            <select id="productType" name="productType" required>
                <option value="" disabled selected>Select a type</option>
                <option value="dvd">DVD</option>
                <option value="book">Book</option>
                <option value="furniture">Furniture</option>
            </select>
        </div>

        <!-- Product-Specific Attributes -->
        <div id="productAttributes">
            <!-- DVD Size -->
            <div id="dvdAttributes" style="display:none;">
                <label for="size">Size (MB):</label>
                <input type="number" id="size" name="size" step="0.01">
            </div>

            <!-- Book Weight -->
            <div id="bookAttributes" style="display:none;">
                <label for="weight">Weight (Kg):</label>
                <input type="number" id="weight" name="weight" step="0.01">
            </div>

            <!-- Furniture Dimensions -->
            <div id="furnitureAttributes" style="display:none;">
                <label for="height">Height (CM):</label>
                <input type="number" id="height" name="height" step="0.01">
                <label for="width">Width (CM):</label>
                <input type="number" id="width" name="width" step="0.01">
                <label for="length">Length (CM):</label>
                <input type="number" id="length" name="length" step="0.01">
            </div>
        </div>

        <!-- Save and Cancel Buttons -->
        <button type="button" onclick="saveProduct()">Save</button>
        <button type="button" onclick="cancelProduct()">Cancel</button>
    </form>

    <script>
        // Show/hide product-specific attributes based on selected type
        document.getElementById('productType').addEventListener('change', function () {
            const productType = this.value;
            const dvdAttributes = document.getElementById('dvdAttributes');
            const bookAttributes = document.getElementById('bookAttributes');
            const furnitureAttributes = document.getElementById('furnitureAttributes');

            dvdAttributes.style.display = 'none';
            bookAttributes.style.display = 'none';
            furnitureAttributes.style.display = 'none';

            if (productType === 'dvd') {
                dvdAttributes.style.display = 'block';
            } else if (productType === 'book') {
                bookAttributes.style.display = 'block';
            } else if (productType === 'furniture') {
                furnitureAttributes.style.display = 'block';
            }
        });

        // Save product function
        function saveProduct() {
            const errorMessage = document.getElementById('error-message');
            errorMessage.style.display = 'none';
            errorMessage.textContent = '';

            const sku = document.getElementById('sku').value.trim();
            const name = document.getElementById('name').value.trim();
            const price = document.getElementById('price').value.trim();
            const productType = document.getElementById('productType').value;

            if (!sku || !name || !price || !productType) {
                errorMessage.textContent = 'Please, submit required data';
                errorMessage.style.display = 'block';
                return;
            }

            let isValid = true;

            switch (productType) {
                case 'dvd':
                    if (!document.getElementById('size').value.trim()) {
                        isValid = false;
                    }
                    break;
                case 'book':
                    if (!document.getElementById('weight').value.trim()) {
                        isValid = false;
                    }
                    break;
                case 'furniture':
                    if (!document.getElementById('height').value.trim() ||
                        !document.getElementById('width').value.trim() ||
                        !document.getElementById('length').value.trim()) {
                        isValid = false;
                    }
                    break;
            }

            if (!isValid) {
                errorMessage.textContent = 'Please, provide the data of indicated type';
                errorMessage.style.display = 'block';
                return;
            }

            alert('Product added successfully!');
            window.location.href = '/'; // Redirect to product list page
        }

        // Cancel product function
        function cancelProduct() {
            window.location.href = '/'; // Redirect to product list page
        }
    </script>
</body>
</html>