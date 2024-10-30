<?php
/*
Plugin Name: isShrinker
Plugin URI: https://b.eax.jp/wp/7279/
Description: isShrinker can specified the maximum file size, you can shrink the JPEG and PNG image while keeping the aspect ratio.
Author: eaxjp
Version: 1.52
Author URI: https://b.eax.jp/
License: GPLv2
Text Domain: isShrinker
Domain Path: /languages
*/

/*------------------------------------------------------------
isShrinker初期化
-------------------------------------------------------------*/
add_action('admin_menu','isShrinker_admin_menu');
add_action( 'plugins_loaded', 'iss_load_textdomain' );
add_action('add_attachment', 'isShrinker_core');
const IS_DOMAIN = 'isShrinker';
function iss_load_textdomain() {

  		load_plugin_textdomain( 'isShrinker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

		}
function isShrinker_admin_menu(){
		add_options_page(
		'isShrinker',
		'isShrinker',
		'administrator',
		'isShrinker_menu',
		'isShrinker_menu_setting'
	);
	}

/*------------------------------------------------------------
画像縮小　設定
-------------------------------------------------------------*/
function isShrinker_menu_setting(){
	//Ver1.0で使っていて使われなくなったオプションを削除
	delete_option( 'is_config_is_ed' );
	delete_option( 'is_config_is_ped' );
	delete_option( 'is_config_is_med' );
	delete_option( 'is_config_is_led' );
    ?>
	<div class="wrap">
	<h1>isShrinker Ver.1.52 </h1>
	<div><?php _e('isShrinker can specified the maximum file size,<br />you can shrink the JPEG and PNG image while keeping the aspect ratio.',IS_DOMAIN) ?><br />
	<a href="https://twitter.com/eaxjp" class="twitter-follow-button" data-show-count="false">Follow @eaxjp</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	[<a href="http://b.eax.jp/wp/7279/">isShrinker page</a>]
	</div>
	<hr>
	<form action="options.php" method="post">
	<?php wp_nonce_field('update-options'); ?>
	<h2><?php _e('Basic Configuration',IS_DOMAIN) ?></h2>
	<table border=0 style="font-size:18px;"><tr>
		<td><?php _e('Shrink JPEG',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_jpeg" value="1" <?php checked(get_option('is_config_jpeg','1'), 1); ?>  /></td><td><?php _e('Enable',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_jpeg" value="0" <?php checked(get_option('is_config_jpeg'), 0); ?>  /></td><td><?php _e('Disable',IS_DOMAIN) ?></td>
	</tr><tr>
		<td><?php _e('Shrink PNG',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_png" value="1" <?php checked(get_option('is_config_png','1'), 1); ?> /></td><td><?php _e('Enable',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_png" value="0" <?php checked(get_option('is_config_png'), 0); ?> /></td><td><?php _e('Disable',IS_DOMAIN) ?></td>
	</tr><tr>
		<td><?php _e('Fix orientation',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_muki" value="1" <?php checked(get_option('is_config_muki','1'), 1); ?> /></td><td><?php _e('Enable',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_muki" value="0" <?php checked(get_option('is_config_muki'), 0); ?> /></td><td><?php _e('Disable',IS_DOMAIN) ?></td>
	</tr><tr>
		<td><?php _e('File size limit',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_fsize" value="1" <?php checked(get_option('is_config_fsize','1'), 1); ?> /></td><td><?php _e('Enable',IS_DOMAIN) ?></td><td><input type="radio" name="is_config_fsize" value="0" <?php checked(get_option('is_config_fsize'), 0); ?> /></td><td><?php _e('Disable',IS_DOMAIN) ?></td>
	</tr></table>     
				<?php
			$wm_file = plugin_dir_path( __FILE__ )."watermark.png";
			if (file_exists($wm_file)) {
			?>
			<div style="margin-top:10px;margin-bottom:10px;color: #1d2327;font-size: 1.3em;"><?php _e('Watermark function is Enabled',IS_DOMAIN) ?></div>
			<?php
				}
			?>
	<table border=0><tr>
		<td><?php _e('Long side of image',IS_DOMAIN) ?></td><td><input type="text" name="is_config_is_lmax" value="<?php echo get_option('is_config_is_lmax', '640'); ?>" style="background-color:#dcd6d9;width:100px;" /></td><td><?php _e('px',IS_DOMAIN) ?></td>
	</tr><tr>
		<td><?php _e('Max file size',IS_DOMAIN) ?></td><td><input type="text" name="is_config_is_fs" value="<?php echo get_option('is_config_is_fs', '50'); ?>" style="background-color:#dcd6d9;width:100px;"/></td><td><?php _e('KB(Enable only if the file size limit is enabled)',IS_DOMAIN) ?></td>
	</tr><tr>
		<td><?php _e('Quality',IS_DOMAIN) ?></td><td><input type="text" name="is_config_is_q" value="<?php echo get_option('is_config_is_q', '100'); ?>" style="background-color:#dcd6d9;width:100px;" /></td><td><?php _e('%(Enable only if the file size limit is disabled)',IS_DOMAIN) ?></td>
			<?php
			$wm_file = plugin_dir_path( __FILE__ )."watermark.png";
			if (file_exists($wm_file)) {
			?>
			</tr><tr>
				<td><?php _e('transparency',IS_DOMAIN) ?></td><td><input type="text" name="is_config_is_wmt" value="<?php echo get_option('is_config_is_wmt', '15'); ?>" style="background-color:#dcd6d9;width:100px;" /></td><td><?php _e('%',IS_DOMAIN) ?></td>
			<?php
				}
			?>
	
	</tr><tr>
		<td><?php _e('Filter',IS_DOMAIN) ?></td>
		<td colspan="2"><select name="is_config_fi" size="1" style="background-color:#dcd6d9;width:150px;">
			<option value="" <?php selected(get_option('is_config_fi',''),'' ); ?> ><?php _e('Disable',IS_DOMAIN) ?></option>
			<option value="mono" <?php selected(get_option('is_config_fi',''),'mono' ); ?> ><?php _e('Monochrome',IS_DOMAIN) ?></option>
		</select></td>
	</tr></table>
	<p style="margin-top:0px;">
	<?php _e('When you do a filter, process of shrink is slow. <br />In addition, error is generated by setting the server, disable the filter in that case.',IS_DOMAIN) ?>
	<br />
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
      <h2><?php _e('Advanced Settings',IS_DOMAIN) ?></h2>
        <div>
        <?php _e('Please reduce the value if you can not be reduced such as insufficient memory.<br />You can not shrink the image size of the campus or more.',IS_DOMAIN) ?>
        </div>
        <table border=0><tr>
            <td><?php _e('Campus width',IS_DOMAIN) ?></td><td><input type="text" name="is_config_is_csize_x" value="<?php echo get_option('is_config_is_csize_x', '2000'); ?>" style="background-color:#dcd6d9;width:100px;" /></td><td><?php _e('px',IS_DOMAIN) ?></td>
        </tr><tr>
            <td><?php _e('Campus hight',IS_DOMAIN) ?></td><td><input type="text" name="is_config_is_csize_y" value="<?php echo get_option('is_config_is_csize_y', '2000'); ?>" style="background-color:#dcd6d9;width:100px;" /></td><td><?php _e('px',IS_DOMAIN) ?></td>             
        </tr></table>
        	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="is_config_is_lmax,is_config_is_fs,is_config_is_csize_x,is_config_is_csize_y,is_config_is_q,is_config_jpeg,is_config_png,is_config_muki,is_config_fsize,is_config_fi,is_config_is_wmt" />
   </form>
</div>
<?php

}
/*------------------------------------------------------------
画像縮小　isShrinkerコア　web版http://b.eax.jp/tools/5418/　より移植
-------------------------------------------------------------*/
function isShrinker_core($post_ID){
	$post = get_post($post_ID);
	$file = get_attached_file($post_ID);
	$path = pathinfo($file);
	//データの取得
	$is_config_jpeg=get_option('is_config_jpeg','1');
	$is_config_png=get_option('is_config_png','1');
	$is_config_muki=get_option('is_config_muki','1');
	$is_config_fsize=get_option('is_config_fsize','1');
	$is_config_fi=get_option('is_config_fi','');
	$is_config_is_q=get_option('is_config_is_q','100');
	$l_max = get_option('is_config_is_lmax','640');
	$maxfs = get_option('is_config_is_fs','50');
	$is_wmt = get_option('is_config_is_wmt','15');
	//
		$fs = $maxfs*1024;	//縮小するファイルサイズ(デフォルト50kb以下)
	//背景キャンパスのサイズ、大きくしすぎるとメモリを消費するので動作しない場合は小さめサイズに
	$max_imgcx = get_option('is_config_is_csize_x','2000');
	$max_imgcy = get_option('is_config_is_csize_y','2000');
	// 背景用画像を生成 ********************************************
	$canvas = imagecreatetruecolor($max_imgcx,$max_imgcy);
	//拡張子でファイル種類を判別、JPGとPNGに対応
	$ext = "";	//拡張子格納用
	$ext = substr(strrchr($file, '.'), 1);
	$ext = strtolower($ext);
		if($ext =="jpg" or $ext =="jpeg"){
//ファイルがJPEGの場合+傾きの修正////////////////////////////////////////////////
		$ext = "jpg";
		if($is_config_jpeg==0){goto pass_proc;}
		//iPhoneで撮った写真の場合、回転情報が入っているの向きが逆になってしまうので
		//http://blog.diginnovation.com/archives/1104/　向きを修正しようとしたが
		//ファイルによって縮小出来なかったりしたのでやめた only jpeg 20140119
				$exif_datas = exif_read_data($file);
				if(isset($exif_datas['Orientation']) and $is_config_muki==1){
							 switch ($exif_datas['Orientation']){
								case(3):
 									$rotation=180;
								break;
								case(8):
									$rotation=90;
								break;
								case(6):
									$rotation=-90;
								break;
								default:
									$rotation=0;
								break;
					}
					$source = imagecreatefromjpeg($file);
					$image = imagerotate($source, $rotation, 0);
					imagedestroy($source);

					$tmp_file=dirname($file)."/rt_tmp.jpg";
					imagejpeg($image,$tmp_file, 50);
					usleep(5000);
					
					// コピー元画像のファイルサイズを取得
					list($image_w, $image_h) = getimagesize($tmp_file);
					unlink($tmp_file);
				}else{
					// ファイル名から、画像インスタンスを生成 JPEG
					$image = imagecreatefromjpeg($file);
					// コピー元画像のファイルサイズを取得
					list($image_w, $image_h) = getimagesize($file);
				}		
				goto pass_1;
		}
	if($ext =="png"){
//ファイルがPNGの場合/////////////////////////////////////////////////////
				$ext = "png";
				if($is_config_png==0){goto pass_proc;}
				// ファイル名から、画像インスタンスを生成 PNG
				$image = ImageCreateFromPNG($file);
				// コピー元画像のファイルサイズを取得
				list($image_w, $image_h) = getimagesize($file);
				goto pass_1;
		}
	goto pass_proc;
	pass_1:
	//縦横比などを計算する ********************************************
	if($image_w>=$image_h){
				//横長
				$width = $l_max;
				$height =($image_h / $image_w) * $l_max;
	}else{
				//縦長
				$height = $l_max;
				$width =($image_w / $image_h) * $l_max;
	}
	$canvas = imagecreatetruecolor($width, $height); //背景を実画像サイズに変更
	$per = 100; //ファイルサイズ指定の為画質を100%にセット
	// 背景画像に、画像をコピーする ********************************************
	imagecopyresampled($canvas,  // 背景画像
					$image,   // コピー元画像
					0,        // 背景画像の x 座標
					0,        // 背景画像の y 座標
					0,        // コピー元の x 座標
					0,        // コピー元の y 座標
					$width,   // 背景画像の幅
					$height,  // 背景画像の高さ
					$image_w, // コピー元画像ファイルの幅
					$image_h  // コピー元画像ファイルの高さ
				);
//フィルター/////////////////////////////////////////////////////
	if($is_config_fi == "mono"){
				ImageFilter($canvas, IMG_FILTER_GRAYSCALE);
				}

//透かしの追加 ////////////////////////////////////////////////////
//プラグインと同一ディレクトリにwatermark.pngがあった場合透かしを画像に投入20160210-V1.4 透明度の設定20200326-V1.5

	$wm_file = plugin_dir_path( __FILE__ )."watermark.png";
	if (file_exists($wm_file)) {
		//透かしの読み込み
		list($wm_w, $wm_h) = getimagesize($wm_file);
		$wm_image = ImageCreateFromPNG($wm_file);
		
		//PNGの透過情報を有効に
		imagealphablending($wm_image, false);
		imagesavealpha($wm_image, true);
		
		//画像に透かしをコピー
		//imagecopymerge_alpha($canvas, $wm_image,$width - $wm_w,$height - $wm_h,0,0,$wm_w,$wm_h,15); from www.php.net/manual/en/function.imagecopymerge.php
		$cut = imagecreatetruecolor($wm_w, $wm_h);
		imagecopy($cut, $canvas, 0, 0, $width - $wm_w, $height - $wm_h, $wm_w, $wm_h);
		imagecopy($cut, $wm_image, 0, 0, 0, 0, $wm_w, $wm_h);
		imagecopymerge($canvas, $cut, $width - $wm_w, $height - $wm_h, 0, 0, $wm_w, $wm_h, $is_wmt);
		
		//透かしを破棄
		imagedestroy($wm_image);
		imagedestroy($cut);
	}

//画像の保存 ////////////////////////////////////////////////////
	if($ext="jpg"){ 
		if($is_config_fsize==1){ 
			// 画像を出力＆調整する for JPEG ********************************************
jpeg_loop:
			imagejpeg($canvas,           // 背景画像
				$file,    // 出力するファイル名（省略すると画面に表示する）
				$per                // 画像精度（この例だと100%で作成）
				);
			if(filesize($file)>$fs and $per>0){	
					//perが0以下でファイルサイズが設定以上の場合
					$per = $per-5;   //画質を５％落とす
					unlink($file);    //ファイルサイズ取得がうまく出来ないので一旦消す
					goto jpeg_loop;     //るーぷ
			}
		}else{
					imagejpeg($canvas,           // 背景画像
					$file,    // 出力するファイル名（省略すると画面に表示する）
					$is_config_is_q                // 画像精度（この例だと100%で作成）
			 );
		}
	}else{
		if($is_config_fsize==1){ 
		// 画像を出力＆調整する for PNG ********************************************
png_loop:
			imagepng($canvas,           // 背景画像
				$file,    // 出力するファイル名（省略すると画面に表示する）
				$per                // 画像精度（この例だと100%で作成）
				 );        
			if(filesize($file)>$fs and $per>0){	
					//perが0以下でファイルサイズが設定以上の場合
					$per = $per-5;   //画質を５％落とす
					unlink($file);    //ファイルサイズ取得がうまく出来ないので一旦消す
					goto png_loop;     //るーぷ
			}
		}else{
					imagepng($canvas,           // 背景画像
        			$file,    // 出力するファイル名（省略すると画面に表示する）
        			$is_config_is_q                // 画像精度（この例だと100%で作成）
        	 );
		}
	}
// メモリを開放する////////////////////////////////////////////////
	imagedestroy($canvas);
	imagedestroy($image);
	// 処理パス用ラベル
pass_proc:
	//ファイル名変更通知？(とりあえず）
	update_attached_file( $post_ID, $file );
	}

//[EOF]//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
