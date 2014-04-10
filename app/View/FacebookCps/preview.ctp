<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WARMii</title>
<?php 
//echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');  
echo $this->Html->script('oauthpopup');  ?>

</head>

<body>
<?php 
	App::import('Vendor', 'tcpdf/tcpdf');
	echo $this->Html->css('edit');
	
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
		
		///////////////////////////////////////////////////////////////
		//wallの投稿を表示
		echo '<div class="edit" align="center">';
		
		//日付の設定（抽出）
		$yearString = substr($ses_wall['data'][$feed_num]['created_time'],0,4);
		$monthString = substr($ses_wall['data'][$feed_num]['created_time'],5,2);
		$dayString = substr($ses_wall['data'][$feed_num]['created_time'],8,2);
		
		//もし画像付きの場合
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
			//もし画像が横長の場合
			if($tempImageWidth>$tempImageHeight){
				echo  '<li><p><img src='.$replaceText.' height="300"></p></li>';
				$textWidth = $tempImageWidth * (300/$tempImageHeight);
				$textHeight = 300;
				
				//記事（メッセージ）の取得
				//$feed_message = $ses_wall['data'][$feed_num]['message'];
				//$str_len = mb_strlen($ses_wall['data'][$feed_num]['message']);
				//$odd_len = 200 - $str_len;
				echo '<br />';
				//echo $this->Form->create(false,array('type'=>'post','controller' => 'facebookCps','action'=>'preview/'.$feed_num)); 
				//echo $this->Form->input('input_message', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea' , 'label'=>false));
				//echo '<span id="textarea-cd">'.$odd_len.'</span><br /><br />';
				//echo $this->Form->end("　PDFを出力する　");
				echo '<table ><th width='.$textWidth.' align="justify">'.$edit_message.'</th></table><br />';
				
				//縦バージョン
				//PDFのスタイル設定
				$pdf = new TCPDF("P", "mm", "B5", true, "UTF-8" );
				$pdf->setPrintHeader( false );
				$pdf->setPrintFooter( false );
				$pdf->AddPage();
				
				// 自動改ページ機能をOFF 
				$pdf->SetAutoPageBreak(false, 0);
		
				//背景画像を出力
				//$frame_img = $this->webroot;
				$pdf->Image('./img/warmii_frame_P.jpg', 0, 0, 177, 250 , '', '', '', true, 300);
		
				//日付を表示
				//文字フォントの埋め込み
				$font2 = $pdf->addTTFfont('./fonts/ipagp.ttf', 'TrueTypeUnicode', '', 32);
				$pdf->SetFont($font2, '', 22);
				$pdf->SetTextColor(255,102,0);
				$pdf->Text(57, 20, $yearString.'年'.$monthString.'月'.$dayString.'日'); 
		
				//画像を出力
				//$html = '<img src='.$replaceText.' height="400" />';  
				//$pdf->Image($replaceText, 0, 0, 225, 305, '', '', '', false, 300, '', false, false, 0);
				//$pdf->Image($replaceText, 0, 50, 120, '', '', '', '', true, 300, 'C', false, false, 0,false);
				//$changedWidthRate = 100/$tempImageWidth;
				//$changedHeight = $changedWidthRate * $tempImageHeight;
				$pdf->Image($replaceText, 0, 35, '', 80, '', '', '', true, 300,'C');
		
				//文字フォントの埋め込み
				//$font2 = $pdf->addTTFfont('./fonts/ipagp.ttf', 'TrueTypeUnicode', '', 32);
				$pdf->SetFont($font2, '', 20);
		
				//表示するメッセージ
				//$pdf->Text(27, 150, $feed_message); 
				//$pdf->MultiCell(145,0,$feed_message,0,'J',0,0,15,140,true,1);
				$pdf->MultiCell(145,0,$edit_message,0,'J',0,0,15,120,true,1);
		
				//PDFを出力する
				//ob_end_clean();
				//$pdf->Output($ses_wall['data'][$feed_num]['id'].'.pdf', 'I');
				$pdfName = $ses_wall['data'][$feed_num]['id'].'.pdf';
				$fileName = TMP.'pdf'.DS.$pdfName;
				$pdf->Output($fileName, 'F');
				//}
			}
			//画像が縦長の場合
			else{
				echo  '<li><table><th><img src='.$replaceText.' width="300"></th><th>　</th>';
				$textWidth = 300;
				$textHeight = $tempImageHeight * (300/$tempImageWidth);
				
				//記事（メッセージ）の取得
				//$feed_message = $ses_wall['data'][$feed_num]['message'];
				//$str_len = mb_strlen($ses_wall['data'][$feed_num]['message']);
				//$odd_len = 200 - $str_len;
				//echo '<br />';
				//echo '<th>';
				//echo $this->Form->input('', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea'));
				//echo $this->Form->create(false,array('type'=>'post','controller' => 'facebookCps','action'=>'preview/'.$feed_num)); 
				//echo $this->Form->input('input_message', array('default' => $feed_message , 'style' => 'width:'.$textWidth.'px;height:'.$textHeight.'px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea' , 'label'=>false));
				//echo '</th><th><span id="textarea-cd">'.$odd_len.'</span></th></table></li><br />';
				echo '<th width='.$textWidth.' align="justify">'.$edit_message.'</th></table></li>';
				echo '<br />';
				//echo $this->Form->end("　PDFを出力する　");
				
				//横バージョン
				//PDFのスタイル設定
				$pdf = new TCPDF("L", "mm", "B5", true, "UTF-8" );
				$pdf->setPrintHeader( false );
				$pdf->setPrintFooter( false );
				$pdf->AddPage();
				//$bMargin = $pdf->getBreakMargin();
      			 //$auto_page_break = $pdf->AutoPageBreak;

				// 自動改ページ機能をOFF 
				$pdf->SetAutoPageBreak(false, 0);
				
				//背景画像を出力
				//$frame_img = $this->webroot;
				//$pdf->Image('./img/warmii_frame_L.jpg', 0, 0, 350, 200, '', '', '', false, 300, 'C', false, false, 0,false);
				$pdf->setJPEGQuality(100);
				$pdf->Image('./img/warmii_frame_L.jpg', 0, 0, 250,178 , '', '', '', true, 300);
		
				//文字フォントの埋め込み
				$font2 = $pdf->addTTFfont('./fonts/ipagp.ttf', 'TrueTypeUnicode', '', 32);
				$pdf->SetTextColor(255,102,0);
				$pdf->SetFont($font2, '', 22);
				//日付を表示
				//$set_data = 
				$pdf->Text(95, 10, $yearString.'年'.$monthString.'月'.$dayString.'日'); 
				//$pdf->Text(110, 32, $ses_wall['data'][$feed_num]['created_time']); 
		
				//画像を出力
				//$html = '<img src='.$replaceText.' height="400" />';  
				//$pdf->Image($replaceText, 0, 0, 225, 305, '', '', '', false, 300, '', false, false, 0);
				//$pdf->setJPEGQuality(75);
				//$changedHeightRate = 110/$tempImageHeight;
				//$changedWidth = $changedHeightRate * $tempImageWidth;
				$pdf->Image($replaceText, 20, 27, 80, '', '', '', '', true, 300);
		
				//文字フォントの埋め込み
				//$font2 = $pdf->addTTFfont('./fonts/ipagp.ttf', 'TrueTypeUnicode', '', 32);
				$pdf->SetFont($font2, '', 20);
		
				//表示するメッセージ
				//$pdf->Text(150, 40, $feed_message); 
				$pdf->MultiCell(110,0,$edit_message,0,'J',0,0,110,27,true,3,false,true,700);
				
				// ページ設定を元に戻す
       			//$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
       			
				//PDFを出力する
				//ob_end_clean();
				//$pdf->Output('./tmp/pdf/'.$ses_wall['data'][$feed_num]['id'].'.pdf', 'F');
				$pdfName = $ses_wall['data'][$feed_num]['id'].'.pdf';
				$fileName = TMP.'pdf'.DS.$pdfName;
				$pdf->Output($fileName, 'F');
				//}
			}		
			
			echo '</ul>';
		}
		//もし画像が無い場合
		else{
			echo '<ul class="list">';
			//記事（メッセージ）の取得
			//$feed_message = $ses_wall['data'][$feed_num]['message'];
			//$str_len = mb_strlen($ses_wall['data'][$feed_num]['message']);
			//$odd_len = 200 - $str_len;
			//echo '<li id="message">'.$feed_message.'<br /></li>';
			//echo '<br />';
			//echo $this->Form->input('', array('default' => $feed_message, 'style' => 'width:500px;height:400px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea'));
			//echo $this->Form->create(false,array('type'=>'post','controller' => 'facebookCps','action'=>'preview/'.$feed_num)); 
			//echo $this->Form->input('input_message', array('default' => $feed_message, 'style' => 'width:500px;height:400px;font-size:20px' , 'type' => 'textarea' , 'id' => 'textarea' , 'label'=>false));
			//echo '<span id="textarea-cd">'.$odd_len.'</span><br />';
			//echo $this->Form->end("　PDFを出力する　");
			echo '<li><table><th width="500" align="justify">'.$edit_message.'</th></table></li><br />';
			echo '</ul>';
			
			//テキストのみバージョン（縦）
			//記事（メッセージ）の取得
			$feed_message = $ses_wall['data'][$feed_num]['message'];

			$pdf = new TCPDF("P", "mm", "B5", true, "UTF-8" );
			$pdf->setPrintHeader( false );
			$pdf->setPrintFooter( false );
			$pdf->AddPage();
			
			// 自動改ページ機能をOFF 
			$pdf->SetAutoPageBreak(false, 0);

			//背景画像を出力
			//$frame_img = $this->webroot;
			$pdf->Image('./img/warmii_frame_P.jpg', 0, 0, 177, 250 , '', '', '', true, 300);
	
			//日付を表示
			//文字フォントの埋め込み
			$font2 = $pdf->addTTFfont('./fonts/ipagp.ttf', 'TrueTypeUnicode', '', 32);
			$pdf->SetFont($font2, '', 22);
			$pdf->SetTextColor(255,102,0);
			$pdf->Text(57, 20, $yearString.'年'.$monthString.'月'.$dayString.'日'); 
	
			//文字フォントの埋め込み
			//$font2 = $pdf->addTTFfont('./fonts/ipagp.ttf', 'TrueTypeUnicode', '', 32);
			$pdf->SetFont($font2, '', 20);
			//表示するメッセージ
			//$pdf->Text(27, 150, $feed_message); 
			$pdf->MultiCell(145,0,$edit_message,0,'J',0,0,15,35,true,1);
	
			//PDFを出力する
			//ob_end_clean();
			//$pdf->Output($ses_wall['data'][$feed_num]['id'].'.pdf', 'I');
			$pdfName = $ses_wall['data'][$feed_num]['id'].'.pdf';
			$fileName = TMP.'pdf'.DS.$pdfName;
			$pdf->Output($fileName, 'F');
			//}
		}
		
		//echo $this->Html->link( 'PDFを出力する', array('controller' => 'facebookCps', 'action' => 'preview',$feed_num), array('class'=>'link_style'),'ブレピューを作成してもよろしいですか？');
		
		echo '<br />';
		echo $this->Html->link("戻る", array('action' => 'index')); 
		echo '</div>';
		//}
	}
			//画像情報の取得
			/**
			$targetText = $ses_wall['data'][$feed_num]['picture'];
			$replaceText = str_replace("s.jpg", "n.jpg", $targetText);
			$tempImage = ImageCreateFromJPEG($replaceText);
			$tempImageWidth = ImageSX($tempImage); //横幅（px）
			$tempImageHeight = ImageSY($tempImage); //縦幅（px）
		
			//画像の表示
			//echo  '<li><img src='.$replaceText.' height="200"></li>';
		
			//記事（メッセージ）の取得
			$feed_message = $ses_wall['data'][$feed_num]['message'];
			//echo '<li>'.$feed_message.'<br /></li>';
			**/
			echo '</div>';
		//////////////////////////////////////////////////////////
		
	?>

</body>
</html>