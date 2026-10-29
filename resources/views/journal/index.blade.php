<x-app-layout title="Journal d'activité">
  <section class="hello">
    <div>
      <h1>Journal d'activité</h1>
      <p>Historique des actions sur la plateforme.</p>
    </div>
  </section>

  <div class="card">
    <ul class="log">
      @forelse($activites as $activite)
        <li>
          <b>{{ $activite->utilisateur->nom_complet }}</b>
          <span>{{ $activite->action }}</span>
          <time>{{ $activite->created_at->translatedFormat('d F Y à H:i') }}</time>
        </li>
      @empty
        <li style="color: var(--muted);">Aucune activité enregistrée.</li>
      @endforelse
    </ul>

    {{ $activites->links() }}
  </div>
</x-app-layout>
