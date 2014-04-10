<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WARMii</title>
<?php 
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');  
echo $this->Html->script('oauthpopup');  ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#facebook').click(function(e){
        $.oauthpopup({
            path: 'facebook_cps/login',
			width:600,
			height:300,
            callback: function(){
                window.location.reload();
            }
        });
		e.preventDefault();
    });
});


</script>
</head>

<body>
<?php 
	echo $this->Html->css('thumb');
	//echo $this->Html->script('thumb');
	//require_once("resizeimg.class.php");
	//require_once('class.image.php');
	
	//取得データ読み出し
	$ses_user=$this->Session->read('User');
	$logout=$this->Session->read('logout');
	$ses_wall=$this->Session->read('wall');
	$ses_photos=$this->Session->read('photos');
	$ses_albums=$this->Session->read('albums');
	//$ses_images=$this->Session->read('images');
	
	//$photos = $ses_images['data'];

	if(!$this->Session->check('User') && empty($ses_user))   { 

		//echo $this->Html->image('facebook.png',array('id'=>'facebook','style'=>'cursor:pointer;float:left;margin-left:550px;'));
		echo $this->Html->image('facebook.png',array('id'=>'facebook','style'=>'cursor:pointer;float:left;'));
 	}  else{
		
		echo '<div align="right">';
		
			//ユーザープロフィールを表示
 			echo '<img src="https://graph.facebook.com/'. $ses_user['id'] .'/picture?type=normal" /><div>'.$ses_user['name'].'</div>';	
 		
 			//ログアウトのリンク
			echo '<a href="'.$logout.'">Logout</a><br />';
			
		echo '</div>';
		
		//wallの投稿を表示
		echo '<div class="grid" align="center">';
		//echo '<ul class="list">';
		for($i=0;$i<100;$i++){
			if(@$ses_wall['data'][$i]['message']){
				//wallの写真を表示
				if(@$ses_wall['data'][$i]['object_id']){
					echo '<ul class="list">';
					//日付を表示
					//echo "投稿日時：".$ses_wall['data'][$i]['created_time'].'<br />';
					$yearString = substr($ses_wall['data'][$i]['created_time'],0,4);
					$monthString = substr($ses_wall['data'][$i]['created_time'],5,2);
					$dayString = substr($ses_wall['data'][$i]['created_time'],8,2);
					//echo $this->Html->link( '投稿日時：'.$ses_wall['data'][$i]['created_time'], array('controller' => 'facebookCps', 'action' => 'edit',$i), array('class'=>'link_style'));
					echo $this->Html->link( $yearString.'年'.$monthString.'月'.$dayString.'日の記事', array('controller' => 'facebookCps', 'action' => 'edit',$i), array('class'=>'link_style'));
					echo '<br />';
					
					//写真の参照URLを写真サイズの大きい物へ置換
					$targetText = $ses_wall['data'][$i]['picture'];
					$replaceText = str_replace("s.jpg", "n.jpg", $targetText);
					
					//写真のサムネイル生成
					$tempImage = ImageCreateFromJPEG($replaceText);
					$tempImageWidth = ImageSX($tempImage); //横幅（px）
					$tempImageHeight = ImageSY($tempImage); //縦幅（px）
					//縦横合わせの成形（やや重い）
					if($tempImageWidth>$tempImageHeight){
						echo  '<li><p class="trimming"><img src='.$replaceText.' height="200"></p></li>';
					}
					else{
						echo  '<li><p class="trimming"><img src='.$replaceText.' width="200"></p></li>';
					}

					//wallのメッセージを表示
					mb_language('Japanese');
					mb_internal_encoding('UTF-8');
					$feed_message = $ses_wall['data'][$i]['message'];
					$str_len = strlen($ses_wall['data'][$i]['message']);
					if($str_len>399){
						$cropped_message = substr($feed_message,0,399);
						$mb_str_len = mb_strlen($cropped_message);
						$fixed_message = mb_substr($feed_message,0,$mb_str_len-1);
						echo '<li id="message">'.$fixed_message."…(省略)".'<br /></li>';
					}
					else {
						//echo '<li id="message">'.$ses_wall['data'][$i]['message'].'<br /></li>';
						echo '<li id="message">'.$feed_message.'<br /></li>';
					}
					//日付を表示
					//echo "投稿日時：".$ses_wall['data'][$i]['created_time'].'<br />';
					//$edit_array = array($ses_wall['data'][$i]['created_time'], $replaceText, $feed_message);
					//echo '<a href="/cake/postto/facebook_cps/edit/{'$edit_array'} "> "投稿日時：'.$ses_wall['data'][$i]['created_time'].'"</a><br />';
					//echo $this->Html->link( '投稿日時：'.$ses_wall['data'][$i]['created_time'], array('controller' => 'facebookCps', 'action' => 'edit',$edit_array), array('class'=>'link_style'), "本当にクリックしていいの？");
					
					echo '<br />';
					echo '</ul>';
				}
				else{
					echo '<ul class="list">';
					//日付を表示
					//echo "投稿日時：".$ses_wall['data'][$i]['created_time'].'<br />';
					$yearString = substr($ses_wall['data'][$i]['created_time'],0,4);
					$monthString = substr($ses_wall['data'][$i]['created_time'],5,2);
					$dayString = substr($ses_wall['data'][$i]['created_time'],8,2);
					//echo $this->Html->link( '投稿日時：'.$ses_wall['data'][$i]['created_time'], array('controller' => 'facebookCps', 'action' => 'edit',$i), array('class'=>'link_style'));
					echo $this->Html->link( $yearString.'年'.$monthString.'月'.$dayString.'日の記事', array('controller' => 'facebookCps', 'action' => 'edit',$i), array('class'=>'link_style'));
					echo '<br />';
					
					//写真の参照URLを写真サイズの大きい物へ置換
					//$targetText = $ses_wall['data'][$i]['picture'];
					//$replaceText = str_replace("s.jpg", "n.jpg", $targetText);
					
					//写真のサムネイル生成
					//$tempImage = ImageCreateFromJPEG($replaceText);
					//$tempImageWidth = ImageSX($tempImage); //横幅（px）
					//$tempImageHeight = ImageSY($tempImage); //縦幅（px）
					//縦横合わせの成形（やや重い）
					//if($tempImageWidth>$tempImageHeight){
						//echo  '<li><p class="trimming"><img src='.$replaceText.' height="200"></p></li>';
					//}
					//else{
						//echo  '<li><p class="trimming"><img src='.$replaceText.' width="200"></p></li>';
					//}

					//wallのメッセージを表示
					mb_language('Japanese');
					mb_internal_encoding('UTF-8');
					$feed_message = $ses_wall['data'][$i]['message'];
					$str_len = strlen($ses_wall['data'][$i]['message']);
					if($str_len>399){
						$cropped_message = substr($feed_message,0,399);
						$mb_str_len = mb_strlen($cropped_message);
						$fixed_message = mb_substr($feed_message,0,$mb_str_len-1);
						echo '<li id="message">'.$fixed_message."…(省略)".'<br /></li>';
					}
					else {
						//echo '<li id="message">'.$ses_wall['data'][$i]['message'].'<br /></li>';
						echo '<li id="message">'.$feed_message.'<br /></li>';
					}
					//日付を表示
					//echo "投稿日時：".$ses_wall['data'][$i]['created_time'].'<br />';
					//$edit_array = array($ses_wall['data'][$i]['created_time'], $replaceText, $feed_message);
					//echo '<a href="/cake/postto/facebook_cps/edit/{'$edit_array'} "> "投稿日時：'.$ses_wall['data'][$i]['created_time'].'"</a><br />';
					//echo $this->Html->link( '投稿日時：'.$ses_wall['data'][$i]['created_time'], array('controller' => 'facebookCps', 'action' => 'edit',$edit_array), array('class'=>'link_style'), "本当にクリックしていいの？");
					
					echo '<br />';
					echo '</ul>';
				}
			}
		}
		//echo '</ul>';
		echo '</div>';
		
		//echo phpinfo();
		//デバッグ用表示
		//echo $ses_wall['data'][45]['object_id'];
		//print_r($ses_wall);
		//print_r($ses_photos);
		//print_r($ses_albums);
		//print_r($ses_photos);
			
	}
	?>

</body>
</html>