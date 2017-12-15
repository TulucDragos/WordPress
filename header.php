<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coming Soon</title>
<?php  wp_head(); ?>
</head>
<?php
 $backgroundimage = get_field('background_image');
?>
<body style="background-image: url(<?php echo $backgroundimage ?>)">