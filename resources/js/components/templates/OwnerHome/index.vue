<template>
<div class="owner-home">
        <div class="owner-home__wrapper">
          <div class="owner-home__photo">
           <h1 class="owner-home__headMsg">あなたのアパレルショップをロパに掲載しよう</h1>
          </div>
            <div class="owner-home__contents">
                <div class="owner-home__content-small">
                    <h1 class="owner-home__sub_title">Ropa.jpとは？</h1>
                    <p class="owner-home__text">ロパは検索機能によってアパレルショップを探せるWebサイトです</p>
                </div>
                <div class="owner-home__content-small">
                        <h1 class="owner-home__sub_title">ロパなら掲載料無料</h1>
                            <p class="owner-home__text owner-home__float-left">
                                お店をメディアに掲載する時、普通は費用がかかります。しかし、ロパなら面倒な手続きなしでしかも無料で掲載できます。
                                <br>ロパにお店を掲載することによって顧客はブランド名や場所、カテゴリーからあなたのお店を検索します。
                            </p>
                    <img class="owner-home__image1" src="/img/owner-image1.jpg" alt="">
                </div>
                    <div class="owner-home__box">
                        <h1 class="owner-home__sub_title">とっても簡単！始めるための３ステップ</h1>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle"></i> 会員登録</h2>
                                <p class="owner-home__text">会員登録時に入力するショップ情報がリストに表示されます。</p>
                            </div>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle"></i> 写真を載せる</h2>
                                <p class="owner-home__text">お店の外観、雰囲気などあなたのお店の魅力を表現してください。</p>
                            </div>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle"></i> お店のページを確認</h2>
                                <p class="owner-home__text">あなたのお店のページがどのように表示されるのか確認しましょう。
                                </p>
                        </div>
                    </div>
                    <div class="owner-home__content-small">
                        <h1 class="owner-home__sub_title">様々なキーワードからお店を検索できます</h1>
                            <p class="owner-home__text owner-home__float-right">
                                検索エンジンでは検索上位に表示されず、頭を悩ませているならロパはいい選択肢になるでしょう。
                                <br>なぜならロパはアパレルショップのみを扱っておりアパレルショップを探している人のみが集まるからです。
                            </p>
                    <img class="owner-home__image2" src="/img/owner-image2.jpg" alt="">
                </div>
                    <h1 class="owner-home__sub_title">今すぐ始めよう</h1>
                    <p class="owner-home__text">会員登録はこちらから</p>
                    <RouterLink class="button button--middle--link navbar--register" to="/owners/owner-register">
                        新規店舗登録
                       </RouterLink>
            </div>
        </div>
        <OwnerFooter />
</div>
</template>
<script>
    import OwnerFooter from '../../organisms/OwnerFooter/index.vue'
        
        export default {
            components: {
                OwnerFooter
            }
        }
</script>
