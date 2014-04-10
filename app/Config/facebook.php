<?php
/**

  * Get an api_key and secret from facebook and fill in this content.

  * save the file to app/config/facebook.php

  */

if($_SERVER['HTTP_HOST']=='local.warmii.com')
{
	$config = array(
		'Facebook' => array(
		  	'appId' => '563085710402686',
		    'secret' => 'aaa4d806105998835337e085bc10dc42',
		)
	);

}
elseif($_SERVER['HTTP_HOST']=='warmii.ynakamura.net')
{
	$config = array(
	  'Facebook' => array(
	  	'appId' => '312938762175121',//test:563085710402686
	    'secret' => 'a103584e25b7a519467e9f3dc8055640',//test:aaa4d806105998835337e085bc10dc42
  )
);
}
?>