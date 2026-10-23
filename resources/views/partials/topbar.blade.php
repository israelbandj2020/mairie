<header class="top">
  <button class="burger" id="burger" aria-label="Ouvrir le menu" aria-controls="menu"><svg class="i"><use href="#i-menu"/></svg></button>
  <label class="search">
    <svg class="i"><use href="#i-search"/></svg>
    <input type="search" placeholder="Rechercher une session, un document, un canton">
  </label>
  <span class="grow"></span>
  <button class="icon-btn" aria-label="Notifications">
    <svg class="i"><use href="#i-bell"/></svg>
    @if(auth()->user()->estAdmin() && ($comptesEnAttente ?? 0) > 0)
      <span class="dot"></span>
    @endif
  </button>
</header>
