<x-app-layout title="Détail de la plainte">
  <section class="hello">
    <div>
      <h1>Détail de la plainte</h1>
      <p>Informations complètes sur cette plainte.</p>
    </div>
    <a href="{{ route('plaintes.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="duo">
    <div class="card">
      <div class="card-head">
        <h3>Description</h3>
        @php
          $statutClass = match($plainte->statut_validation) {
            'valide' => 'off2',
            'rejete' => 'wait',
            default  => 'pending'
          };
        @endphp
        <span class="chip {{ $statutClass }}">{{ $plainte->statut_validation_label }}</span>
      </div>

      <p style="font-size:16px;line-height:1.65;margin-bottom:24px">{{ $plainte->description }}</p>

      @if($plainte->photo)
        <div style="margin-bottom:24px">
          <img src="{{ asset('storage/' . $plainte->photo) }}" alt="Photo de la plainte" style="max-width:100%;border-radius:8px;border:1px solid var(--line)">
        </div>
      @endif

      <div class="info-row">
        <span class="info-label">Type de plainte</span>
        <span class="info-value">
          <span class="chip">{{ $plainte->type_plainte_label }}</span>
        </span>
      </div>
      <div class="info-row">
        <span class="info-label">Plaignant</span>
        <span class="info-value">
          @if($plainte->creePar)
            {{ $plainte->creePar->nom_complet }}
          @else
            <strong>{{ $plainte->prenom }} {{ $plainte->nom }}</strong>
            @if($plainte->telephone)
              <br><a href="tel:{{ $plainte->telephone }}" style="color:inherit;text-decoration:none">
                <svg class="i" style="width:11px;height:11px;vertical-align:-2px;display:inline"><use href="#i-phone"/></svg>
                {{ $plainte->telephone }}
              </a>
            @endif
          @endif
        </span>
      </div>
      <div class="info-row">
        <span class="info-label">Date de soumission</span>
        <span class="info-value">{{ $plainte->created_at->translatedFormat('d F Y') }}</span>
      </div>

      @if($plainte->statut_validation === 'en_attente')
        <div style="display:flex;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid var(--line)">
          <form method="POST" action="{{ route('plaintes.valider', $plainte) }}">
            @csrf
            <button type="submit" class="btn-ok">
              <svg class="i"><use href="#i-check"/></svg>Valider
            </button>
          </form>
          <form method="POST" action="{{ route('plaintes.rejeter', $plainte) }}">
            @csrf
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
        @if($plainte->statut_validation === 'valide')
          <div style="width:56px;height:56px;border-radius:50%;background:var(--ok-soft);color:var(--ok);display:grid;place-items:center;margin:0 auto 12px">
            <svg class="i" style="width:28px;height:28px"><use href="#i-check"/></svg>
          </div>
          <b style="font-size:16px;color:var(--ok)">Validée</b>
          <p style="color:var(--muted);font-size:13.5px;margin-top:4px">Cette plainte a été validée.</p>
        @elseif($plainte->statut_validation === 'rejete')
          <div style="width:56px;height:56px;border-radius:50%;background:var(--laterite-soft);color:var(--laterite);display:grid;place-items:center;margin:0 auto 12px">
            <svg class="i" style="width:28px;height:28px"><use href="#i-x"/></svg>
          </div>
          <b style="font-size:16px;color:var(--laterite)">Rejetée</b>
          <p style="color:var(--muted);font-size:13.5px;margin-top:4px">Cette plainte a été rejetée.</p>
        @else
          <div style="width:56px;height:56px;border-radius:50%;background:#fff8e6;color:#9a6b0a;display:grid;place-items:center;margin:0 auto 12px">
            <svg class="i" style="width:28px;height:28px"><use href="#i-clock"/></svg>
          </div>
          <b style="font-size:16px;color:#9a6b0a">En attente</b>
          <p style="color:var(--muted);font-size:13.5px;margin-top:4px">Cette plainte est en attente de validation.</p>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
