<template>
  <div id="home">
    <!-- Top Hero Section -->
    <div class="hero-section text-white d-flex align-items-center justify-content-center">
      <div class="hero-overlay"></div>
      <div class="container position-relative z-index-1">
        <div class="hero-content text-center py-5">
          <h1 class="hero-title mb-3 animate-fade-in">
            <span class="text-primary">{{ $site.name }}</span>
          </h1>
          <p class="hero-subtitle mb-4 animate-fade-in-delay">
            Thư viện truyện tranh trực tuyến lớn nhất Việt Nam
          </p>

          <!-- Search Bar -->
          <div id="xsearch" class="search-container mx-auto mb-4 animate-fade-in-delay">
            <form action="/latest?q=" method="get" autocomplete="off" id="search-home-form" class="d-flex w-100">
              <div class="input-group shadow-lg overflow-hidden rounded-pill border-0">
                <input type="text" name="q"
                  class="form-control form-control-lg border-0 px-4 py-3 bg-dark-input text-white"
                  placeholder="Tìm kiếm truyện, tác giả..." required />
                <div class="input-group-append">
                  <button class="btn btn-primary px-4 border-0" type="submit">
                    <search-icon />
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="d-flex justify-content-center animate-fade-in-delay-2">
            <router-link :to="{ name: 'comics' }" class="btn btn-outline-light rounded-pill px-4 mr-3">
              <book-open-icon size="1.2x" class="mr-2" /> Tất cả truyện
            </router-link>
            <router-link :to="{ name: 'comics', query: { sort: 'latest' } }" class="btn btn-primary rounded-pill px-4">
              Mới cập nhật <arrow-right-icon size="1.2x" class="ml-2" />
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Section -->
    <div class="content-section bg-dark-base py-5">
      <div class="container">

        <!-- Popular Comics -->
        <div class="section-wrapper mb-5 animate-up">
          <popular-comics />
        </div>

        <!-- Latest Updates -->
        <div class="section-wrapper mb-5 animate-up delay-1">
          <latest-updates />
        </div>

        <!-- Features Scale Down -->
        <div class="row text-center g-4 py-4 border-top border-gray-dark">
          <div class="col-md-4">
            <div class="p-3">
              <h3 class="h5 mb-2 text-warning"><i class="fas fa-bolt mr-2"></i>Cập nhật nhanh</h3>
              <p class="text-muted small mb-0">Chương mới được cập nhật liên tục mỗi giờ.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3">
              <h3 class="h5 mb-2 text-primary"><i class="fas fa-gem mr-2"></i>Chất lượng cao</h3>
              <p class="text-muted small mb-0">Ảnh đẹp, load nhanh, không quảng cáo khó chịu.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3">
              <h3 class="h5 mb-2 text-success"><i class="fas fa-check-circle mr-2"></i>Miễn phí 100%</h3>
              <p class="text-muted small mb-0">Đọc truyện thả ga không lo về giá.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SEO Content Section (Hidden visually but kept for SEO if needed, or structured better) -->
    <div class="seo-content py-4 bg-black-darker border-top border-gray-dark">
      <div class="container text-center">
        <h2 class="h6 text-muted mb-3">{{ $site.name }} - Nền tảng đọc truyện tranh online hàng đầu</h2>
        <p class="text-muted small mb-0 w-75 mx-auto">
          Cổng truyện tranh đa dạng thể loại: Manga, Manhua, Manhwa. Giao diện tối ưu trải nghiệm người dùng trên mọi
          thiết bị.
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import PopularComics from './PopularComics.vue';
import LatestUpdates from './LatestUpdates.vue';

export default {
  name: "HomePage",
  components: {
    PopularComics,
    LatestUpdates
  }
};
</script>

<style scoped>
/* Theme Colors & Variables */
.bg-dark-base {
  background-color: #1a191e;
}

.bg-black-darker {
  background-color: #151419;
}

.bg-dark-input {
  background-color: rgba(255, 255, 255, 0.1);
  color: #fff;
  backdrop-filter: blur(10px);
}

.bg-dark-input:focus {
  background-color: rgba(255, 255, 255, 0.15);
  box-shadow: none;
}

.bg-dark-input::placeholder {
  color: rgba(255, 255, 255, 0.6);
}

.border-gray-dark {
  border-color: rgba(255, 255, 255, 0.05) !important;
}

/* Hero Section */
.hero-section {
  position: relative;
  min-height: 55vh;
  background: radial-gradient(circle at top right, #2d2a35 0%, #1a191e 100%);
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image:
    linear-gradient(to bottom, rgba(26, 25, 30, 0.3), #1a191e),
    url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 800;
  letter-spacing: -1px;
}

.hero-subtitle {
  font-size: 1.25rem;
  font-weight: 300;
  color: rgba(255, 255, 255, 0.7);
}

.search-container {
  max-width: 600px;
}

/* Animations */
.animate-fade-in {
  animation: fadeInUp 0.8s ease-out;
}

.animate-fade-in-delay {
  animation: fadeInUp 0.8s ease-out 0.2s both;
}

.animate-fade-in-delay-2 {
  animation: fadeInUp 0.8s ease-out 0.4s both;
}

.animate-up {
  animation: slideUp 0.8s ease-out both;
}

.delay-1 {
  animation-delay: 0.2s;
}

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

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .hero-section {
    min-height: 45vh;
  }

  .hero-title {
    font-size: 2.2rem;
  }

  .hero-subtitle {
    font-size: 1rem;
  }
}
</style>
