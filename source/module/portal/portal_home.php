<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require DISCUZ_ROOT.'./source/function/cache/cache_lesson.php';

$size = array(
	'medium' => array('height' => 576, 'width' =>1024),
	'small' => array('height' => 288, 'width' => 512),
	'tiny' => array('height' => 144, 'width' => 256),
);


$ac = $_GET['ac'] ? $_GET['ac'] : 'basic';
/*
*@insert , update
*/
if( isset( $_POST['update_director'])) {
	$c_id = trim( $_POST['id']);
	$c_key = trim( $_POST['c_key']);
	$c_value = trim( $_POST['c_value']);
	C::t('basic_config')->update_director( array(
		'id' => $c_id,
		'c_key' => $c_key,
		'c_value' => $c_value,
	));
	$director = C::t('basic_config')->get_director();
	savecache('director' , $director);
}else if( isset( $_POST['update_homephoto'])) {
	$ac = 'bigphoto';

	if( isset( $_POST['id'])){
		$data = C::t('basic_config')->get_bigphoto_by_id( $_POST['id']);
	}

	if( isset( $_FILES['c_key'])){
		if( $_FILES['c_key']['error'] == 0 && $_FILES['c_key']['size']){
			if( isset( $data['c_key']))
				unlink( DISCUZ_ROOT . 'uploads/home/' .$data['c_key']);

			$fname = mt_rand(999,9999).'.'.array_pop( explode('.', $_FILES['c_key']['name']));
			move_uploaded_file( $_FILES['c_key']['tmp_name'], DISCUZ_ROOT . 'uploads/home/'.$fname);
		}
		
	}

	if( !$fname)
		$fname = $data['c_key'];

	if( isset( $data)){

		C::t('basic_config')->update_bigphoto( array(
			'id'    	=> $_POST['id'],
			'config' 	=> $_POST['config'],
			'c_value' 	=> $_POST['c_value'],
			'c_key'		=> $fname,
		));

	}else{

		$id = C::t('basic_config')->insert_bigphoto( array(
		'config' 	=> trim( $_POST['config']),
		'c_value' 	=> trim( $_POST['c_value']),
		'c_key'		=> $fname,
		'type'		=> 'bigphoto',
		));	
	}
	loadcache('bigphoto');
}else if( isset( $_POST['add_hotcourse'])) {
	C::t('basic_config')->add_hotcourse( array('config' => intval( $_POST['cid']) , 'type' => 'hotcourse'));
	$ac = 'direct';
}else if( isset( $_POST['add_footer'])) {
	print_r( $_POST);
	exit;
}else if( isset( $_GET['generate'])) {
	$path = trim( $_GET['path']);
	$g_size = trim( $_GET['size']);
	@chmod( DISCUZ_ROOT.$path.'/', 0777);

	$dir = opendir( DISCUZ_ROOT.$path.'/');

	while( $file = readdir( $dir)){
		if( $file == '.' || $file == '..' || $file == 'index.html')
			continue;
		sleep(1);
		img_create_small( 	DISCUZ_ROOT.$path.'/'.$file, $size[$g_size]['width'], $size[ $g_size]['height'], DISCUZ_ROOT.$path.'/'.$g_size.'/'.$file);
	}

	$ac = 'thumb';
	echo $ac;
}

/*
*@delete
*/

if( isset( $_GET['delete_bigphoto'])) { 
	$id = intval( $_GET['delete_bigphoto']);

	$photo = C::t('basic_config')->get_bigphoto_by_id( $id);
	if( $photo['c_key'])
		unlink( DISCUZ_ROOT . 'uploads/home/'.$photo['c_key']);
	C::t('basic_config')->delete_bigphoto( $id);
	loadcache('bigphoto');
}

/*
*@update
*/
if( $ac === 'bigphoto' && isset( $_GET['reload'])) {
	$bp = C::t('basic_config')->get_bigphoto();
	savecache('bigphoto' , $bp);
}

if( isset( $_GET['edit_bigphoto'])) {
	$id = intval( $_GET['edit_bigphoto']);
	$bp = C::t('basic_config')->get_bigphoto_by_id( $id);
}

if( isset( $_GET['cache'])) {
	if( 'home' === trim( $_GET['cache'])) {
		cache_hot_course();
		cache_free_pages(8);
		cache_course_info();
		//bigphoto cache
		$bigphoto = C::t('basic_config')->get_bigphoto();
		savecache('bigphoto' , $bigphoto);
		//update 导航cache
		$director = C::t('basic_config')->get_director();
		savecache('director' , $director);
		//热门课程
		$hot_course = C::t('basic_config')->get_hotcourse();
		savecache('hot_course' , $hot_course);
	}
}

/*
*@view
*/
if( $ac === 'basic')
	$director = C::t('basic_config')->get_director();
elseif( $ac === 'bigphoto')
	$bigphoto = C::t('basic_config')->get_bigphoto();
elseif( $ac === 'direct'){
	if( isset( $_GET['remove'])) {
		$id = intval( $_GET['remove']);
		C::t('basic_config')->rm_hotcourse( $id);
	}

	$hotcourse = C::t('b_course')->get_all_course();
	$selected = C::t('basic_config')->get_hotcourse();
}
	



require template('portal/home/'.$ac);



function img_create_small($big_img,$width,$height,$small_img){
    $imgage = getimagesize($big_img);
    switch ($imgage[2]){
    	case 1: $im=imagecreatefromgif($big_img);break;
    	case 2: $im=imagecreatefromjpeg($big_img);break;
    	case 3: $im=imagecreatefrompng($big_img);break;
    }

    imagesavealpha($im,true);
    $src_W=imagesx($im);
    $src_H=imagesy($im);

    $tn=imagecreatetruecolor($width,$height);

    imagealphablending($tn,false);
    imagesavealpha($tn,true);

    imagecopyresized($tn,$im,0,0,0,0,$width,$height,$src_W,$src_H);

    imagepng($tn,$small_img);
}
