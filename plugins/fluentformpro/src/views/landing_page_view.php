<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Imagetoolbar" content="No"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if($settings['featured_image']): ?>
        <meta property="og:image" content="<?php echo $settings['featured_image']; ?>">
    <?php endif; ?>
    <?php if($settings['description']): ?>
        <meta property="og:description" content="<?php echo strip_tags($settings['description']); ?>">
    <?php endif; ?>
    <?php
        wp_head();
    ?>
    <style type="text/css">
        body.ff_landing_page_body {
            border-top-color: <?php echo $bg_color; ?> !important;
            background-color: <?php echo $bg_color; ?> !important;
        }
        <?php if($settings['background_image']): ?>
        body.ff_landing_page_body {
            background-image: url("<?php echo  $settings['background_image']; ?>") !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            background-position: center center !important;
            background-attachment: fixed;
        }
        body.ff_landing_page_body::after {
            background-color: #6f6f6f;
            content: "";
            display: block;
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            z-index: -1;
            opacity: 0.4;
            bottom: 0;
            right: 0;
        }
        <?php endif; ?>

    </style>
</head>
<body class="ff_landing_page_body ff_landing_page_<?php echo $form_id; ?>">

<div class="ff_landing_wrapper ff_landing_design_<?php echo $settings['design_style']; ?>">
    <div class="ff_landing_form">
        <?php if($has_header): ?>
        <div class="ff_landing_header">
            <?php if($settings['logo']):?>
            <div class="ff_landing-custom-logo">
                <img src="<?php echo $settings['logo']; ?>" alt="Form Logo">
            </div>
            <?php endif; ?>
            <?php if($settings['title']): ?>
            <h1><?php echo $settings['title']; ?></h1>
            <?php endif; ?>
            <?php if($settings['description']): ?>
            <div class="ff_landing_desc">
                <?php echo $settings['description']; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="ff_landing_body">
            <?php echo do_shortcode($landing_content); ?>
        </div>
    </div>
</div>
<?php
wp_footer();
?>
</body>
</html>

