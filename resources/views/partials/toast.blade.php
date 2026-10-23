<div class="toast" id="toast" role="status" aria-live="polite">
  @if(session('succes'))
    {{ session('succes') }}
  @endif
</div>

@push('scripts')
  @if(session('succes'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('succes') }}');
      });
    </script>
  @endif
@endpush
