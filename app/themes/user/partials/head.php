<head>
    <base href="../" />
    <title><?= (isset($setting->meta_title)) ? ucwords($setting->meta_title) : ''; ?><?= (isset($title)) ? ' | '.$title : ''; ?></title>
    <meta charset="utf-8" />
    <?php if(isset($setting->meta_description) && $setting->meta_description) : ?>
    <meta name="description" content="<?= $setting->meta_description; ?>" />
    <?php endif;?>
    <?php if(isset($setting->meta_keyword) && $setting->meta_keyword) : ?>
    <meta name="keywords" content="<?= $setting->meta_keyword ?>" />
    <?php endif;?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= (isset($setting->meta_title)) ? ucwords($setting->meta_title) : ''; ?><?= (isset($title)) ? ' | '.$title : ''; ?>" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php if(isset($setting->icon) && $setting->icon) : ?>
    <link rel="shortcut icon" href="<?= image_check($setting->icon,'setting'); ?>" />
    <?php endif;?>

    <link rel="stylesheet" href="<?= assets_url('user') ?>/css/plugins.css">
    <link rel="stylesheet" href="<?= assets_url('user') ?>/css/style.css">
    <link rel="stylesheet" href="<?= assets_url('user') ?>/css/colors/pink.css">
    <link rel="preload" href="<?= assets_url('user') ?>/css/fonts/urbanist.css" as="style" onload="this.rel='stylesheet'">
    <style>
        .background-partisi{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :cover !important;
        }

        .swal2-modal{
            min-width : 400px;
            max-width : 500px;
            width : auto;
        }
    </style>

    <?php
    if (isset($css) && is_array($css)) {
        foreach ($css as $cs) {
            echo $cs;
        }
    } else {
        echo (isset($css) && ($css != "") ? $css : "");
    }
    ?>
    
</head>