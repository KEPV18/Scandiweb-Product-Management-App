document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('delete-product-btn').addEventListener('click', function() {
        const selectedProducts = Array.from(document.querySelectorAll('.delete-checkbox:checked')).map(cb => cb.value);
        if (selectedProducts.length > 0) {
            const form = document.getElementById('mass-delete-form');
            // إزالة أي مدخلات مخفية سابقة لتجنب التكرار
            document.querySelectorAll('input[name="product_ids[]"]').forEach(input => input.remove());

            // إضافة معرفات المنتجات المحددة كمصفوفة
            selectedProducts.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'product_ids[]'; // تأكد من أن الاسم هو نفسه
                input.value = id;
                form.appendChild(input);
            });

            // إرسال النموذج
            form.submit();
        } 
        // else { // إزالة رسالة التنبيه
        //     alert('يرجى تحديد منتج واحد على الأقل للحذف.'); // تم التعليق على هذه السطر
        // }
    });
});


        // Toggle edit form visibility
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.bg-card'); // العثور على الحاوية (البطاقة) التي تحتوي على الزر والنموذج
                const editForm = card.querySelector('.edit-form'); // العثور على النموذج داخل هذه الحاوية
                console.log('Edit Form:', editForm); // سجل للتحقق من وجود النموذج
                if (editForm) { // تحقق من وجود النموذج
                    editForm.classList.toggle('hidden'); // إظهار أو إخفاء النموذج
                }
            });
        });

        // Cancel button functionality
        document.querySelectorAll('.cancel-button').forEach(button => {
            button.addEventListener('click', function() {
                const editForm = this.closest('.edit-form'); // العثور على النموذج
                console.log('Cancel Edit Form:', editForm); // سجل للتحقق من وجود النموذج
                if (editForm) { // تحقق من وجود النموذج
                    editForm.classList.add('hidden'); // إخفاء النموذج عند النقر على "Cancel"
                }
            });
        }); // {{ edit_1 }} إزالة القوس الزائد هنا

    // عند تحميل الصفحة، تأكد من أن عرض البطاقات هو العرض الافتراضي
    document.addEventListener('DOMContentLoaded', function() {
        const cardsView = document.getElementById('cards-view');
        cardsView.classList.remove('hidden'); // إظهار عرض البطاقات
    });
