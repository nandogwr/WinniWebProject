<?php

class User extends UserController
{
   var $id_user = '';
   public function __construct()
   {
      $this->action = $this->model('M_action');
      $this->id_user = session(WEB_NAME.'_id_user');
      $this->db = new Database;
   }

   public function index(){
      $data = [];
      // GLBL
      $data['title'] = 'Home';

      // LOAD JS
      $data['js'][] = '<script>var page = "home"</script>';

      // REKOMENDASI

      $query = "SELECT n.*, COUNT(f.id_news) AS total_fav, c.name AS category, c.color
      FROM news n
      JOIN favorite f ON n.id_news = f.id_news
      LEFT JOIN category c ON n.id_category = c.id_category
      GROUP BY n.id_news
      HAVING total_fav > 0
      ORDER BY total_fav DESC
      LIMIT 6
      ";

      $this->db->query($query);
      $recomendasi = $this->db->resultSet();

       // WHERE
      $where['news.status'] = 'Y';
      $where['news.delete'] = 'N';
      $where['category.status'] = 'Y';
      $where['category.delete'] = 'N';

      // PARAMS
      $params['arrjoin']['category']['statement'] = 'category.id_category = news.id_category';
      $params['arrjoin']['category']['type'] = 'LEFT';
      $params['sort'] = 'news.create_date';
      $params['order'] = 'DESC';

      // SELECT
      $select = 'news.*,category.name AS category,category.color,(SELECT COUNT(*) FROM favorite WHERE favorite.id_news = news.id_news) AS cnt_fav';

      $params['limit'] = 6;

      $result = $this->action->get_where_params('news',$where,$select,$params);


      $data['result'] = $result;
      $data['recomendasi'] = $recomendasi;

      $this->display('index',$data);
   }

   public function news(){
      $data = [];
      $search = (isset($_GET['search'])) ? urldecode($_GET['search']) : '';
      $arr_id = [];
      if (isset($_GET['id_category']) && is_array($_GET['id_category'])) {
         foreach ($_GET['id_category'] as $id) {
            $arr_id[] = htmlspecialchars($id);
         }
      }
      $offset = (isset($_GET['offset'])) ? $_GET['offset'] : 1;
      $limit = 9;
      $start = ($offset - 1) * $limit;
      // GLBL
      $data['title'] = 'Berita';

      // ALL

      // WHERE
      $where['news.status'] = 'Y';
      $where['news.delete'] = 'N';
      $where['category.status'] = 'Y';
      $where['category.delete'] = 'N';

      // PARAMS
      $params['arrjoin']['category']['statement'] = 'category.id_category = news.id_category';
      $params['arrjoin']['category']['type'] = 'LEFT';
      $params['sort'] = 'news.create_date';
      $params['order'] = 'DESC';

      if ($search) {
         $params['columnsearch'][] = 'news.title';
         $params['columnsearch'][] = 'category.name';
         $params['search'] = $search;
      }

      if (!empty($arr_id) && is_array($arr_id)) {
         $where['news.id_category'] = $arr_id;
      }
      // SELECT
      $select = 'news.*,category.name AS category,category.color,(SELECT COUNT(*) FROM favorite WHERE favorite.id_news = news.id_news) AS cnt_fav';

      $jumlah = $this->action->cnt_where_params('news',$where,$params);
      
      $params['limit'] = $limit;
      $params['offset'] = $start;

      $result = $this->action->get_where_params('news',$where,$select,$params);

      
      // LOAD JS
      $data['js'][] = '<script>var page = "news"</script>';

      $data['result'] = $result;
      $data['jumlah'] = $jumlah;
      $data['offset'] = $offset;
      $data['start'] = $start;
      $data['arr_id'] = $arr_id;
      $data['search'] = $search;
      $data['total'] = ($jumlah > 0) ? ($jumlah / $limit) : 0;

      $this->display('news',$data);
   }

