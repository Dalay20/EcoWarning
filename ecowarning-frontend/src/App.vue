<template>
  <div class="min-h-screen flex flex-col">
    <header class="p-4 shadow flex items-center gap-4">
      <img alt="EcoWarning" src="/favicon.ico" width="28" height="28" />
      <h1 class="text-xl font-semibold">EcoWarning!</h1>
      <nav class="ml-auto flex gap-3 text-sm">
        <RouterLink to="/">Mapa</RouterLink>
        <RouterLink to="/nueva">Nueva denuncia</RouterLink>
        <RouterLink to="/reportes">Reportes</RouterLink>
      </nav>
    </header>

    <main class="p-4 max-w-6xl w-full mx-auto flex-1">
      <RouterView />
    </main>

    <footer class="p-4 text-center text-xs opacity-70">
      EcoWarning • Proyecto académico
    </footer>
  </div>
</template>

<script setup>
</script>

<style scoped>
a { text-decoration: none; }
.router-link-active { font-weight: 600; }
</style>