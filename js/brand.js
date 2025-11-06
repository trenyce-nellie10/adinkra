// js/brand.js
document.addEventListener('DOMContentLoaded', () => {
  const addForm = document.getElementById('brandAddForm');
  const fetchBtn = document.getElementById('fetchBrandsBtn');
  const list = document.getElementById('brandsList');
  const msg = document.getElementById('brandMessage');

  async function fetchBrands() {
    const res = await fetch('actions/fetch_brand_action.php');
    const data = await res.json();
    list.innerHTML = data.map(b => `
      <div class="brand-row" data-id="${b.brand_id}">
        <strong>${b.brand_name}</strong> <small>(${b.cat_name})</small>
        <div class="actions">
          <button class="btn btn-link edit-brand">Edit</button>
          <button class="btn btn-danger delete-brand">Delete</button>
        </div>
      </div>
    `).join('');
  }

  if (fetchBtn) fetchBtn.addEventListener('click', fetchBrands);
  if (addForm) addForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(addForm);
    const res = await fetch('actions/add_brand_action.php', { method:'POST', body:fd });
    const j = await res.json();
    msg.textContent = j.message;
    if (j.status === 'success') { addForm.reset(); fetchBrands(); }
  });

  // delegate edit/delete
  list && list.addEventListener('click', async (e) => {
    const row = e.target.closest('.brand-row');
    if (!row) return;
    const id = row.dataset.id;
    if (e.target.classList.contains('delete-brand')) {
      if (!confirm('Delete this brand?')) return;
      const fd = new FormData(); fd.append('brand_id', id);
      const res = await fetch('actions/delete_brand_action.php', { method:'POST', body:fd});
      const j = await res.json(); msg.textContent = j.message; if (j.status === 'success') fetchBrands();
    }
    if (e.target.classList.contains('edit-brand')) {
      const name = prompt('New brand name', row.querySelector('strong').textContent);
      if (!name) return;
      const fd = new FormData(); fd.append('brand_id', id); fd.append('brand_name', name);
      const res = await fetch('actions/update_brand_action.php', { method:'POST', body:fd});
      const j = await res.json(); msg.textContent = j.message; if (j.status === 'success') fetchBrands();
    }
  });

  // initial fetch
  fetchBrands();
});