   public function favorite(){
      if (!$this->id_user) {
         redirect('home');
      }
      $offset = (isset($_GET['offset'])) ? $_GET['offset'] : 1;
      $limit = 9;
      $start = ($offset - 1) * $limit;
      // GLBL
      $data['title'] = 'Berita';

      // ALL

      // WHERE
      $arr_fav = [];
      if ($this->id_user) {
         $fav = $this->action->get_all('favorite',['id_user' => $this->id_user]);
         if ($fav) {
            foreach ($fav as $key) {
               $arr_fav[] = $key->id_news;
            }
         }
      }

      $jumlah = 0;
      $result = [];
      if (count($arr_fav) > 0) {
          $where['news.status'] = 'Y';
         $where['news.delete'] = 'N';
         $where['category.status'] = 'Y';
         $where['category.delete'] = 'N';
         $where['news.id_news'] = $arr_fav;

         // PARAMS
         $params['arrjoin']['category']['statement'] = 'category.id_category = news.id_category';
         $params['arrjoin']['category']['type'] = 'LEFT';
         $params['arrjoin']['favorite']['statement'] = 'favorite.id_news = news.id_news';
         $params['arrjoin']['favorite']['type'] = 'LEFT';
         $params['sort'] = 'favorite.create_date';
         $params['order'] = 'DESC';

         // SELECT
         $select = 'news.*,category.name AS category,category.color,favorite.create_date AS ambil,(SELECT COUNT(*) FROM favorite WHERE favorite.id_news = news.id_news) AS cnt_fav';

         $jumlah = $this->action->cnt_where_params('news',$where,$params);
         
         $params['limit'] = $limit;
         $params['offset'] = $start;

         $result = $this->action->get_where_params('news',$where,$select,$params);

      }

     
      
      // LOAD JS
      $data['js'][] = '<script>var page = "favorite"</script>';

      $data['result'] = $result;
      $data['jumlah'] = $jumlah;
      $data['offset'] = $offset;
      $data['start'] = $start;
      $data['total'] = ($jumlah > 0) ? ($jumlah / $limit) : 0;

      $this->display('favorite',$data);
   }


   public function contact(){
      $data = [];
      // GLBL
      $data['title'] = 'Hubungi Kami';

      // LOAD JS
      $data['js'][] = '<script>var page = "contact"</script>';

      $this->display('contact',$data);
   }


