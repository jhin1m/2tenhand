<template>
    <div id="home">
      <!-- Top Section with Search -->
      <div class="top-home bg-dark text-white py-5">
        <div class="container">
          <div class="top-content d-flex flex-column align-items-center">
            <!-- Search Bar -->
            <div id="xsearch" class="home-search mb-3 w-100">
              <form action="/latest?q=" method="get" autocomplete="off" id="search-home-form" class="d-flex justify-content-center">
                <div class="input-group" style="max-width: 600px;">
                  <input type="text" name="q" class="form-control" placeholder="キーワードを入力してください..." required />
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- CTA Button -->
            <div class="xbuttons pt-5">
              <router-link :to="{name: 'comics'}" class="btn btn-primary">
                に行く {{ $t("app.name") }} <i class="fas fa-caret-right ml-2"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Content Section -->
      <div class="content-home bg-dark text-light py-2">
        <div class="container">

          <!-- Main Content Text -->
          <h1 class="A1headline text-center mb-4">{{ ($site.name)}}</h1>

          <h1 class="A1headline text-center mb-4">{{ ($site.name)}} - オンラインでエロ漫画を無料で読む
          </h1>
          <p class="text-justify">
            Google で「ポルノ漫画を読む」と検索すると、最初のオートコンプリートの候補の 1 つは「なぜポルノ漫画?」というものになります。そんなに高いんですか？そう、誰もがオンラインでお気に入りの漫画を読んだり、ラオタクをプレイしたりできるわけではありません。それを変えるために作られました。私たちは、すべてのマンガ愛好家にマンガを楽しんでいただけるようにするためにここにいます。気にする。そのため、{{ ($site.name)}} は無料で安全です。
          </p>
          <h2 class="A2headline text-center mt-5">ナンバー1のエロ漫画</h2>
          <p class="text-justify">
            {{ ($site.name)}} - オンラインでエロ漫画を無料で読む
            オンラインでエロマンガを無料で読みたいですか？それとも有料の読書サービスに登録していますか？それとも、今の無料エロ漫画サイトはとても危険だと思いますか？これらの質問のいずれかが気になる場合は、{{ ($site.name)}} で解決策を見つけることができます。
          </p>
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
  
  /* Headline Styles */
  .A1headline {
    font-size: 2rem;
    font-weight: bold;
  }
  
  .A2headline {
    font-size: 1.5rem;
    font-weight: bold;
  }
  
  .social-home-block .shb-icon i {
    font-size: 2rem;
  }
  
  .text-justify {
    text-align: justify;
  }
  </style>
