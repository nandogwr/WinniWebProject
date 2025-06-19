<?php

class Master extends AdminController
{
    var $id_user = '';
    public function __construct()
    {
        $this->action = $this->model('M_action');
        $this->id_user = session(WEB_NAME.'_id_user');
        $this->db = new Database;
    }

    public function index()
    {
        redirect('master/admin');
    }


    public function admin(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Admin';
        $data['subtitle'] = 'Manajemen akun admin';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/admin"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/admin.js').'"></script>';

        // DISPLAY
        $this->display('master/admin',$data);
    }

    public function member(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Member';
        $data['subtitle'] = 'Manajemen akun member';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/member"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/member.js').'"></script>';

        // DISPLAY
        $this->display('master/member',$data);
    }

    public function category(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Kategori';
        $data['subtitle'] = 'Manajemen data kategori';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/category"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/category.js').'"></script>';

        // DISPLAY
        $this->display('master/category',$data);
    }

    public function news(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Berita';
        $data['subtitle'] = 'Manajemen data berita';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/news"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/news.js').'"></script>';

        // GET DATA
        $category = $this->action->get_all('category',['status' => 'Y','delete' => 'N']);
        
        // SET DATA
        $data['category'] = $category;

        // DISPLAY
        $this->display('master/news',$data);
    }

    public function contact(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Kotak Pesan';
        $data['subtitle'] = 'Manajemen pesan customer';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/contact"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/contact.js').'"></script>';

        // DISPLAY
        $this->display('master/contact',$data);
    }




    // FUNCTION USER
    public function tambah($page = 'member')
    {
        // VARIABEL
        $arrVar['name']             = 'Nama user';
        $arrVar['phone']           = 'Nomor telepon';
        $arrVar['email']           = 'Alamat email';
        $arrVar['id_role']         = 'Role';
        $arrVar['password']         = 'Kata sandi';
        $arrVar['repassword']       = 'Konfirmasi kata sandi ';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if (!in_array($var, ['password', 'repassword'])) {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $tujuan = './data/user/';
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/user/')) {
                    mkdir('./data/user');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];

                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }
            if (!validasi_email($email)) {
                $data['status'] = 700;
                $data['alert']['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
                echo json_encode($data);
                exit;
            }
            $user_mail = $this->action->get_single('user', ['email' => $email]);
            if ($user_mail) {
                $data['status'] = false;
                $data['alert']['message'] = 'Email sudah terdaftar sebagai user!';
                echo json_encode($data);
                exit;
            }else{
                $user_mail = $this->action->get_single('user', ['email' => $email]);
                if ($user_mail) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Email sudah terdaftar sebagai member!';
                    echo json_encode($data);
                    exit;
                }
            }
             $user_telp = $this->action->get_single('user', ['phone' => $phone]);
            if ($user_telp) {
                $data['status'] = false;
                $data['alert']['message'] = 'Nomor telepon sudah terdaftar!';
                echo json_encode($data);
                exit;
            }

            if ($password != $repassword) {
                $data['status'] = false;
                $data['alert']['message'] = 'Konfirmasi password tidak sesuai!';
                echo json_encode($data);
                exit;
            } else {
                $post['password'] = hash_my_password($email . $password);
            }
            if ($this->id_user) {
                $post['create_by'] = $this->id_user;
            }
            
            $insert = $this->action->insert('user', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data '.$page.' berhasil di tambahkan!';
                $data['datatable'] = 'table_'.$page;
                $data['modal']['id'] = '#kt_modal_'.$page;
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function update($page = 'member')
    {
        // VARIABEL
        $arrVar['id_user']          = 'Id user';
        $arrVar['id_role'] = 'Role';
        $arrVar['name']             = 'Nama user';
        $arrVar['phone']           = 'Nomor telepon';
        $arrVar['email']            = 'Alamat email';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var];
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $result = $this->action->get_single('user', ['id_user' => $id_user]);
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';
        $name_image = $_POST['name_image'] ?? '';
        $tujuan = './data/user/';
        if ($result->email != $email) {
            if (!validasi_email($email)) {
                $data['status'] = 700;
                $data['alert']['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
                echo json_encode($data);
                exit;
            }
            $user_mail = $this->action->get_single('user', ['email' => $email,'id_user !=' => $id_user]);
            if ($user_mail) {
                $data['status'] = false;
                $data['alert']['message'] = 'Email sudah terdaftar sebagai user!';
                echo json_encode($data);
                exit;
            }else{
                $user_mail = $this->action->get_single('user', ['email' => $email]);
                if ($user_mail) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Email sudah terdaftar sebagai user!';
                    echo json_encode($data);
                    exit;
                }
            } 
            if (!$password) {
                $data['required'][] = ['req_password', 'Kata sandi tidak boleh kosong ! Karena email berubah'];
                $arrAccess[] = false;
            } 
            if (!$repassword) {
                $data['required'][] = ['req_repassword', 'Konfirmasi kata sandi tidak boleh kosong ! Karena email berubah'];
                $arrAccess[] = false;
            }   
             
        }
        if (!in_array(false, $arrAccess)) {
            if ($result->phone != $phone) {
                $cek_phone = $this->action->get_single('user', ['phone' => $phone,'id_user !=' => $id_user]);
                if ($cek_phone) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Nomor telepon sudah terdaftar!';
                    echo json_encode($data);
                    exit;
                }      
            }

            if ($password) {
                if ($password != $repassword) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Konfirmasi password tidak sesuai!';
                    echo json_encode($data);
                    exit;
                } else {
                    $post['password'] = hash_my_password($email . $password);
                }
            } 