   public function send_contact()
   {
      // VARIABEL
      $arrVar['first_name']             = 'Nama depan';
      $arrVar['last_name']           = 'Nama belakang';
      $arrVar['email']           = 'Alamat email';
      $arrVar['description']         = 'Pesan';

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
         if (!validasi_email($email)) {
               $data['status'] = 700;
               $data['alert']['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
               echo json_encode($data);
               exit;
         }

         $insert = $this->action->insert('contact', $post);
         if ($insert) {
               $data['status'] = true;
               $data['alert']['message'] = 'Berhasil meninggalkan pesan!';
               $data['reload'] = true;
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

   public function get_detail_news()
   {
      $id = $_POST['id'] ?? 0;

      // WHERE
      $where['id_news'] = $id;
      // PARAMS
      $params['arrjoin']['category']['statement'] = 'category.id_category = news.id_category';
      $params['arrjoin']['category']['type'] = 'LEFT';

      // SELECT
      $select = 'news.*,category.name AS category,category.color';

      $result = $this->action->get_where_params('news',$where,$select,$params);

      $save = false;
      $arr = [];
      if ($this->id_user != null) {
         $cek = $this->action->get_single('favorite',['id_news' => $id,'id_user' => $this->id_user]);
         if ($cek) {
            $save = true;
         }
         $en = true;
      }else{
         $en = false;
      }

      if ($result) {
         $arr = $result[0];
      }

      $data['save'] = $save;
      $data['en'] = $en;
      $data['result'] = $arr;

      echo json_encode($data);
      exit;
      

   }



   public function set_save()
   {
      $post['id_news'] = $_POST['id'] ?? 0;
      $post['id_user'] = $this->id_user;

      $status = $_POST['status'] ?? 'hapus';
      if ($status == 'hapus') {
         $action = $this->action->delete('favorite',$post);
      }else{
         $action = $this->action->insert('favorite',$post);
      }
      echo json_encode(true);
      exit;
   }

   public function ubah_profile()
   {
      // VARIABEL
      $arrVar['name']             = 'Nama lengkap';
      $arrVar['email']            = 'Alamat email';
      $arrVar['phone']           = 'Nomor telepon';

      // INFORMASI UMUM
      foreach ($arrVar as $var => $value) {
         $$var = $_POST[$var] ?? '';
         if (!$$var) {
               $data['required'][] = ['req_profile_'.$var,$value.' tidak boleh kosong!'];
               $arrAccess[] = false;
         } else {
               $post[$var] = trim($$var);
               $arrAccess[] = true;
         }
      }
      $id_user = $this->id_user;

      $result = $this->action->get_single('user', ['id_user' => $id_user]);
      $password = $_POST['password'] ?? '';
      $new_password = $_POST['new_password'] ??'';
      $repassword = $_POST['repassword'] ??'';
      $name_image = $_POST['name_image'] ??'';

      if ($result->email != $email) {
         $cek_email = $this->action->get_single('user', ['email' => $email]);
         if ($cek_email) {
               $data['status'] = false;
               $data['alert']['message'] = 'Alamat email sudah terdaftar!';
               echo json_encode($data);
               exit;
         }   
         if (!$password) {
               $data['required'][] = ['req_profile_password', 'Kata sandi tidak boleh kosong! Karena alamat email berubah'];
               $arrAccess[] = false;
         } 

         if (!$new_password) {
               $data['required'][] = ['req_profile_new_password', 'Kata sandi baru tidak boleh kosong! Karena alamat email berubah'];
               $arrAccess[] = false;
         } 
         if (!$repassword) {
               $data['required'][] = ['req_profile_repassword', 'Konfirmasi kata sandi tidak boleh kosong! Karena alamat email berubah'];
               $arrAccess[] = false;
         }     
      }
      if (!in_array(false, $arrAccess)) {
         $tujuan = './data/user/';
         if (!empty($_FILES['image']['tmp_name'])) {
               if (!file_exists('./data/')) {
                  mkdir('./data/');
               }
               if (!file_exists('./data/user/')) {
                  mkdir('./data/user/');
               }
               $config['upload_path'] = $tujuan;
               $config['allowed_types'] = array('png','jpg','jpeg');
               $config['file'] = $_FILES['image'];

               $upload = upload_file($config);
               if ($upload['status'] == true) {
                  $post['image'] = $upload['data']['nama'];
                  $_SESSION[WEB_NAME.'_image'] = $upload['data']['nama'];
                  // if (file_exists($tujuan . $nama_image)) {
                  //     unlink($tujuan . $nama_image);
                  // }
                  

               } else {
               
                  $data['status'] = false;
                  $data['alert']['message'] = $upload['message'];
                  echo json_encode($data);
                  exit;
               }
         }
         if (!validasi_email($email)) {
               $data['status'] = false;
               $data['alert']['message'] = 'Alamat email tidak valid! ';
               echo json_encode($data);
               exit;
         }

         if ($result->phone != $phone) {
               $cek_phone = $this->action->get_single('user', ['phone' => $phone]);
               if ($cek_phone) {
                  $data['status'] = false;
                  $data['alert']['message'] = 'Nomor telepon telah terdaftar!';
                  echo json_encode($data);
                  exit;
               }
         }

         if ($password) {
               if (hash_my_password($result->email.$password) == $result->password) {
                  if ($new_password != $repassword) {
                     $data['status'] = false;
                     $data['alert']['message'] = 'Konfirmasi kata sandi tidak valid!';
                     echo json_encode($data);
                     exit;
                  } else {
                     $post['password'] = hash_my_password($email . $new_password);
                  }
               }else{
                  $data['status'] = false;
                  $data['alert']['message'] = 'Kata sandi tidak valid!';
                  echo json_encode($data);
                  exit;
               }
               
         }
         
         $update = $this->action->update('user', $post, ['id_user' => $id_user]);
         if ($update) {
               $_SESSION[WEB_NAME.'_name'] = $name;
               $_SESSION[WEB_NAME.'_email'] = $email;
               $_SESSION[WEB_NAME.'_phone'] = $phone;
               $data['status'] = true;
               $data['alert']['message'] = 'Data berhasil dirubah';
               $data['reload'] = true;
         } else {
               $data['status'] = false;
               $data['alert']['message'] = 'Data gagal dirubah';
         }
      } else {
         $data['status'] = false;
      }
      sleep(1.5);
      echo json_encode($data);
      exit;
   }
}

