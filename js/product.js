// js/product.js
document.addEventListener('DOMContentLoaded', () => {
  const productForm = document.getElementById('productForm');
  const uploadInput = document.getElementById('product_image');
  const uploadBtn = document.getElementById('uploadImageBtn');
  const uploadedPathInput = document.getElementById('image_path');
  const productMsg = document.getElementById('productMessage');

  if (uploadBtn) {
    uploadBtn.addEventListener('click', async (e) => {
      e.preventDefault();
      if (!uploadInput.files[0]) { productMsg.textContent = 'Choose an image first'; return; }
      const fd = new FormData();
      fd.append('product_image', uploadInput.files[0]);
      const res = await fetch('actions/upload_product_image_action.php', { method:'POST', body:fd });
      const j = await res.json();
      productMsg.textContent = j.message;
      if (j.status === 'success') {
        uploadedPathInput.value = j.path;
        document.getElementById('preview').src = j.path;
      }
    });
  }

  if (productForm) {
    productForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(productForm);
      const action = fd.get('product_id') ? 'update_product' : 'add_product';
      fd.append('action', action);
      const res = await fetch('actions/product_actions.php', { method:'POST', body:fd });
      const j = await res.json();
      productMsg.textContent = j.message;
      if (j.status === 'success') productForm.reset();
    });
  }

});
