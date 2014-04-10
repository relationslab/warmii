<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WARMii</title>
<?php 
//echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');  
echo $this->Html->script('oauthpopup.js');
echo $this->Html->script('jquery.textchange.js');   ?>
</head>

<body>
<?php 
	echo $this->Html->css('edit');
	//echo $this->Html->script('thumb');
	//require_once("resizeimg.class.php");
	//require_once('class.image.php');
	
	//取得データ読み出し
	$ses_user=$this->Session->read('User');
	$logout=$this->Session->read('logout');
	$ses_wall=$this->Session->read('wall');
	$ses_photos=$this->Session->read('photos');
	$ses_albums=$this->Session->read('albums');
	//$feed_number=$this->Session->read('feed_num');
	//$ses_images=$this->Session->read('images');
	
	//$photos = $ses_images['data'];

	if(!$this->Session->check('User') && empty($ses_user))   { 

		//echo $this->Html->image('facebook.png',array('id'=>'facebook','style'=>'cursor:pointer;float:left;margin-left:550px;'));
		echo $redirect->redirect(array('action' => 'index'));
 	}  else{
		
		echo '<div align="right">';
		
			//ユーザープロフィールを表示
 			echo '<img src="https://graph.facebook.com/'. $ses_user['id'] .'/picture?type=normal" /><div>'.$ses_user['name'].'</div>';	
 		
 			//ログアウトのリンク
			echo '<a href="'.$logout.'">Logout</a><br />';
			
		echo '</div>';
		
		echo '<br />';
		
		//wallの投稿を表示
		echo '<div class="edit" align="center">';
		if(@$ses_wall['data'][$feed_num]['object_id']){
			echo '<ul class="list">';
			//画像の取得
			$targetText = $ses_wall['data'][$feed_num]['picture'];
			$replaceText = str_replace("s.jpg", "n.jpg", $targetText);
			//写真のサムネイル生成
			$tempImage = ImageCreateFromJPEG($replaceText);
			$tempImageWidth = ImageSX($tempImage); //横幅（px）
			$tempImageHeight = ImageSY($tempImage); //縦幅（px）
			
			//画像の表示
			//echo  '<li><img src='.$replaceText.' height="300"></li>';
			if($tempImageWidth>$tempImageHeight){
				echo  '<li><p><img src='.$replaceText.' height="300"></p></li>';
				$textWidth = $tempImageWidth * (300/$tempImageHeight);
				$textHeight = 300;
				
				//記事（メッセージ）の取得
				$feed_message = $ses_wall['data'][$feed_num]['message'];
				$str_len = mb_strlen($ses_wall['data'][$feed_num]['message']);
				$odd_len = 200 - $str_len;
				echo '<br />';
				echo $this->Form->create(false,array('type'=>'post','controller' => 'facebookCps','action'=>'preview/'.$feed_num)); 
				echo $this->Form->input('input_message', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea' , 'label'=>false));
				echo '<span id="textarea-cd">'.$odd_len.'</span><br /><br />';
				echo $this->Form->end("　PDFを出力する　");
			}
			else{
				echo  '<li><table><th><img src='.$replaceText.' width="300"></th><th>　</th>';
				$textWidth = 300;
				$textHeight = $tempImageHeight * (300/$tempImageWidth);
				
				//記事（メッセージ）の取得
				$feed_message = $ses_wall['data'][$feed_num]['message'];
				$str_len = mb_strlen($ses_wall['data'][$feed_num]['message']);
				$odd_len = 200 - $str_len;
				//echo '<br />';
				echo '<th>';
				//echo $this->Form->input('', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea'));
				echo $this->Form->create(false,array('type'=>'post','controller' => 'facebookCps','action'=>'preview/'.$feed_num)); 
				echo $this->Form->input('input_message', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea' , 'label'=>false));
				echo '</th><th><span id="textarea-cd">'.$odd_len.'</span></th></table></li><br />';
				echo '<br />';
				echo $this->Form->end("　PDFを出力する　");
			}
			
			//記事（メッセージ）の取得
			//$feed_message = $ses_wall['data'][$feed_num]['message'];
			//$str_len = strlen($ses_wall['data'][$i]['message']);
			//echo '<li id="message">'.$feed_message.'<br /></li>';
			//echo '<br />';
			//echo $this->Form->input('', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea'));
			//echo '<br />';
			
			echo '</ul>';
		
			//echo phpinfo();
			//デバッグ用表示
			//echo $ses_wall['data'][45]['object_id'];
			//print_r($ses_wall);
			//print_r($ses_photos);
			//print_r($ses_albums);
			//print_r($ses_photos);
		
			//echo $form->submit('出力',array('onclick'=>'return window.confirm('本当によろしいですか？')')).$html->link('詳細','detail/');
			//$this->$form->submit('出力', array('name'=>'submit', 'div'=>false));
			//if(isset($this->params['form']['stay_submit'])){
			//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}
		else{
			echo '<ul class="list">';
			//画像の取得
			//$targetText = $ses_wall['data'][$feed_num]['picture'];
			//$replaceText = str_replace("s.jpg", "n.jpg", $targetText);
			//写真のサムネイル生成
			//$tempImage = ImageCreateFromJPEG($replaceText);
			//$tempImageWidth = ImageSX($tempImage); //横幅（px）
			//$tempImageHeight = ImageSY($tempImage); //縦幅（px）
			
			//画像の表示
			//echo  '<li><img src='.$replaceText.' height="300"></li>';
			//if($tempImageWidth>$tempImageHeight){
				//echo  '<li><p><img src='.$replaceText.' height="300"></p></li>';
			//}
			//else{
				//echo  '<li><p><img src='.$replaceText.' width="300"></p></li>';
			//}
			
			//記事（メッセージ）の取得
			$feed_message = $ses_wall['data'][$feed_num]['message'];
			$str_len = mb_strlen($ses_wall['data'][$feed_num]['message']);
			$odd_len = 200 - $str_len;
			//echo '<li id="message">'.$feed_message.'<br /></li>';
			//echo '<br />';
			//echo $this->Form->input('', array('default' => $feed_message, 'style' => 'width:500px;height:400px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea'));
			echo $this->Form->create(false,array('type'=>'post','controller' => 'facebookCps','action'=>'preview/'.$feed_num)); 
			echo $this->Form->input('input_message', array('default' => $feed_message, 'style' => 'width:500px;height:400px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea' , 'label'=>false));
			echo '<span id="textarea-cd">'.$odd_len.'</span><br />';
			echo $this->Form->end("　PDFを出力する　");
			echo '</ul>';
		}
		
		//echo $this->Html->link( 'PDFを出力する', array('controller' => 'facebookCps', 'action' => 'preview',$feed_num), array('class'=>'link_style'),'ブレピューを作成してもよろしいですか？');
		
		echo '<br />';
		echo $this->Html->link("戻る", "javascript:history.back();"); 
		echo '</div>';
		//}
	}
	?>
	
<script type="text/javascript">
$('#textarea').bind('textchange', function (event, previousText) {
  $('#textarea-cd').html( 200 - parseInt($(this).val().length) );
});
</script>

</body>
</html>