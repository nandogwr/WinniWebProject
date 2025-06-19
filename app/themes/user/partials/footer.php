<footer class="bg-dark text-inverse">
    <div class="container py-13 py-md-15">
        <div class="row gy-6 gy-lg-0">
        <?php if($new_news) : ?>
        <div class="col-md-4 col-lg-3">
            <h4 class="widget-title text-white mb-3">Berita Terbaru</h4>
            <ul class="image-list">
                <?php foreach($new_news AS $row) : ?>
                <li class="cursor-pointer" onclick="detail_berita(this,<?= $row->id_news; ?>)" data-image="<?= image_check($row->image,'news'); ?>" data-bs-target="#modalDetailBerita" data-bs-toggle="modal">
                    <figure class="rounded"><a><img src="<?= image_check($row->image,'news'); ?>" alt="" /></a></figure>
                    <div class="post-content">
                    <h6 class="mb-2"> <a class="link-dark"><?= short_text($row->title,18); ?></a> </h6>
                    <ul class="post-meta">
                        <li class="post-date"><i class="fa-solid fa-calendar-alt"></i><span><?= date('d M Y',strtotime($row->create_date)); ?></span></li>
                    </ul>
                    <!-- /.post-meta -->
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
            <!-- /.image-list -->
        </div>
        <?php endif;?>

        <?php if($category) : ?>
        <!-- /column -->
        <div class="col-md-4 col-lg-3">
            <!-- /.widget -->
            <div class="widget">
            <h4 class="widget-title text-white mb-3">Kategori</h4>
            <ul class="unordered-list text-reset bullet-white ">
                <?php $nu = 0; foreach($category AS $row) : $nuu = $nu++;?>
                <?php if($nu <= 8) : ?>
                    <li><a href="<?= base_url('news',true).'?'.urlencode('id_category[]').'='.$row->id_category; ?>"><?= $row->name; ?> (<?= number_format($row->cnt_news,0,',','.'); ?>)</a></li>
                <?php endif;?>
                <?php endforeach;?>
            </ul>
            </div>
            <!-- /.widget -->
        </div>
        <!-- /column -->
        <?php endif;?>

        <?php if($web_email || $web_phone || $setting->meta_address) : ?>
        <div class="col-md-4 col-lg-3">
            <?php if(isset($setting) && $setting->meta_address) : ?>
            <div class="widget">
                <h4 class="widget-title text-white mb-3">Alamat</h4>
                <address class="pe-xl-10 pe-xxl-14"><?= $setting->meta_address; ?></address>
            </div>
            <?php endif;?>


            <?php if($web_email || $web_phone) : ?>
            <div class="widget">
                <h4 class="widget-title text-white mb-3">Kontak</h4>
                <?php if($web_email) : ?>
                    <?php foreach($web_email AS $row) : ?>
                    <i class="fa-solid fa-envelope me-2"></i> <span><?= $row->email; ?></span><br/> 
                    <?php endforeach;?>
                <?php endif;?>

                <?php if($web_phone) : ?>
                    <?php foreach($web_phone AS $row) : ?>
                        <i class="fa-solid fa-phone me-3"></i><?= ($row->name != '') ? $row->name.' | '.phone_format('0'.$row->phone) : phone_format('0'.$row->phone); ?><br/>
                    <?php endforeach;?>
                <?php endif;?>
                
            </div>
            <?php endif;?>
        </div>
        <?php endif;?>
        <!-- /column -->
        <div class="col-md-4 col-lg-3">
            <?php if(isset($setting) && $setting->meta_description) : ?>
            <div class="widget">
                <h4 class="widget-title text-white mb-3">Deskripsi</h4>
                <p class="pe-xl-10 pe-xxl-10"><?= $setting->meta_description; ?></p>
            </div>
            <?php endif;?>
                <!-- /.widget -->
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
            <div class="widget">
                <h4 class="widget-title text-white mb-3">Sosial Media</h4>
                <nav class="nav social social-white">
                    <?php foreach($sosmed AS $row) : ?>
                        <?php if($row->url != null && $row->url != '') : ?>
                        <a href="<?= $row->url; ?>" title="<?= $row->sosmed_name; ?>"><i class="<?= $row->icon; ?>"></i></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </nav>
                <!-- /.social -->
            </div>
            <!-- /.widget -->
            <?php endif;?>
        </div>
        <!-- /column -->
        </div>
        <!--/.row -->
        <p class="mt-6 mb-0 text-start">© <?= $setting->meta_title; ?> 2025</p>
    </div>
    <!-- /.container -->
