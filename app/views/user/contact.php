<section class="wrapper image-wrapper bg-image text-white" data-image-src="<?= image_check('contact.jpeg','default'); ?>">
    <div class="container pt-17 pb-20 pt-md-19 pb-md-21 text-center">
    <div class="row">
        <div class="col-lg-8 mx-auto">
        <h1 class="display-1 mb-3 text-white">Hubungi Kami</h1>
        <nav class="d-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
            <li class="breadcrumb-item text-white">Tinggalkan pesan untuk kami</li>
            </ol>
        </nav>
        <!-- /nav -->
        </div>
        <!-- /column -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /section -->
<section class="wrapper bg-light angled upper-end">
    <div class="container pb-11">
    <div class="row">
        <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2 card mt-n19 pt-10">
        <form id="form_contact" class="contact-form needs-validation" method="post" action="<?= base_url('user/send_contact',true); ?>" novalidate>
            <div class="messages"></div>
            <div class="row gx-4">
            <div class="col-md-6 mb-4" id="req_first_name">
                <div class="form-floating">
                <input id="form_first_name" type="text" name="first_name" class="form-control" placeholder="Masukkan nama depan" required autocomplete="off">
                <label for="form_first_name">Nama Depan *</label>
                </div>
            </div>
            <!-- /column -->
            <div class="col-md-6 mb-4" id="req_last_name">
                <div class="form-floating">
                <input id="form_last_name" type="text" name="last_name" class="form-control" placeholder="Masukkan nama belakang" required autocomplete="off">
                <label for="form_last_name">Nama Belakang *</label>
                </div>
            </div>
            <!-- /column -->
            <div class="col-md-12 mb-4" id="req_email">
                <div class="form-floating">
                <input id="form_email" type="email" name="email" class="form-control" placeholder="Masukkan alamat email" required autocomplete="off">
                <label for="form_email">Alamat Email *</label>
                </div>
            </div>
            <!-- /column -->
            <div class="col-12 mb-4" id="req_description">
                <div class="form-floating">
                <textarea id="form_description" name="description" class="form-control" placeholder="Masukkan Pesan" style="height: 150px" required autocomplete="off"></textarea>
                <label for="form_description">Pesan *</label>
                </div>
            </div>
            <!-- /column -->
            <div class="col-12 text-center">
                <button id="btn_contact" type="button"  onclick="submit_form(this,'#form_contact')" class="btn btn-primary rounded-pill btn-send mb-3">Kirim Pesan</button>
            </div>
            <!-- /column -->
            </div>
            <!-- /.row -->
        </form>
        <!-- /form -->
        </div>
        <!-- /column -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /section -->