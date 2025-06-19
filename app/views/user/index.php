<!-- /header -->
<section class="wrapper bg-gray">
    <div class="container pt-10 pb-14 pb-md-16">
    
    <?php if($recomendasi) : ?>
    <div class="swiper-container blog grid-view mb-16" data-margin="30" data-dots="true" data-items-lg="2" data-items-md="1" data-items-xs="1">
        <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach($recomendasi AS $row) : ?>
            <div class="swiper-slide cursor-pointer" onclick="detail_berita(this,<?= $row->id_news; ?>)" data-image="<?= image_check($row->image,'news'); ?>" data-bs-target="#modalDetailBerita" data-bs-toggle="modal">
                <figure class="overlay caption caption-overlay rounded mb-0"><a role="button"> <img src="<?= image_check($row->image,'news') ?>" alt="" /></a>
                    <figcaption>
                    <span class="badge badge-lg bg-white text-uppercase mb-3" style="color : <?= $row->color; ?> !important;"><?= $row->category; ?></span>
                    <h2 class="post-title h3 mt-1 mb-3"><a href=""><?= short_text($row->title,20) ?></a></h2>
                    <ul class="post-meta text-white mb-0">
                        <li class="post-date"><i class="fa-solid fa-calendar-alt"></i><span><?= date('d M Y',strtotime($row->create_date)); ?></span></li>
                        <li class="post-comments"><a role="button"><i class="fa-regular fa-bookmark"></i><?= $row->total_fav; ?><span> Saved</span></a></li>
                    </ul>
                    <!-- /.post-meta -->
                    </figcaption>
                    <!-- /figcaption -->
                </figure>
            <!-- /figure -->
            </div>
            <!--/.swiper-slide -->
            <?php endforeach;?>
        </div>
        <!--/.swiper-wrapper -->
        </div>
        <!-- /.swiper -->
    </div>
    <!-- /.swiper-container -->
    <?php endif;?>
    <div class="row">
        <div class="col-lg-12 col-xl-10 col-xxl-8 mx-auto text-center mb-10">
        <h2 class="display-5 text-center mt-4 mb-2">Berita Terbaru</h2>
        <p class="text-muted text-center">Kami menyajikan beberapa berita terbaru untuk anda nikmati. Silahkan lihat berita kami lebih banyak</p>
        </div>
        <!--/column -->
    </div>
    <!--/.row -->
    <div class="row grid-view gx-md-8 gx-xl-10 gy-8 gy-lg-0">
        <?php if(isset($result) && $result) : ?>
            <?php foreach($result AS $row) : ?>
            <div class="col-md-6 col-lg-4 mx-auto mb-3" id="news-<?= $row->id_news; ?>">
                <article class="item post">
                    <div class="card shadow-lg">
                    <figure class="card-img-top overlay overlay-1 cursor-pointer"><a onclick="detail_berita(this,<?= $row->id_news; ?>)" data-image="<?= image_check($row->image,'news'); ?>" data-bs-target="#modalDetailBerita" data-bs-toggle="modal" role="button"> <img src="<?= image_check($row->image,'news') ?>" alt="" /></a>
                        <figcaption>
                        <h5 class="from-top mb-0">Baca Berita</h5>
                        </figcaption>
                    </figure>
                    <div class="card-body position-relative">
                        <?php if(isset($_SESSION[WEB_NAME.'_id_user'])) : ?>
                        <div class="w-100 d-flex justify-content-end align-items-center position-absolute px-5" style="left : 0">
                            <label for="check-news-<?= $row->id_news; ?>"  class="<?= (in_array($row->id_news,$fav)) ? 'fa-solid text-primary' : 'fa-regular'; ?> fa-bookmark cursor-pointer" style="font-size : 30px;"></label>
                            <input onchange="save_news(this)" value="<?= $row->id_news; ?>" <?= (in_array($row->id_news,$fav)) ? 'checked=true' : ''; ?> type="checkbox" id="check-news-<?= $row->id_news; ?>" style="z-index : 100;">
                        </div>
                        <?php endif;?>
                        <div class="post-header">
                        <div class="post-category">
                            <a role="button" class="hover link-yellow" rel="category" style="color : <?= $row->color; ?>"><?= $row->category; ?></a>
                        </div>
                        <!-- /.post-category -->
                        <h2 class="post-title h3 mt-1 mb-3"><a onclick="detail_berita(this,<?= $row->id_news; ?>)" data-image="<?= image_check($row->image,'news'); ?>" data-bs-target="#modalDetailBerita" data-bs-toggle="modal"  class="link-navy cursor-pointer" role="button"><?= short_text($row->title,20); ?></a></h2>
                        </div>
                        <!-- /.post-header -->
                        <div class="post-content news-card">
                        <p><?= short_text($row->short_description,80);?></p>
                        </div>
                        <!-- /.post-content -->
                    </div>
                    <!--/.card-body -->
                    <div class="card-footer">
                        <ul class="post-meta d-flex mb-0">
                        <li class="post-date"><i class="fa-solid fa-calendar-alt"></i><span><?= date('d M Y',strtotime($row->create_date)); ?></span></li>
                        <li class="post-likes ms-auto"><a role="button"><i class="fa-regular fa-bookmark"></i><?= number_format($row->cnt_fav,0,',','.') ?></a></li>
                        </ul>
                        <!-- /.post-meta -->
                    </div>
                    <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </article>
            </div>
            <?php endforeach;?>
        <?php else: ?>
            <div class="pane-not-found">
                <img src="<?= image_check('empty.svg','default'); ?>" alt="">
                <h3>Tidak ada data berita</h3>
                <p>Data berita belum ada! Hubungi admin jika terjadi kesalahan</p>
            </div>
        <?php endif;?>
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <a href="<?= base_url('news',true) ?>" class="btn btn-primary">Lihat Semua</a>
        </div>
        
    </div>
    <!--/.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /section -->