<?php

class Auth extends UserController
{
   var $id_user = '';
   public function __construct()
   {
      $this->action = $this->model('M_action');
      $this->id_user = session(WEB_NAME.'_id_user');
      $this->db = new Database;
   }

   public function login()
   {
      // VARIABEL
      $arrVar['email']             = 'Alamat email';
      $arrVar['password']           = 'Kata sandi';

      // INFORMASI UMUM
      foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
            $data['required'][] = ['req_login_' . $var, $value . ' tidak boleh kosong !'];
            $arrAccess[] = false;
            } else {
            if (!in_array($var,['password'])) {
                $post[$var] = trim($$var);
            }
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

        $cek = $this->action->get_single('user',['email' => $email]);
        if (!$cek) {
            $data['status'] = 700;
            $data['alert']['message'] = 'User tidak terdaftar!';
            echo json_encode($data);
            exit;
        }

        if ($cek->status == 'N') {
            $reason = $user->reason ? ' dengan alasan </br></br><b>"' . $user->reason . '!"</b></br></br>' : '!';

            $data['status'] = 700;
            $data['alert']['message'] = 'Anda telah di block dari sistem' . $reason . ' Hubungi admin jika terjadi kesalahan';
            echo json_encode($data);
            exit;
        }

        if ($cek->password != hash_my_password($email.$password)) {
            $data['status'] = 700;
            $data['alert']['message'] = 'Kata sandi tidak valid!';
            echo json_encode($data);
            exit;
        }

        $_SESSION[WEB_NAME.'_id_user'] = $cek->id_user;
        $_SESSION[WEB_NAME.'_name'] = $cek->name;
        $_SESSION[WEB_NAME.'_id_role'] = $cek->id_role;
        $_SESSION[WEB_NAME.'_email'] = $cek->email;
        $_SESSION[WEB_NAME.'_phone'] = $cek->phone;
        $_SESSION[WEB_NAME.'_image'] = $cek->image;

        $data['status'] = 200;
        $data['alert']['message'] = 'Anda berhasil masuk! Selamat datang <b>'. $cek->name.'</b>';
        $data['reload'] = true;
      } else {
         $data['status'] = false;
      }
      sleep(1.5);
      echo json_encode($data);
      exit;
   }

   public function register()
   {
      // VARIABEL
      $arrVar['name']             = 'Nama lengkap';
      $arrVar['phone']           = 'Nomor telepon';
      $arrVar['email']           = 'Alamat email';
      $arrVar['password']         = 'Kata sandi';
      $arrVar['repassword']         = 'Konfirmasi kata sandi';

      // INFORMASI UMUM
      foreach ($arrVar as $var => $value) {
        $$var = $_POST[$var] ?? '';
        if (!$$var) {
            $data['required'][] = ['req_register_' . $var, $value . ' tidak boleh kosong !'];
            $arrAccess[] = false;
        } else {
            if (!in_array($var,['password','repassword'])) {
                $post[$var] = trim($$var);
            }
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
        if ($password != $repassword) {
            $data['status'] = 700;
            $data['alert']['message'] = 'Konfirmasi kata sandi tidak sama!';
            echo json_encode($data);
            exit;
        }

        $cek_email = $this->action->get_single('user',['email' => $email,'status' => 'Y','delete' => 'N']);
        if ($cek_email) {
            $data['status'] = 700;
            $data['alert']['message'] = 'Email sudah terdaftar! Silahkan gunakan email lain.';
            echo json_encode($data);
            exit;
        }

        $cek_phone = $this->action->get_single('user',['phone' => $phone,'status' => 'Y','delete' => 'N']);
        if ($cek_phone) {
            $data['status'] = 700;
            $data['alert']['message'] = 'Nomor telepon sudah terdaftar! Silahkan gunakan nomor lain.';
            echo json_encode($data);
            exit;
        }
        $post['password'] = hash_my_password($email.$password);

         $insert = $this->action->insert('user', $post);
         if ($insert) {
               $data['status'] = true;
               $data['alert']['message'] = 'Berhasil mendaftarkan akun! Silahkan melakukan login';
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


   public function logout()
   {

      unset($_SESSION[WEB_NAME.'_id_user']);
      unset($_SESSION[WEB_NAME.'_id_role']);
      unset($_SESSION[WEB_NAME.'_nama']);
      unset($_SESSION[WEB_NAME.'_email']);
      unset($_SESSION[WEB_NAME.'_notelp']);
      unset($_SESSION[WEB_NAME.'_image']);

      redirect('home');
   }
}

