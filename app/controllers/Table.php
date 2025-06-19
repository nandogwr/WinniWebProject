<?php

class Table extends AdminController
{
   var $id_user = '';
   public function __construct()
   {
      $this->action = $this->model('M_action');
      $this->id_user = session(WEB_NAME.'_id_user');
      $this->db = new Database;
   }


    public function admin()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'user.name',
            'user.phone',
            'user.status'
        ];

        if ($search) {
            $params['columnsearch'][] = 'user.name';
            $params['columnsearch'][] = 'user.email';
            $params['columnsearch'][] = 'user.phone';
            $params['search'] = $search;
        }

        $where['user.delete'] = 'N';
        $where['user.id_role'] = 1;
        $where['user.id_user !='] = $this->id_user;
        // $where['user.id_user !='] = $this->id_user;

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['status'] = $filter_status;
            }
        }

        $totalRecords = $this->action->cnt_where_params('user', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'user.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('user',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $image = image_check($item->image, 'user', 'user');

                $user = '<div class="d-flex align-items-center">';
                $user .= '<a role="button" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $user .= '<div class="ms-5">';
                $user .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $user .= '</div></div>';

                $kontak = '';
                if ($item->email || $item->phone){
                    $kontak .= '<div class="d-flex justify-content-start flex-column">';
                    if ($item->email) {
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i>'.$item->email.'</span>';
                    }
                    if ($item->phone){
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i>'.$item->phone.'</span>';
                    }
                    $kontak .= '</div>';
                }else{
                    $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>';
                }

                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_user.')" data-url="'.base_url('setting/switch/user',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_user.'" '.$checked.'>';
                $status .= '</div></div>';

                $fl = '';
                if ($item->image && file_exists('./data/user/'.$item->image)) {
                    $fl = './data/user/'.$item->image;
                }
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_user.')" data-image="'.$image.'" data-bs-toggle="modal" data-bs-target="#kt_modal_admin">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_user.',`user`,`id_user`,`'.$fl.'`)" data-datatable="table_admin" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $user,
                    $kontak,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }


    public function member()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'user.name',
            'user.phone',
            'user.status'
        ];

        if ($search) {
            $params['columnsearch'][] = 'user.name';
            $params['columnsearch'][] = 'user.email';
            $params['columnsearch'][] = 'user.phone';
            $params['search'] = $search;
        }

        $where['user.delete'] = 'N';
        $where['user.id_role'] = 2;
        $where['user.id_user !='] = $this->id_user;
        // $where['user.id_user !='] = $this->id_user;

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['status'] = $filter_status;
            }
        }

        $totalRecords = $this->action->cnt_where_params('user', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'user.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('user',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $image = image_check($item->image, 'user', 'user');

                $user = '<div class="d-flex align-items-center">';
                $user .= '<a role="button" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $user .= '<div class="ms-5">';
                $user .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $user .= '</div></div>';

                $kontak = '';
                if ($item->email || $item->phone){
                    $kontak .= '<div class="d-flex justify-content-start flex-column">';
                    if ($item->email) {
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i>'.$item->email.'</span>';
                    }
                    if ($item->phone){
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i>'.$item->phone.'</span>';
                    }
                    $kontak .= '</div>';
                }else{
                    $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>';
                }

                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_user.')" data-url="'.base_url('setting/switch/user',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_user.'" '.$checked.'>';
                $status .= '</div></div>';

                $fl = '';
                if ($item->image && file_exists('./data/user/'.$item->image)) {
                    $fl = './data/user/'.$item->image;
                }
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_user.')" data-image="'.$image.'" data-bs-toggle="modal" data-bs-target="#kt_modal_member">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_user.',`user`,`id_user`,`'.$fl.'`)" data-datatable="table_member" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $user,
                    $kontak,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function category()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'category.name',
        ];

        if ($search) {
            $params['columnsearch'][] = 'category.name';
            $params['search'] = $search;
        }

        $where['category.delete'] = 'N';

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['status'] = $filter_status;
            }
        }

        $totalRecords = $this->action->cnt_where_params('category', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'category.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('category',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $category = '<div class="d-flex align-items-center">';
                $category .= '<div class="ms-5">';
                $category .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $category .= '</div></div>';


                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_category.')" data-url="'.base_url('setting/switch/category',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_category.'" '.$checked.'>';
                $status .= '</div></div>';

                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_category.')" data-bs-toggle="modal" data-bs-target="#kt_modal_category">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_category.',`category`,`id_category`)" data-message="Seluruh data berita yang terkait dengan kategori ini akan ikut di hapus! Apakah anda yakin akan menghapus kategori ini?" data-datatable="table_category" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $category,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function news()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';
        $filter_category = $_POST['filter_category'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            null,
            'news.title',
            'category.name',
            'cnt_fav',
            'news.status'
        ];

        if ($search) {
            $params['columnsearch'][] = 'news.title';
            $params['columnsearch'][] = 'category.name';
            $params['columnsearch'][] = 'news.short_description';
            $params['search'] = $search;
        }

        $where['news.delete'] = 'N';

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['news.status'] = $filter_status;
            }
        }
        if ($filter_category !== null && $filter_category !== '') {
            if ($filter_category != 'all') {
                $where['news.id_category'] = $filter_category;
            }
        }

        $totalRecords = $this->action->cnt_where_params('news', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'news.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        $params['arrjoin']['category']['statement'] = 'category.id_category = news.id_category';
        $params['arrjoin']['category']['type'] = 'LEFT';

        // SELECT
        $select = 'news.*,category.name AS category,category.color,(SELECT COUNT(*) FROM favorite WHERE favorite.id_news = news.id_news) AS cnt_fav';


        // Ambil data
        $result = $this->action->get_where_params('news',$where,$select,$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $image = image_check($item->image, 'news');

                $img = '<div class="d-flex align-items-center">';
                $img .= '<a role="button" class="symbol symbol-150px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $img .= '</div>';

                $news = '<div class="d-flex align-items-center">';
                $news .= '<div class="ms-5">';
                $news .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->title.'</a>';
                $news .= '</div></div>';

                $cat = '<span class="badge" style="background-color : '.$item->color.'">'.$item->category.'</span>';

                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_news.')" data-url="'.base_url('setting/switch/news',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_news.'" '.$checked.'>';
                $status .= '</div></div>';

                $fl = '';
                if ($item->image && file_exists('./data/news/'.$item->image)) {
                    $fl = './data/news/'.$item->image;
                }
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_news.')" data-image="'.$image.'" data-bs-toggle="modal" data-bs-target="#kt_modal_news">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_news.',`news`,`id_news`,`'.$fl.'`)" data-datatable="table_news" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $img,
                    $news,
                    $cat,
                    $item->cnt_fav,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function contact()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'contact.first_name',
            'contact.last_name',
            'contact.email',
            'contact.description',
        ];

        if ($search) {
            $params['columnsearch'][] = 'contact.first_name';
            $params['columnsearch'][] = 'contact.last_name';
            $params['columnsearch'][] = 'contact.email';
            $params['columnsearch'][] = 'contact.description';
            $params['search'] = $search;
        }

        $totalRecords = $this->action->cnt_where_params('contact', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'contact.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('contact',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_contact.',`contact`,`id_contact`)" data-message="Seluruh data berita yang terkait dengan kategori ini akan ikut di hapus! Apakah anda yakin akan menghapus kategori ini?" data-datatable="table_contact" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $item->first_name,
                    $item->last_name,
                    $item->email,
                    $item->description,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }
}