</footer>

<?php if(!isset($_SESSION[WEB_NAME.'_id_user']) || $_SESSION[WEB_NAME.'_id_user'] == '') : ?>
<div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="modalLoginLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded">
            <div class="modal-body position-relative">
                <div class="w-100 position-absolute d-flex justify-content-end align-items-center px-10 pt-6" style="left : 0;top : 0;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form id="formLogin" method="POST" action="<?= base_url('auth/login',true); ?>" class="pt-5">
                    <div class="mb-3 text-center">
                        <h2 class="form-label">Login</h2>
                    </div>


                    <div class="mb-3" id="req_login_email">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email Anda" autocomplete="off">
                    </div>

                    <div class="mb-3 position-relative" id="req_login_password">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password anda" autocomplete="off">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <button onclick="submit_form(this,'#formLogin')" id="button_login" type="button" class="btn btn-primary w-100">Masuk</button>

                    <div class="text-center mt-3">
                        <p>Belum memiliki akun? <a role="button" onclick="toAuth('#formRegister','#formLogin')" class="text-primary">Daftar sekarang</a></p>
                    </div>
                </form>


                <form id="formRegister" class="pt-5 d-none" method="POST" action="<?= base_url('auth/register',true); ?>">
                    <div class="mb-3 text-center">
                        <h2 class="form-label">Daftar</h2>
                    </div>

                    <div class="mb-3" id="req_register_name">
                        <label for="register-name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" id="register-name" placeholder="Masukkan nama lengkap Anda" autocomplete="off">
                    </div>
                    <div class="mb-3" id="req_register_email">
                        <label for="register-email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="register-email" placeholder="Masukkan email Anda" autocomplete="off">
                    </div>

                    <div class="mb-3" id="req_register_phone">
                        <label for="phone-number" class="form-label">Nomor Telpon</label>
                        <input type="phone-number" name="phone" class="form-control" id="register-email" placeholder="Masukkan nomor telepon Anda" autocomplete="off">
                    </div>


                    <div class="mb-3 position-relative" id="req_register_password">
                        <label for="password2" class="form-label">Kata sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password2" placeholder="Masukkan kata sandi anda" autocomplete="off">
                            <span class="input-group-text" id="togglePassword2" style="cursor: pointer;">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3 position-relative" id="req_register_repassword">
                        <label for="password3" class="form-label">Kata sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="repassword" id="password3" placeholder="Masukkan konfirmasi kata sandi anda" autocomplete="off">
                            <span class="input-group-text" id="togglePassword3" style="cursor: pointer;">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>


                    <button role="button" id="button_register" onclick="submit_form(this,'#formRegister')" class="btn btn-primary w-100 text-white rounded-3 shadow-sm hover-shadow">Daftar</button>

                    


                    <div class="text-center mt-3">
                        <p>Sudah memiliki akun? <a role="button" class="text-primary"  onclick="toAuth('#formLogin','#formRegister')">Login di sini</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php endif;?>


