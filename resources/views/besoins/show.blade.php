<x-app-layout title="{{ $besoin->description }}">
  <section class="hello">
    <div>
      <h1>Détail du besoin</h1>
      <p>Informations complètes sur ce besoin prioritaire.</p>
    </div>
    <a href="{{ route('besoins.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="duo">
    <div class="card">
      <div class="card-head">
        <h3>Description</h3>
        @php
          $statutClass = match($besoin->statut) {
            'traite' => 'off2',
            'rejete' => 'wait',
            default  => 'pending'
          };
        @endphp
        <span class="chip {{ $statutClass }}">{{ $besoin->statut_label }}</span>
      </div>

      <p style="font-size:16px;line-height:1.65;margin-bottom:24px">{{ $besoin->description }}</p>

      <div class="info-row">
        <span class="info-label">Canton</span>
        <span class="info-value">{{ $besoin->canton->nom }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Priorité</span>
        <span class="info-value">
          @php
            $prioriteClass = match($besoin->priorite) {
              'haute'  => 'wait',
              'basse'  => 'off2',
              default  => ''
            };
          @endphp
          <span class="chip {{ $prioriteClass }}">{{ $besoin->priorite_label }}</span>
        </span>
      </div>
      <div class="info-row">
        <span class="info-label">Ajouté par</span>
        <span class="info-value">{{ $besoin->creePar->nom_complet }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Date d'ajout</span>
        <span class="info-value">{{ $besoin->created_at->translatedFormat('d F Y') }}</span>
      </div>

      @if($besoin->statut === 'en_cours')
        <div style="display:flex;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid var(--line)">
          <form method="POST" action="{{ route('besoins.update', $besoin) }}">
            @csrf @method('PATCH')
            <input type="hidden" name="statut" value="traite">
            <button type="submit" class="btn-ok">
              <svg class="i"><use href="#i-check"/></svg>Marquer comme traité
            </button>
          </form>
          <form method="POST" action="{{ route('besoins.update', $besoin) }}">
            @csrf @method('PATCH')
            <input type="hidden" name="statut" value="rejete">
            <button type="submit" class="btn-no">Rejeter</button>
          </form>
        </div>
      @endif
    </div>

    <div class="card">
      <div class="card-head">
        <h3>Statut actuel</h3>
      </div>
      <div style="text-align:center;padding:20px 0">
        @if($besoin->statut === 'traite')
          <div style="width:56px;height:56px;border-radius:50%;background:var(--ok-soft);color:var(--ok);display:grid;place-items:center;margin:0 auto 12px">
            <svg class="i" style="width:28px;height:28px"><use href="#i-check"/></svg>
          </div>
          <b style="font-size:16px;color:var(--ok)">Traité</b>
          <p style="color:var(--muted);font-size:13.5px;margin-top:4px">Ce besoin a été pris en compte.</p>
        @elseif($besoin->statut === 'rejete')
          <div style="width:56px;height:56px;border-radius:50%;background:var(--laterite-soft);color:var(--laterite);display:grid;place-items:center;margin:0 auto 12px">
            <svg class="i" style="width:28px;height:28px"><use href="#i-x"/></svg>
          </div>
          <b style="font-size:16px;color:var(--laterite)">Rejeté</b>
          <p style="color:var(--muted);font-size:13.5px;margin-top:4px">Ce besoin a été rejeté.</p>
        @else
          <div style="width:56px;height:56px;border-radius:50%;background:#fff8e6;color:#9a6b0a;display:grid;place-items:center;margin:0 auto 12px">
            <svg class="i" style="width:28px;height:28px"><use href="#i-clock"/></svg>
          </div>
          <b style="font-size:16px;color:#9a6b0a">En attente</b>
          <p style="color:var(--muted);font-size:13.5px;margin-top:4px">Ce besoin est en cours de traitement.</p>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
