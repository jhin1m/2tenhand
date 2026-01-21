<template>
  <div id="home">
    <!-- Top Hero Section -->
    <div class="hero-section text-white d-flex align-items-center">
      <div class="hero-overlay"></div>
      <div class="container position-relative z-index-1">
        <div class="hero-content text-center py-5">
          <h1 class="hero-title mb-4 animate-fade-in">
            Chào mừng đến với <span class="text-primary">{{ $site.name }}</span>
          </h1>
          <p class="hero-subtitle mb-5 animate-fade-in-delay">
            Thế giới truyện tranh miễn phí, cập nhật nhanh nhất mỗi ngày.
          </p>

          <!-- Search Bar -->
          <div id="xsearch" class="search-container mx-auto mb-5">
            <form action="/latest?q=" method="get" autocomplete="off" id="search-home-form" class="d-flex w-100">
              <div class="input-group shadow-lg overflow-hidden rounded-pill border-0">
                <input type="text" name="q" class="form-control form-control-lg border-0 px-4 py-3 bg-white-smoke"
                  placeholder="Tìm kiếm truyện, tác giả..." required />
                <div class="input-group-append">
                  <button class="btn btn-primary px-4 border-0" type="submit">
                    <search-icon />
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!-- CTA Buttons -->
          <div class="cta-buttons d-flex justify-content-center gap-3 animate-fade-in-delay-2">
            <router-link :to="{ name: 'comics' }"
              class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm transform-hover">
              Bắt đầu đọc <i class="fas fa-arrow-right ml-2"></i>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature Section -->
    <div class="features-section py-5">
      <div class="container">
        <div class="row text-center g-4">
          <div class="col-md-4">
            <div class="feature-card p-4 rounded-lg bg-dark-soft border border-gray transition-card">
              <div class="feature-icon mb-3">
                <i class="fas fa-bolt text-warning fa-3x"></i>
              </div>
              <h3 class="h4 mb-3">Cập nhật siêu tốc</h3>
              <p class="text-muted mb-0">Luôn mang đến những chương mới nhất nhanh nhất có thể cho bạn.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="feature-card p-4 rounded-lg bg-dark-soft border border-gray transition-card">
              <div class="feature-icon mb-3">
                <i class="fas fa-gem text-primary fa-3x"></i>
              </div>
              <h3 class="h4 mb-3">Chất lượng cao</h3>
              <p class="text-muted mb-0">Hình ảnh sắc nét, dịch thuật mượt mà cho trải nghiệm đọc tốt nhất.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="feature-card p-4 rounded-lg bg-dark-soft border border-gray transition-card">
              <div class="feature-icon mb-3">
                <i class="fas fa-shield-alt text-success fa-3x"></i>
              </div>
              <h3 class="h4 mb-3">Hoàn toàn miễn phí</h3>
              <p class="text-muted mb-0">Truy cập không giới hạn kho truyện khổng lồ mà không tốn một xu.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SEO Content Section -->
    <div class="seo-content py-5 bg-black-darker">
      <div class="container text-center">
        <h2 class="display-5 mb-4">{{ $site.name }} - Đọc truyện tranh Online tốt nhất</h2>
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <p class="lead text-muted mb-4">
              Chúng tôi được xây dựng với sứ mệnh mang lại trải nghiệm đọc truyện tuyệt vời nhất.
              Giao diện hiện đại, dễ sử dụng trên cả máy tính và điện thoại.
              Tham gia ngay vào cộng đồng yêu truyện tranh hàng đầu Việt Nam.
            </p>
            <hr class="border-secondary my-5 w-25">
            <p class="text-justify-center">
              Nếu bạn đang tìm kiếm một nơi an toàn, nhanh chóng và chất lượng để đắm chìm vào thế giới Manga, Manhua
              hay Manhwa,
              <strong>{{ $site.name }}</strong> chính là điểm dừng chân lý tưởng của bạn.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomePage",
};
</script>

<style scoped>
/* Color Palette & Custom Utilities */
.bg-dark-soft {
  background: #1f1c25;
}

.bg-black-darker {
  background: #151419;
}

.bg-white-smoke {
  background: #f8f9fa;
  color: #333;
}

.border-gray {
  border-color: rgba(255, 255, 255, 0.05) !important;
}

/* Hero Section Styles */
.hero-section {
  position: relative;
  min-height: 80vh;
  background: linear-gradient(135deg, #1a191e 0%, #231f2a 100%);
  background-size: cover;
  background-position: center;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(94, 114, 228, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%);
}

.hero-title {
  font-size: 4rem;
  font-weight: 800;
  letter-spacing: -0.02em;
  line-height: 1.2;
}

.hero-subtitle {
  font-size: 1.5rem;
  font-weight: 400;
  color: rgba(255, 255, 255, 0.8);
}

/* Search Bar Styles */
.search-container {
  max-width: 650px;
  position: relative;
}

.search-container input:focus {
  background: #fff;
  box-shadow: 0 0 20px rgba(94, 114, 228, 0.3);
}

/* Feature Cards */
.feature-card {
  height: 100%;
  transition: all 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-10px);
  background: #2a2632;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
  border-color: rgba(94, 114, 228, 0.3) !important;
}

/* Animations */
.animate-fade-in {
  animation: fadeIn 0.8s ease-out;
}

.animate-fade-in-delay {
  animation: fadeIn 0.8s ease-out 0.2s both;
}

.animate-fade-in-delay-2 {
  animation: fadeIn 0.8s ease-out 0.4s both;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.transform-hover {
  transition: transform 0.2s ease;
}

.transform-hover:hover {
  transform: scale(1.05);
}

.gap-3 {
  gap: 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2.5rem;
  }

  .hero-subtitle {
    font-size: 1.1rem;
  }

  .hero-section {
    min-height: 60vh;
  }
}
</style>