<div class="modal fade" id="modalDetailBerita" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="modalDetailBeritaLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded">
            <div class="modal-body position-relative">
                <div class="w-100 position-absolute d-flex justify-content-end align-items-center px-10 pt-6" style="left : 0;top : 0;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                
                <div class="container pb-14 pb-md-16">
                    <div class="blog single">
                        <figure class="card-img-top"><img id="display_news_image" src="<?= image_check('default.jpg','setting') ?>" alt="" /></figure>
                            <div class="card-body">
                            <div class="classic-view">
                                <article class="post">
                                <div class="post-content mb-5">
                                    <h2 class="h1 mb-4" id="display_news_title"></h2>
                                    <p id="display_news_short"></p>
                                    <div id="display_news_description"></div>
                                </div>
                                </article>
                                <!-- /.post -->
                            </div>
                            <!-- /.classic-view -->
                        </div>
                            <!-- /.card-body -->
                    </div>
                    <!-- /.blog -->
                </div>
                <!-- /.container -->
            </div>
        </div>
    </div>
</div>

<?php if(isset($_SESSION[WEB_NAME.'_id_user']) && $_SESSION[WEB_NAME.'_id_user'] != '') : ?>
<div class="modal fade" id="modalProfil" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="modalProfilLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded">
            <div class="modal-header p-0">
                <div class="w-100 d-flex justify-content-end align-items-center px-10" style="z-index : 10;">
                    <button type="button" class="btn-close cursor-pointer" style="font-size : 30px;" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <form id="form_profile" method="POST" action="<?= base_url('user/ubah_profile',true); ?>" class="modal-body position-relative">
                <div class="text-center mb-4">
                    <label for="profileImageInput">
                        <div id="profileImage" style="background-image : url(<?= (isset($profile->image)) ? image_check($profile->image,'user','user') : image_check('user.jpg','default','user'); ?>);background-position : center;background-size : cover;background-repeat : no-repeat;width : 120px;height : 120px;cursor : pointer;border-radius : 100%;" alt="Profile Image"></div>
                    </label>
                    <input type="hidden" name="name_image" value="<?= (isset($profile->image)) ? $profile->image : ''; ?>">
                    <input type="file" id="profileImageInput" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

                <div class="mb-3" id="req_profile_name">
                    <label for="profile_name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="<?= (isset($profile->name)) ? $profile->name : ''; ?>" name="name" id="profile_name" placeholder="Masukkan nama Anda" autocomplete="off">
                </div>

                <div class="mb-3" id="req_profile_phone">
                    <label for="profile_phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" value="<?= (isset($profile->phone)) ? $profile->phone : ''; ?>" name="phone" id="profile_phone" placeholder="Masukkan nama Anda" autocomplete="off">
                </div>

                <hr class="my-2">

                <div class="mb-3" id="req_profile_email">
                    <label for="profile_email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?= (isset($profile->email)) ? $profile->email : ''; ?>" name="email" id="profile_email" placeholder="Masukkan email Anda" autocomplete="off">
                </div>

                <div class="mb-3 position-relative" id="req_profile_password">
                    <label for="password" class="form-label">Kata sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan kata sandi anda" autocomplete="off">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3 position-relative" id="req_profile_new_password">
                    <label for="password2" class="form-label">Kata sandi baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="new_password" id="password2" placeholder="Masukkan kata sandi baru" autocomplete="off">
                        <span class="input-group-text" id="togglePassword2" style="cursor: pointer;">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3 position-relative" id="req_profile_repassword">
                    <label for="password3" class="form-label">Konfirmasi Kata sandi baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="repassword" id="password3" placeholder="Masukkan konfirmasi kata sandi" autocomplete="off">
                        <span class="input-group-text" id="togglePassword3" style="cursor: pointer;">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                
                <button type="button" href="<?= base_url('logout',true) ?>" onclick="confirm_alert(this,event,'Apakah anda yakin akan meninggalkan sistem?')" class="btn btn-sm btn-danger me-2">Log Out</button>
                <button type="button" onclick="submit_form(this,'#form_profile')" id="button_submit_profile" class="btn btn-sm btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<?php endif;?>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        let passwordField = document.getElementById("password");
        let icon = this.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            passwordField.type = "password";
            icon.classList.replace("fa-eye", "fa-eye-slash");
            
        }
    });

    document.getElementById("togglePassword2").addEventListener("click", function () {
        let passwordField2 = document.getElementById("password2");
        let icon = this.querySelector("i");

        if (passwordField2.type === "password") {
            passwordField2.type = "text";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            passwordField2.type = "password";
            icon.classList.replace("fa-eye", "fa-eye-slash");
            
        }
    });

    document.getElementById("togglePassword3").addEventListener("click", function () {
        let passwordField3 = document.getElementById("password3");
        let icon = this.querySelector("i");

        if (passwordField3.type === "password") {
            passwordField3.type = "text";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            passwordField3.type = "password";
            icon.classList.replace("fa-eye", "fa-eye-slash");
            
        }
    });

    function toAuth(to,from) {
        $(to).removeClass('d-none');
        $(from).addClass('d-none');
    }
