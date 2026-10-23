<x-app-layout title="Tableau de bord">
  <section class="hello">
    <div>
      <h1>Tableau de bord</h1>
      <p>Bienvenue, {{ auth()->user()->nom_complet }}.</p>
    </div>
  </section>

  @if(auth()->user()->estAdmin())
    <section class="kpis">
      <a class="kpi {{ $comptesEnAttente > 0 ? 'alert' : '' }}" href="#">
        <div class="ico"><svg class="i"><use href="#i-users"/></svg></div>
        <div><b>{{ $comptesEnAttente }}</b><span>comptes à valider</span></div>
      </a>
    </section>
  @endif
</x-app-layout>