            if (!empty($_FILES['image']['tmp_name'])) {
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/user/')) {
                    mkdir('./data/user');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];
                    if ($name_image) {
                        if (file_exists($tujuan.$name_image)) {
                            unlink($tujuan.$name_image);
                        }
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                 if (!$name_image) {
                    if ($result->image != '' && file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                    $post['image'] = '';
                }
            }
            
            $update = $this->action->update('user', $post, ['id_user' => $id_user]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data '.$page.' berhasil di rubah!';
                $data['datatable'] = 'table_'.$page;
                $data['modal']['id'] = '#kt_modal_'.$page;
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }



    // FUNCTION CATEGORY
    public function insert_category()
    {
        // VARIABEL
        $arrVar['name']             = 'Nama kategori';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        if (!in_array(false, $arrAccess)) {
            if ($this->id_user) {
                $post['create_by'] = $this->id_user;
            }
            
            $insert = $this->action->insert('category', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data kategori berhasil di tambahkan!';
                $data['datatable'] = 'table_category';
                $data['modal']['id'] = '#kt_modal_category';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function update_category()
    {
        // VARIABEL
        $arrVar['id_category']          = 'Id category';
        $arrVar['name']             = 'Nama kategori';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var];
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $result = $this->action->get_single('category', ['id_category' => $id_category]);
        if (!in_array(false, $arrAccess)) {
            
            $update = $this->action->update('category', $post, ['id_category' => $id_category]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data kategori berhasil di rubah!';
                $data['datatable'] = 'table_category';
                $data['modal']['id'] = '#kt_modal_category';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    // FUNCTION NEWS
    public function insert_news()
    {
        // VARIABEL
        $arrVar['title']                 = 'Judul berita';
        $arrVar['id_category']           = 'Kategori';
        $arrVar['short_description']     = 'Deskripsi singkat';
        $arrVar['description']           = 'Deskripsi';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if (in_array($var,['description'])) {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, $value." tidak boleh kosong!"];
                        $arrAccess[] = false;
                    } else {
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                } else {
                    if ($$var === '') {
                        $data['required'][] = ['req_' . $var, $value." tidak boleh kosong!"];
                        $arrAccess[] = false;
                    } else {
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $tujuan = './data/news/';
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/news/')) {
                    mkdir('./data/news');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];

                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                $data['status'] = false;
                $data['alert']['message'] ='Gambar tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            
            if ($this->id_user) {
                $post['create_by'] = $this->id_user;
            }
            
            $insert = $this->action->insert('news', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data berita berhasil di tambahkan!';
                $data['datatable'] = 'table_news';
                $data['modal']['id'] = '#kt_modal_news';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function update_news()
    {
        // VARIABEL
        $arrVar['id_news']                 = 'ID News';
        $arrVar['title']                 = 'Judul berita';
        $arrVar['id_category']           = 'Kategori';
        $arrVar['short_description']     = 'Deskripsi singkat';
        $arrVar['description']           = 'Deskripsi';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if (in_array($var,['description'])) {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, $value." tidak boleh kosong!"];
                        $arrAccess[] = false;
                    } else {
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                } else {
                    if ($$var === '') {
                        $data['required'][] = ['req_' . $var, $value." tidak boleh kosong!"];
                        $arrAccess[] = false;
                    } else {
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }
            }
        }
        $result = $this->action->get_single('news', ['id_news' => $id_news]);
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';
        $name_image = $_POST['name_image'] ?? '';
        $tujuan = './data/news/';
        if (!in_array(false, $arrAccess)) {

            if (!empty($_FILES['image']['tmp_name'])) {
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/news/')) {
                    mkdir('./data/news');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];
                    if ($name_image) {
                        if (file_exists($tujuan.$name_image)) {
                            unlink($tujuan.$name_image);
                        }
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                if (!$name_image) {
                    $data['status'] = false;
                    $data['alert']['message'] ='Gambar tidak boleh kosong!';
                    echo json_encode($data);
                    exit;
                }else{
                    if ($result->image == '' || !file_exists($tujuan.$result->image)) {
                        $data['status'] = false;
                        $data['alert']['message'] ='Gambar tidak boleh kosong!';
                        echo json_encode($data);
                        exit;
                    }
                }
            }
            
            $update = $this->action->update('news', $post, ['id_news' => $id_news]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data berita berhasil di rubah!';
                $data['datatable'] = 'table_news';
                $data['modal']['id'] = '#kt_modal_news';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }
}