</script>
<script>
    
        var BASE_URL = BASEURL =  '<?= base_url('',true); ?>';
        var hostUrl = "<?= base_url(); ?>assets/frontend/";
        var css_btn_confirm = 'btn btn-sm btn-primary mx-1';
        var css_btn_cancel = 'btn btn-sm btn-danger mx-1';
        var base_foto = '<?= image_check('notfound.jpg','default') ?>';
        var user_base_foto = '<?= image_check('user.jpg','default') ?>';
        addEventListener('keypress', function(e) {
            if (e.keyCode === 13 || e.which === 13) {
                e.preventDefault();
                return false;
            }
        });
        var div_loading = '<div class="logo-spinner-parent">\
                            <div class="logo-spinner">\
                                <img src="<?= image_check('icon_blue.png','attribut'); ?>" alt="">\
                                <div class="logo-spinner-loader"></div>\
                            </div>\
                            <p id="text_loading">Tunggu sebentar...</p>\
                        </div>';
        
                  
  </script>
<script src="<?= assets_url('public') ?>/js/jquery.js"></script>
<script src="<?= assets_url('user') ?>/js/plugins.js"></script>
<script src="<?= assets_url('user') ?>/js/theme.js"></script>
<script src="<?= assets_url('public/'); ?>js/alert.js"></script>
<script src="<?= assets_url('public/'); ?>js/mekanik.js"></script>
<script src="<?= assets_url('public/'); ?>js/function.js"></script>
<script src="<?= assets_url('public/'); ?>js/global.js"></script>

<script>
    function detail_berita(element, id) {
        var foto = $(element).data('image');
        var image = document.getElementById('display_news_image');

        $.ajax({
            url: BASE_URL + 'user/get_detail_news',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                image.style.backgroundImage = "url('" + foto + "')";
                console.log(data.result);
                $('#display_news_title').text(data.result.title);
                $('#display_news_short').html(data.result.short_description);
                $('#display_news_description').html(data.result.description);
            }
        })
    }

    function save_news(element,remove = false) {
        const label = document.querySelector('label[for="check-news-' + element.value + '"]');
        var value = element.value;

        if (element.checked) {
            var status = 'tambah';
        } else {
            var status = 'hapus';
        }
        // console.log(status);

        $.ajax({
            url: BASE_URL + 'user/set_save',
            method: 'POST',
            data: { id: value, status : status},
            dataType: 'json',
            success: function (data) {
                if (data == true) {
                    if (status == 'tambah') {
                        label.classList.replace("fa-regular", "fa-solid");
                        label.classList.add("text-primary");
                    } else {
                        if (remove == true) {
                            $('#news-'+value).remove();
                        }
                        label.classList.replace("fa-solid", "fa-regular");
                        label.classList.remove("text-primary");
                    } 
                }
            }
        })
    }

    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function() {
            const imgElement = document.getElementById("profileImage");
            imgElement.style.backgroundImage = `url(${reader.result})`;

        }

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>