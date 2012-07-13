<?php
if (file_exists($keywords) === true){
$this->assign('xoops_meta_description',file_get_contents($keywords));
}
if ( isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on' )
{
	$protocol = 'https://';
}
else
{
	$protocol = 'http://';
}
$url  = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<meta property="og:url" content="<?php echo $url ?>">
