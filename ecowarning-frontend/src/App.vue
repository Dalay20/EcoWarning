
<template>
  <div class="app-bg min-h-screen flex flex-col">
    <header class="main-header">
      <div class="header-content">
        <img alt="EcoWarning" src="/logo_02.png" width="40" height="40" />
        <RouterLink to="/" class="logo-title">
      EcoWarning!
    </RouterLink>
        <nav class="main-nav">
          <RouterLink to="/">Mapa</RouterLink>
          <RouterLink to="/nueva">Nueva denuncia</RouterLink>
          <RouterLink to="/reportes">Reportes</RouterLink>
        </nav>
      </div>
    </header>

    <main class="main-content">
      <RouterView />
    </main>

    <footer class="main-footer">
      <div class="footer-content">
        <span>🌱 EcoWarning</span>
        <span class="footer-divider">|</span>
        <span>Proyecto académico 2025</span>
        <span class="footer-divider">|</span>
        <a href="https://github.com/Dalay20/EcoWarning" target="_blank" rel="noopener" class="footer-link">GitHub</a>
      </div>
    </footer>
  </div>
</template>

<script setup>
</script>

<style scoped>

:root {
  --primary: #3bb77e;
  --primary-dark: #24915e;
  --primary-light: #e0f7ef;
  --bg: #f6faf7;
  --header-bg: linear-gradient(90deg, #b2f2d7 0%, #7be495 100%);
  --footer-bg: linear-gradient(90deg, #b2f2d7 0%, #7be495 100%);
  --text: #1a3a2b;
  --nav-link: #1a3a2b;
  --nav-link-hover: #fff;
  --nav-link-bg-hover: #24915e;
}

.app-bg {
  background: var(--bg);
}

.main-header {
  position: fixed;          
  top: 0;
  left: 0;
  width: 100%;              
  background: rgba(255, 255, 255, 0.9); 
  backdrop-filter: blur(6px); 
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 0;
  z-index: 1000;
}
.header-content {
  max-width: 1500px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 1.2rem;
  padding: 1rem 2rem;
}
.logo-title {
  font-size: 1.7rem;
  font-weight: 700;
  color: var(--primary-dark);
  letter-spacing: 1px;
  text-shadow: 0 2px 8px #b2f2d7cc;
  text-decoration: none;
}
.main-nav {
  margin-left: auto;
  display: flex;
  gap: 1.5rem;
}
.main-nav a {
  color: var(--nav-link);
  font-weight: 500;
  padding: 0.4em 1.1em;
  border-radius: 2em;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  text-decoration: none;
  position: relative;
  background: transparent;
}
.main-nav a.router-link-active {
  background: var(--primary-dark);
  color: #1f1c1cff;
  font-weight: 700;
  box-shadow: 0 2px 8px 0 #24915e33;
}
.main-nav a:not(.router-link-active):hover {
  background: var(--nav-link-bg-hover);
  color: var(--nav-link-hover);
  box-shadow: 0 2px 8px 0 #3bb77e33;
}

.main-content {
  max-width: 900px;
  width: 100%;
  margin: 2.5rem auto 1.5rem auto;
  background: #fff;
  border-radius: 1.2rem;
  box-shadow: 0 4px 24px 0 #0002;
  padding: 2.5rem 2rem 2rem 2rem;
  min-height: 60vh;
  margin-top: 1rem;
  position: relative;
  z-index: 0;
  margin-top: 100px;
}

.main-footer {
  background: var(--footer-bg);
  padding: 1.2rem 0 1.2rem 0;
  box-shadow: 0 -2px 8px 0 #0002;
  margin-top: auto;
  color: var(--text);
}
.footer-content {
  max-width: 900px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.7rem;
  color: var(--primary-dark);
  font-size: 1rem;
  opacity: 0.95;
  text-shadow: 0 1px 8px #b2f2d7cc;
}
.footer-divider {
  color: #bdbdbd;
  margin: 0 0.3em;
}
.footer-link {
  color: var(--primary-dark);
  text-decoration: underline;
  transition: color 0.2s, text-shadow 0.2s;
}
.footer-link:hover {
  color: #fff;
  text-shadow: 0 2px 8px #24915e99;
}

@media (max-width: 600px) {
  .header-content, .main-content, .footer-content {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  .main-content {
    padding: 1.2rem 0.5rem 1.2rem 0.5rem;
  }
  .logo-title {
    font-size: 1.1rem;
  }
  .main-nav {
    gap: 0.7rem;
  }
  .footer-content {
    font-size: 0.95rem;
  }
}
</style>