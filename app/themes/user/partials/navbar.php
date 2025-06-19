<header class="wrapper bg-gray">
  <nav class="navbar navbar-expand-lg center-nav navbar-light navbar-bg-light">
    <div class="container flex-lg-row flex-nowrap align-items-center">
      <div class="navbar-brand w-100">
        <?php if(isset($setting->logo) && $setting->logo != '' && file_exists('./data/setting/'.$setting->logo)) : ?>
        <a href="<?= base_url('home',true); ?>">
          <img src="<?= image_check($setting->logo,'setting') ?>" srcset="<?= image_check($setting->logo,'setting') ?>" alt="" />
        </a>
        <?php endif;?>
      </div>
      
      <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
        <div class="offcanvas-header d-lg-none">
          <h3 class="text-white fs-30 mb-0"><?= $setting->meta_title; ?></h3>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?= (!uri_segment(0) || uri_segment(0) == 'home') ? 'active' : ''; ?>" href="<?= base_url('home',true); ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= (uri_segment(0) == 'news') ? 'active' : ''; ?>" href="<?= base_url('news',true); ?>">Berita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= (uri_segment(0) == 'contact') ? 'active' : ''; ?>" href="<?= base_url('contact',true); ?>">Kontak</a>
            </li>
            <?php if(isset($_SESSION[WEB_NAME.'_id_user']) && $_SESSION[WEB_NAME.'_id_user'] != '') : ?>
            <li class="nav-item">
              <a class="nav-link <?= (uri_segment(0) == 'favorite') ? 'active' : ''; ?>" href="<?= base_url('favorite',true); ?>">Berita Favorit</a>
            </li>
            <?php endif;?>

          </ul>
          <!-- /.navbar-nav -->
          <div class="offcanvas-footer d-lg-none">
            <div>
              <?php if($web_email || $web_phone) : ?>
                  <?php if($web_email) : ?>
                      <?php foreach($web_email AS $row) : ?>
                      <a class="link-inverse"><i class="fa-solid fa-envelope me-2"></i> <span><?= $row->email; ?></span></a><br/> 
                      <?php endforeach;?>
                  <?php endif;?>

                  

                  <?php if($web_phone) : ?>
                      <?php foreach($web_phone AS $row) : ?>
                          <i class="fa-solid fa-phone me-3"></i><?= ($row->name != '') ? $row->name.' | '.phone_format('0'.$row->phone) : phone_format('0'.$row->phone); ?><br/>
                      <?php endforeach;?>
                  <?php endif;?>
              <?php endif;?>

              <?php
                $soshow = false;
                if ($sosmed) {
                    foreach ($sosmed as $key) {
                        if ($key->url != null && $key->url != '') {
                            $soshow = true;
                        }
                    }
                }
            ?>
              <?php if($soshow == true) : ?>
              <nav class="nav social social-white mt-4">
                 <?php foreach($sosmed AS $row) : ?>
                    <?php if($row->url != null && $row->url != '') : ?>
                      <a href="<?= $row->url; ?>" title="<?= $row->sosmed_name; ?>"><i class="<?= $row->icon; ?>"></i></a>
                    <?php endif;?>
                  <?php endforeach;?>
              </nav>
              <!-- /.social -->
              <?php endif;?>
            </div>
          </div>
          <!-- /.offcanvas-footer -->
        </div>
        <!-- /.offcanvas-body -->
      </div>
      <!-- /.navbar-collapse -->
      <div class="navbar-other w-100 d-flex ms-auto">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <li class="nav-item"><a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-search"><i class="fa-solid fa-magnifying-glass"></i></a></li>
          <li class="nav-item d-none d-md-block">
            <?php if(!isset($_SESSION[WEB_NAME.'_id_user']) || $_SESSION[WEB_NAME.'_id_user'] == '') : ?>
                <button type="button" data-bs-target="#modalLogin" data-bs-toggle="modal" class="btn btn-sm btn-primary rounded-pill">Login</button>
            <?php else : ?>
                <div class="background-partisi cursor-pointer" data-bs-target="#modalProfil" data-bs-toggle="modal" style="background-image : url('<?= image_check((isset($_SESSION[WEB_NAME.'_image']) && $_SESSION[WEB_NAME.'_image']) ? $_SESSION[WEB_NAME.'_image'] : '','user','user'); ?>');width : 50px;height : 50px;border-radius : 100%;"></div>
            <?php endif;?>
          </li>
          <li class="nav-item d-lg-none">
            <button class="hamburger offcanvas-nav-btn"><span></span></button>
          </li>
        </ul>
        <!-- /.navbar-nav -->
      </div>
    </div>
    <!-- /.container -->
  </nav>
  <!-- /.navbar -->
</header>

<div class="offcanvas offcanvas-top bg-light pb-6" id="offcanvas-search" data-bs-scroll="true">
  <form action="<?= base_url('news',true) ?>" method="GET">
      <div class="container d-flex flex-row py-6">
        <div class="search-form w-100">
          <input id="search-form" value="<?= (isset($search)) ? $search : ''; ?>" type="text" name="search" class="form-control" placeholder="Masukkan kata kunci pencarian" autocomplete="off">
        </div>
        <!-- /.search-form -->
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <?php if($category) : ?>
      <div class="container">
        <div class="row row-cols-2 row-cols-md-5 g-2">
          <?php foreach($category AS $row) : ?> 
          <div class="col">
            <div class="form-check">
              <input class="form-check-input" <?= (isset($arr_id) && in_array($row->id_category,$arr_id)) ? 'checked' : ''; ?> name="id_category[]" type="checkbox" value="<?= $row->id_category; ?>" id="cat-<?= $row->id_category; ?>">
              <label class="form-check-label" for="cat-<?= $row->id_category; ?>"><?= $row->name. ' ('.$row->cnt_news.')'; ?></label>
            </div>
          </div>
          <?php endforeach;?>
          <!-- Tambahkan sebanyak yang kamu mau -->
        </div>
      </div>
      <?php endif;?>
      <div class="container mt-10">
        <div class="w-100 d-flex justify-content-end align-items-center">
          <button class="btn btn-primary btn-sm">Cari</button>
        </div>
      </div>
  </form>
  

</div>