<x-app-layout title="Tableau de bord">

  {{-- Hero header --}}
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Vue d'ensemble
      </div>
      <h1>Tableau de bord</h1>
      <p>Bienvenue, <strong>{{ auth()->user()->nom_complet }}</strong>. Voici l'activité du conseil municipal.</p>
    </div>
  </section>

  {{-- QUICK ACTIONS --}}
  <div class="quick-grid">
    @can('gerer')
      <a class="card" href="{{ route('besoins.create') }}" style="padding:16px;text-decoration:none">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
          <div class="ico" style="background:var(--laterite-soft);color:var(--laterite)">
            <svg class="i"><use href="#i-pin"/></svg>
          </div>
          <b style="color:var(--ink)">Nouveau besoin</b>
        </div>
        <p style="font-size:13px;color:var(--muted);margin:0">Enregistrer un besoin prioritaire</p>
      </a>
    @else
      <a class="card" href="{{ route('besoins-citoyens.create') }}" style="padding:16px;text-decoration:none">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
          <div class="ico" style="background:var(--laterite-soft);color:var(--laterite)">
            <svg class="i"><use href="#i-pin"/></svg>
          </div>
          <b style="color:var(--ink)">Soumettre un besoin</b>
        </div>
        <p style="font-size:13px;color:var(--muted);margin:0">Exprimer un besoin pour votre canton</p>
      </a>
    @endcan

    <a class="kpi" href="{{ route('sessions.index') }}">
      <div class="ico" style="background:#ddf2ea;color:var(--ok)">
        <svg class="i"><use href="#i-check"/></svg>
      </div>
      <div>
        <b>{{ $stats['sessions_terminees'] }}</b>
        <span>Terminées</span>
      </div>
    </a>

    <a class="kpi" href="{{ route('deliberations.index') }}">
      <div class="ico" style="background:var(--blue-soft);color:var(--blue)">
        <svg class="i"><use href="#i-scale"/></svg>
      </div>
      <div>
        <b>{{ $stats['deliberations'] }}</b>
        <span>Délibérations</span>
      </div>
    </a>

    <a class="kpi" href="{{ route('besoins.index') }}">
      <div class="ico" style="background:var(--laterite-soft);color:var(--laterite)">
        <svg class="i"><use href="#i-pin"/></svg>
      </div>
      <div>
        <b>{{ $stats['besoins'] }}</b>
        <span>Besoins</span>
      </div>
    </a>
  </div>

  @if($isAdmin && $comptesEnAttente > 0)
    <div style="margin-top:-10px;margin-bottom:24px">
      <a class="kpi alert" href="{{ route('comptes.index') }}" style="max-width:320px">
        <div class="ico"><svg class="i"><use href="#i-users"/></svg></div>
        <div>
          <b>{{ $comptesEnAttente }}</b>
          <span>compte{{ $comptesEnAttente > 1 ? 's' : '' }} à valider</span>
        </div>
      </a>
    </div>
  @endif

  {{-- Sessions à venir / Dernière session --}}
  <div class="duo" style="margin-bottom:24px">
    @if($prochaineSession)
      <div class="card card-accent" style="border-left-color:var(--sun)">
        <div class="card-head">
          <h3 style="display:flex;align-items:center;gap:9px">
            <span style="width:8px;height:8px;border-radius:50%;background:var(--sun);flex:none;display:inline-block;box-shadow:0 0 0 3px var(--sun-soft)"></span>
            Prochaine session
          </h3>
          <a href="{{ route('sessions.show', $prochaineSession) }}" class="btn-add">
            <svg class="i"><use href="#i-arrow-right"/></svg>Voir
          </a>
        </div>
        <div class="info-row">
          <span class="info-label">Numéro</span>
          <span class="info-value">{{ $prochaineSession->numero }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Date</span>
          <span class="info-value">{{ $prochaineSession->date->translatedFormat('d F Y') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Lieu</span>
          <span class="info-value">{{ $prochaineSession->lieu ?? '—' }}</span>
        </div>
      </div>
    @else
      <div class="card" style="display:flex;align-items:center;justify-content:center;min-height:160px">
        <div class="empty-state" style="padding:16px">
          <svg class="i" style="width:36px;height:36px"><use href="#i-calendar"/></svg>
          <p>Aucune session planifiée</p>
          @can('gerer')
            <a href="{{ route('sessions.create') }}" class="btn-add" style="margin-top:8px">
              <svg class="i"><use href="#i-plus"/></svg>Planifier une session
            </a>
          @endcan
        </div>
      </div>
    @endif

    @if($derniereSession)
      <div class="card">
        <div class="card-head">
          <h3 style="display:flex;align-items:center;gap:9px">
            <span style="width:8px;height:8px;border-radius:50%;background:var(--subtle);flex:none;display:inline-block"></span>
            Dernière session
          </h3>
          <a href="{{ route('sessions.show', $derniereSession) }}" class="btn-add">
            <svg class="i"><use href="#i-arrow-right"/></svg>Voir
          </a>
        </div>
        <div class="info-row">
          <span class="info-label">Numéro</span>
          <span class="info-value">{{ $derniereSession->numero }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Date</span>
          <span class="info-value">{{ $derniereSession->date->translatedFormat('d F Y') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Documents</span>
          <span class="info-value">{{ $derniereSession->documents->count() }} fichier{{ $derniereSession->documents->count() > 1 ? 's' : '' }}</span>
        </div>
      </div>
    @endif
  </div>

  {{-- Accès rapide --}}
  <p class="section-title">Accès rapide</p>
  <div class="quick-grid">
    <a href="{{ route('sessions.index') }}">
      <div class="ql-icon"><svg class="i"><use href="#i-gavel"/></svg></div>
      Sessions
    </a>
    <a href="{{ route('deliberations.index') }}">
      <div class="ql-icon" style="background:var(--blue-soft);color:var(--blue)"><svg class="i"><use href="#i-scale"/></svg></div>
      Délibérations
    </a>
    <a href="{{ route('besoins.index') }}">
      <div class="ql-icon" style="background:var(--laterite-soft);color:var(--laterite)"><svg class="i"><use href="#i-pin"/></svg></div>
      Besoins
    </a>
    <a href="{{ route('pai.index') }}">
      <div class="ql-icon" style="background:var(--purple-soft);color:var(--purple)"><svg class="i"><use href="#i-plan"/></svg></div>
      Plans PAI
    </a>
    <a href="{{ route('budgets.index') }}">
      <div class="ql-icon" style="background:var(--sun-soft);color:var(--sun)"><svg class="i"><use href="#i-coin"/></svg></div>
      Budgets
    </a>
    <a href="{{ route('administration.index') }}">
      <div class="ql-icon" style="background:#f0eeff;color:#7c3aed"><svg class="i"><use href="#i-book"/></svg></div>
      Administration
    </a>
  </div>

</x-app-layout>
