<template>
<div class="owner-home">
        <div class="owner-home__wrapper">
          <div class="owner-home__photo">
           <h1 class="owner-home__headMsg">あなたのアパレルショップをロパに掲載しよう</h1>
          </div>
            <div class="owner-home__contents">
                <div class="owner-home__content-small">
                    <h1 class="owner-home__sub_title">Ropa.jpとは？</h1>
                    <p class="owner-home__text">ロパは検索機能によってアパレルショップとお店を通して服を探す人を繋げるWebサイトです。</p>
                </div>
                <div class="owner-home__content-small">
                        <h1 class="owner-home__sub_title">様々なキーワードからお店を検索できる</h1>
                            <p class="owner-home__text owner-home__float-right">お店を探す人は場所、取り扱いブランドなどのキーワードからお店を検索することができます。
                                例えば、特定のブランドを探している人があなたのお店が取り扱うブランド名で検索しヒットすれば顧客を得るチャンスが生まれます。
                                あなたが他店舗では取り扱っていないブランドを取り扱っている場合、店の希少性は増し多くのファンを獲得できるかもしれません。
                                ロパはアパレルショップとアパレルショップを探している人のみが集まる場所であるため、より的確にターゲティングできます。
                            </p>
                    <img class="owner-home__image2" src="/img/owner-image2.jpg" alt="">
                </div>
                    <div class="owner-home__box">
                        <h1 class="owner-home__sub_title">ロパの３つの特徴</h1>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle owner-home__check"></i> 写真を何枚も表示可能</h2>
                                <p class="owner-home__text">写真は大きく何枚も表示できるので、あなたのお店の強みを細かいところまでお店を探す人に対して直感的に伝えることができます。</p>
                            </div>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle owner-home__check"></i> コメント機能</h2>
                                <p class="owner-home__text">ページを訪れた人はお店についてコメントを残す事ができます。顧客からの貴重なフィードバックや応援の言葉をもらえるかもしれません。</p>
                            </div>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle owner-home__check"></i> 広告を表示しません</h2>
                                <p class="owner-home__text">ロパはお店の魅力を最大限に引き出すためにまた、ページを訪れた人にコンテンツに集中していただけるよう詳細ページに広告を表示しません。
                                </p>
                        </div>
                        <div>
                            <RouterLink class="owner-home__sample-shop-page" to='/owners/shops/21'>
                            お店の詳細ページのサンプルはこちら
                            </RouterLink>
                        </div>
                    </div>
                    <div class="owner-home__content-small">
                        <h1 class="owner-home__sub_title">店の特徴を際立たせるデザイン</h1>
                            <p class="owner-home__text owner-home__float-left">
                                お店を掲載するサイトのデザイン主張が激しすぎると、お店やブランドの雰囲気とマッチせずお店のイメージを損ないかねません。そこでロパは白を基調とし、余白を意識したデザインにより、
                                お店の魅力を存分に表現できるようにしました。また、お店詳細ページのトップに画像を表示することができるため、お店のページを訪れた人に対して直感的にお店の雰囲気を伝えることができます。
                            </p>
                    <img class="owner-home__image1" src="/img/owner-image1.jpg" alt="">
                </div>
                <div class="owner-home__box">
                        <h1 class="owner-home__sub_title">とっても簡単！始めるための３ステップ</h1>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle owner-home__check"></i> 会員登録</h2>
                                <p class="owner-home__text">会員登録時に入力するショップ情報があなたのページに表示されます。</p>
                            </div>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle owner-home__check"></i> 写真を載せる</h2>
                                <p class="owner-home__text">お店の外観、雰囲気などあなたのお店の魅力を表現してください。</p>
                            </div>
                            <div class="owner-home__steps">
                                <h2><i class="far fa-check-circle owner-home__check"></i> お店のページを確認</h2>
                                <p class="owner-home__text">あなたのお店のページがどのように表示されるのか確認しましょう。
                                </p>
                        </div>
                    </div>
                    <h1 class="owner-home__sub_title">今すぐ始めよう</h1>
                    <p class="owner-home__text">店舗登録はこちらから(無料)</p>
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
