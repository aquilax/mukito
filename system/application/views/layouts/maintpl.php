<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $server_name; if (isset($title)) echo ' &raquo; '.$title;?></title>
  <meta name="KEYWORDS" content="<?php echo $keywords?>" />
  <meta name="description" content="Mu online private server" />
  <link rel="stylesheet" href="<?php echo site_url('/css/'.$css); ?>" type="text/css" media="screen" />
  <link rel="icon" href="<?php echo site_url('/favicon.png'); ?>" />
</head>
<body>
  <div id="top">
    <ul>
      <li><?php echo anchor('http://muonlinehelp.com', lang('Mu Online Help'))?></li>
      <li><?php echo anchor('http://forum.muonlinehelp.com', lang('Forum'))?></li>
      <li><?php echo anchor('http://wiki.muonlinehelp.com', lang('Wiki'))?></li>
      <li><?php echo anchor('http://mukito.muonlinehelp.com', lang('MuKiTo'))?></li>
    </ul>
	</div>
<div id="wrapper">
	<div id="header">
    <div id="htitle"><h1><?php echo anchor('', $server_name)?></h1></div>
	</div>
	<div id="container">
		<div id="side-l">
			<?php $this->load->view('partials/lsidebartpl'); ?>
		</div>
		<div id="content_wrapper">
      <div id="content">
        <?php if (isset($heading)) echo '<h2>'.$heading.'</h2>'; ?>
        <?php echo $content; ?>
      </div>
		</div>
		<div id="side-r">
			<?php $this->load->view('partials/rsidebartpl'); ?>
		</div>
	</div>
	<div id="footer">
		Powered by MuKiTo
	</div>
</div>
</body>
</html>