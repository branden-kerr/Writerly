<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Imagetoolbar" content="No"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if(!empty($data['result']) && !empty($data['result']['redirectUrl'])): ?>
    <!-- Fallback for jquery error for redirect -->
    <meta http-equiv="refresh" content="5;url=<?php echo $data['result']['redirectUrl']; ?>" />
    <?php endif; ?>

    <?php
        wp_head();
    ?>
</head>
<body class="ff_frameless_page_body ff_frameless_page_<?php echo $form->id; ?> ff_frameless_status_<?php echo $status; ?>">

<div class="ff_frameless_wrapper">
    <div class="ff_frameless_item">
        <div class="ff_frameless_header">
            <?php echo $title; ?>
        </div>
        <div class="ff_frameless_body">
            <?php echo $message; ?>
        </div>
    </div>
</div>
<?php
wp_footer();
?>

<?php if(!empty($data['result']) && !empty($data['result']['redirectUrl'])): ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        window.location.href = "<?php echo $data['result']['redirectUrl']; ?>";
    });
</script>
<?php endif; ?>

</body>
</html>

