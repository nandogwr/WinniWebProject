<?php

class Controller
{
   public function view($view, $data = [], $template = 'base', $return = false)
   {
      extract($data);

      // 1. Tangkap isi view sebagai string
      ob_start();
      if (file_exists('./app/views/' . $view . '.php')) {
         include './app/views/' . $view . '.php';
      } else {
         include './app/config/error/notfound.php';
      }
      $content = ob_get_clean(); // $content berisi HTML dari view

      // 2. Render layout dengan $content ditanam
      if ($return) {
         ob_start();
      }

      include "./app/themes/{$template}/base.php"; // layout pakai $content

      if ($return) {
         return ob_get_clean();
      }
   }



   public function model($model)
   {
      require_once "./app/models/$model.php";
      return new $model;
   }
}

class AdminController extends Controller
{

   public function display($view, $data = [])
   {
      $id_user = session(WEB_NAME.'_id_user');
      $id_role = session(WEB_NAME.'_id_role');
      
      // PROFILE
      $profile = [];
      if ($this->id_user) {
         $pro = $this->action->get_single('user',['id_user' => $this->id_user,'status' => 'Y','delete' => 'N']);
         if (!$pro) {
            redirect('logout');
         }
         $profile = $pro;

         if ($pro->id_role != 1) {
            redirect('home');
         }
      }

      $where['id_setting'] = 1;
      // SETTING
      $setting = $this->action->get_single('setting',$where);

      // SET DATA
      $data['setting'] = $setting;
      $data['profile'] = $profile;
      
      $themes = 'admin';

      $this->view('admin/'.$view, $data,$themes);

   }
    
}

class UserController extends Controller
{

   public function display($view, $data = [])
   {
      $id_user = session(WEB_NAME.'_id_user');
      $id_role = session(WEB_NAME.'_id_role');
      
      // PROFILE
      $profile = [];
      if ($this->id_user) {
         $pro = $this->action->get_single('user',['id_user' => $this->id_user,'status' => 'Y','delete' => 'N']);
         if (!$pro) {
            redirect('logout');
         }
         $profile = $pro;

         if ($pro->id_role != 2) {
            redirect('dashboard');
         }
      }

      $where['id_setting'] = 1;
      // SETTING
      $setting = $this->action->get_single('setting',$where);
      $web_phone = $this->action->get_all('web_phone',$where);
      $web_email = $this->action->get_all('web_email',$where);

      // SOSMED
      $params['arrjoin']['sosmed']['statement'] = 'sosmed.id_sosmed = sosmed_setting.id_sosmed';
      $params['arrjoin']['sosmed']['type'] = 'LEFT';
      $sosmed = $this->action->get_where_params('sosmed_setting',$where,'sosmed.*,sosmed_setting.url,sosmed_setting.name_sosmed',$params);
      
      // NEW NEWS
      $params2['arrjoin']['category']['statement'] = 'category.id_category = news.id_category';
      $params2['arrjoin']['category']['type'] = 'LEFT';
      $params2['limit'] = 3;
      $params2['sort'] = 'news.create_date';
      $params2['order'] = 'DESC';

      $where2['news.status'] = 'Y';
      $where2['news.delete'] = 'N';
      $where2['category.status'] = 'Y';
      $where2['category.delete'] = 'N';
      
      $new_news = $this->action->get_where_params('news',$where2,'news.*,category.name AS category',$params2);

      // CATEGORY

      $category = $this->action->get_all('category',['category.status' => 'Y','category.delete' => 'N'],'category.*,(SELECT COUNT(*) FROM news WHERE news.id_category = category.id_category) AS cnt_news');

      $arr_fav = [];
      if ($this->id_user) {
         $fav = $this->action->get_all('favorite',['id_user' => $this->id_user]);
         if ($fav) {
            foreach ($fav as $key) {
               $arr_fav[] = $key->id_news;
            }
         }
      }
      
      

      // SET DATA
      $data['setting'] = $setting;
      $data['sosmed'] = $sosmed;
      $data['new_news'] = $new_news;
      $data['web_phone'] = $web_phone;
      $data['web_email'] = $web_email;
      $data['fav'] = $arr_fav;
      $data['category'] = $category;
      $data['profile'] = $profile;
      
      $themes = 'user';
      $this->view('user/'.$view, $data,$themes);

   }
    
}
