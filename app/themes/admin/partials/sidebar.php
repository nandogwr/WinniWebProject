<?php
    $segment1 = uri_segment(0);
    $segment2 = uri_segment(1);
?>

<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Logo-->
    <div class="aside-logo flex-column-auto pt-10 pt-lg-10" id="kt_aside_logo">
        <a href="<?= base_url('dashboard',true);?>">
            <?php if(isset($setting->icon) && $setting->icon != '' && file_exists('./data/setting/'.$setting->icon)) : ?>
                <div class="background-partisi-contain" style="width : 60px;height : 60px;background-image : url('<?= image_check($setting->icon,'setting');?>')"></div>
            <?php endif;?>
        </a>
    </div>
    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-menu flex-column-fluid pt-0 pb-7 py-lg-10 d-flex justify-content-start align-items-start" id="kt_aside_menu">
        <!--begin::Aside menu-->
        <div id="kt_aside_menu_wrapper" class=" w-100 hover-scroll-y scroll-lg-ms d-flex justify-content-start" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
            <div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-500 menu-arrow-gray-500 fw-semibold fs-6 my-auto" data-kt-menu="true">
                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Dashboard" class="menu-item <?= ($segment1 == 'dashboard') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('dashboard',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-home-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Master Admin" class="menu-item <?= ($segment1 == 'master' && $segment2 == 'admin') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('master/admin',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-user-tie fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Master Member" class="menu-item <?= ($segment1 == 'master' && $segment2 == 'member') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('master/member',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-users fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Master Kategori" class="menu-item <?= ($segment1 == 'master' && $segment2 == 'category') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('master/category',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-tags fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Master Berita" class="menu-item <?= ($segment1 == 'master' && $segment2 == 'news') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('master/news',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-newspaper fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="List Pesan" class="menu-item <?= ($segment1 == 'master' && $segment2 == 'contact') ? 'here show' : '';?>  py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('master/contact',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="fa-solid fa-message fs-2x"></i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                

                <!--begin:Menu item-->
                <div data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Pengaturan" class="menu-item <?= ($segment1 == 'setting') ? 'here show' : '';?> py-2">
                    <!--begin:Menu link-->
                    <a href="<?= base_url('setting',true);?>" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-setting-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                
                
            </div>
        </div>
        <!--end::Aside menu-->
    </div>
    <!--end::Nav-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pb-5 pb-lg-10" id="kt_aside_footer">
        <!--begin::Menu-->
        <div class="d-flex flex-center w-100 scroll-px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Log Out">
            <a type="button" class="btn btn-custom" href="<?= base_url('logout',true);?>" onclick="confirm_alert(this, event, 'Are you sure you want to leave the system?')">
                <i class="ki-duotone ki-entrance-left fs-2x">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Footer-->
</div>
<!--end::Aside-->