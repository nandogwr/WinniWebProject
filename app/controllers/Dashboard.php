<?php

class Dashboard extends AdminController
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
      $data['title'] = 'Beranda';
      $data['subtitle'] = 'Pantau trafik dan Akses Cepat';

      // LOAD JS
      $data['js'][] = '<script>var page = "dashboard"</script>';
      $data['js'][] = '<script src="'.assets_url('admin/js/modul/dashboard/dashboard.js').'"></script>';

      // GET DATA
      $jml_news = 0;
      $jml_admin = 0;
      $jml_member = 0;
      // NEWS
       $query = "SELECT n.*, COUNT(f.id_news) AS total_fav, c.name AS category, c.color
      FROM news n
      JOIN favorite f ON n.id_news = f.id_news
      LEFT JOIN category c ON n.id_category = c.id_category
      GROUP BY n.id_news
      HAVING total_fav > 0
      ORDER BY total_fav DESC
      LIMIT 5
      ";

      $this->db->query($query);
      $news = $this->db->resultSet();
      // USER
      $user = $this->action->get_all('user',['status' => 'Y','delete' => 'N']);
      // KATEGORI
      $category = $this->action->get_all('category',['status' => 'Y','delete' => 'N'],'category.*,(SELECT COUNT(*) FROM news WHERE news.id_category = category.id_category) AS total');

      // PROSES

      // COUNTING
      if ($news) {
         $jml_news = count($news);
      }

      if ($user) {
         foreach ($user as $key) {
            if ($key->id_role == 1) {
               $jml_admin += 1;
            }else{
               $jml_member += 1;
            }
         }
      }
      
      // GRAFIK
      $gcat = [];
      if ($category) {
         $no = 0;
         foreach ($category as $key) {
            $num = $no++;
            $gcat[$num]['category'] = $key->name;
            $gcat[$num]['value'] = $key->total;
         }
      }

      // SET DATA
      $data['jml_news'] = $jml_news;
      $data['jml_admin'] = $jml_admin;
      $data['jml_member'] = $jml_member;
      $data['gcat'] = $gcat;
     
      // DISPLAY
      $this->display('dashboard/index',$data);
   }
}

