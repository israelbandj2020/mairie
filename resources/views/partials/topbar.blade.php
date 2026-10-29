<header class="top">
  <button class="burger" id="burger" aria-label="Ouvrir le menu" aria-controls="menu">
    <svg class="i"><use href="#i-menu"/></svg>
  </button>

  <label class="search">
    <svg class="i"><use href="#i-search"/></svg>
    <input type="search" placeholder="Rechercher…">
  </label>

  <span class="grow"></span>

  <button class="icon-btn" aria-label="Notifications" style="position:relative">
    <svg class="i"><use href="#i-bell"/></svg>
    @if(auth()->user()->estAdmin() && ($comptesEnAttente ?? 0) > 0)
      <span class="dot"></span>
    @endif
  </button>

  <div style="display:flex;align-items:center;gap:9px;padding:4px 10px 4px 6px;background:var(--card);border:1.5px solid var(--line);border-radius:11px;box-shadow:var(--shadow-xs)">
    <div style="width:30px;height:30px;border-radius:50%;background:var(--ok-soft);color:var(--forest-2);display:grid;place-items:center;font-family:var(--head);font-weight:700;font-size:11.5px;flex:none;border:1.5px solid var(--ok-mid)">
      {{ auth()->user()->initiales }}
    </div>
    <div style="line-height:1.25;min-width:0" class="hide-s">
      <div style="font-size:13px;font-weight:600;white-space:nowrap;color:var(--ink)">{{ auth()->user()->nom_complet }}</div>
      <div style="font-size:11px;color:var(--muted)">{{ auth()->user()->estAdmin() ? 'Administrateur' : 'Conseiller' }}</div>
    </div>
  </div>
</header>
