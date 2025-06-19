<!-- /header -->
<section class="wrapper bg-gray">
    <div class="container pt-10 pb-14 pb-md-16">
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
                                <input onchange="save_news(this,true)" value="<?= $row->id_news; ?>" <?= (in_array($row->id_news,$fav)) ? 'checked="true"' : ''; ?> type="checkbox" id="check-news-<?= $row->id_news; ?>" style="z-index : 100;">
                            </div>
                            <?php endif;?>
                            <div class="post-header">
                            <div class="post-category">
                                <a role="button" class="hover link-yellow" rel="category" style="color : <?= $row->color; ?>"><?= $row->category; ?></a>
                            </div>
                            <!-- /.post-category -->
                            <h2 class="post-title h3 mt-1 mb-3"><a class="link-navy cursor-pointer" onclick="detail_berita(this,<?= $row->id_news; ?>)" data-image="<?= image_check($row->image,'news'); ?>" data-bs-target="#modalDetailBerita" data-bs-toggle="modal"><?= short_text($row->title,20); ?></a></h2>
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
        </div>
        <!--/.row -->

        <?php if($total > 0): ?>
        <nav class="d-flex mt-5" aria-label="pagination">
            <ul class="pagination pagination-alt">
                <?php if ($offset > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url('favorite',true); ?>?offset=<?= $offset - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true"><i class="fa-solid fa-arrow-left"></i></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= ($total + 1); $i++) { ?>
                    
                    <li class="page-item <?= $i == $offset ? 'active' : '' ?>"><a class="page-link" href="<?= base_url('favorite',true); ?>?offset=<?= $i ?>"><?= $i;?></a></li>
                <?php } ?>

                <?php if ($offset < $total): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url('favorite',true); ?>?offset=<?= $offset + 1 ?>" aria-label="Next">
                        <span aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                        </a>
                    </li>
                <?php endif; ?>
                
                
            </ul>
            <!-- /.pagination -->
        </nav>
        <!-- /nav -->


        <?php endif;?>
    </div>
    <!-- /.container -->

</section>
<!-- /section -->