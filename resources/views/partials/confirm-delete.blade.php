<dialog id="confirmDeleteDialog">
  <form method="POST" action="" id="confirmDeleteForm">
    @csrf
    @method('DELETE')
    <div class="card" style="max-width: 400px; margin: 0;">
      <h3 style="margin-bottom: 12px;">Confirmer la suppression</h3>
      <p style="color: var(--muted); margin-bottom: 20px;">Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</p>
      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeDialog('confirmDeleteDialog')" class="btn-no">Annuler</button>
        <button type="submit" class="btn-ok">Supprimer</button>
      </div>
    </div>
  </form>
</dialog>

@push('scripts')
  <script>
    function confirmDelete(url, message) {
      const dialog = document.getElementById('confirmDeleteDialog');
      const form = document.getElementById('confirmDeleteForm');
      const title = dialog.querySelector('h3');
      if (message) title.textContent = message;
      form.action = url;
      openDialog('confirmDeleteDialog');
    }
  </script>
@endpush
