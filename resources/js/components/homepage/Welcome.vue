<template>
  <div class="welcome-container">
    <!-- Hero Section -->
    <div class="jumbotron jumbotron-fluid bg-transparent text-white mb-0 position-relative hero-section">
      <div class="hero-bg-overlay"></div>
      <div class="container position-relative z-1 text-center py-5">
        <h1 class="display-3 font-weight-bold mb-3" v-html="$t('app.welcome.title', { name: $site.name })">
        </h1>
        <p class="lead mb-4 text-white-50 mx-auto" style="max-width: 700px;">
          {{ $t('app.welcome.subtitle') }}
        </p>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
          <div class="col-md-8 col-lg-6">
            <form action="/latest?q=" method="get" class="search-form position-relative">
              <input type="text" name="q"
                class="form-control form-control-lg rounded-pill pl-5 bg-dark-transparent text-white shadow-lg"
                :placeholder="$t('app.welcome.search_placeholder')" required />
              <span class="search-icon-wrapper position-absolute">
                <search-icon class="text-muted" />
              </span>
            </form>
          </div>
        </div>

        <!-- CTA Buttons -->
        <div class="d-flex justify-content-center gap-3">
          <router-link :to="{ name: 'comics' }"
            class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm d-flex align-items-center">
            <span>{{ $t('app.welcome.cta_button') }}</span> <arrow-right-icon class="ml-2" />
          </router-link>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="features-section py-5">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="font-weight-bold text-white"
            v-html="$t('app.welcome.why_choose', { name: `<span class='text-primary'>${$site.name}</span>` })"></h2>
        </div>

        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card bg-dark border-0 h-100 shadow-sm feature-card">
              <div class="card-body text-center p-4">
                <div
                  class="feature-icon mb-3 text-warning bg-warning-soft mx-auto rounded-circle d-flex align-items-center justify-content-center">
                  <lock-icon size="2x" />
                </div>
                <h4 class="text-white font-weight-bold">{{ $t('app.welcome.features.safe_title') }}</h4>
                <p class="card-text text-white-50">{{ $t('app.welcome.features.safe_desc') }}</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div class="card bg-dark border-0 h-100 shadow-sm feature-card">
              <div class="card-body text-center p-4">
                <div
                  class="feature-icon mb-3 text-primary bg-primary-soft mx-auto rounded-circle d-flex align-items-center justify-content-center">
                  <zap-icon size="2x" />
                </div>
                <h4 class="text-white font-weight-bold">{{ $t('app.welcome.features.update_title') }}</h4>
                <p class="card-text text-white-50">{{ $t('app.welcome.features.update_desc') }}</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div class="card bg-dark border-0 h-100 shadow-sm feature-card">
              <div class="card-body text-center p-4">
                <div
                  class="feature-icon mb-3 text-success bg-success-soft mx-auto rounded-circle d-flex align-items-center justify-content-center">
                  <heart-icon size="2x" />
                </div>
                <h4 class="text-white font-weight-bold">{{ $t('app.welcome.features.free_title') }}</h4>
                <p class="card-text text-white-50">{{ $t('app.welcome.features.free_desc') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Welcome',
}
</script>

<style scoped>
.hero-section {
  min-height: 55vh;
  display: flex;
  align-items: center;
  background: url('/images/landing/home.jpeg') center/cover no-repeat;
}

.hero-bg-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(180deg, rgba(30, 30, 40, 0.7) 0%, rgba(30, 30, 40, 0.95) 100%);
  pointer-events: none;
}

.bg-dark-transparent {
  background-color: rgba(30, 30, 40, 0.6) !important;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
}

.bg-dark-transparent:focus {
  background-color: rgba(30, 30, 40, 0.8) !important;
  border-color: #764ba2 !important;
  box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25) !important;
}

.search-form .form-control-lg {
  height: 3.5rem;
  font-size: 1.1rem;
}

.search-icon-wrapper {
  top: 50%;
  left: 1.5rem;
  transform: translateY(-50%);
  z-index: 5;
}

.gap-3 {
  gap: 1rem;
}

.feature-icon {
  width: 70px;
  height: 70px;
}

.bg-warning-soft {
  background-color: rgba(255, 193, 7, 0.1);
}

.bg-primary-soft {
  background-color: rgba(13, 110, 253, 0.1);
}

.bg-success-soft {
  background-color: rgba(25, 135, 84, 0.1);
}

.feature-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #2b2b35 !important;
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
}

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-section h1 {
  animation: fadeInUp 0.8s ease-out;
}

.hero-section p {
  animation: fadeInUp 0.8s ease-out 0.2s both;
}

.search-form {
  animation: fadeInUp 0.8s ease-out 0.4s both;
}

.btn-cta {
  animation: fadeInUp 0.8s ease-out 0.6s both;
}
</style>
