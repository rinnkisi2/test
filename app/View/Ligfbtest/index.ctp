<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
<meta charset="utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta property="og:type" content="article">
<meta property="og:locale" content="ja_JP">
<meta property="og:image" content="URL/images/common/ogp.png">
<meta property="og:site_name" content="サイトのタイトル">
<meta property="og:title" content="記事のタイトル">
<meta property="og:description" content="記事の説明">
<meta property="og:url" content="記事のURL">
<title>template</title>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<!--[if lt IE 9]>
<script src="../js/html5shiv-printshiv.js"></script>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?ver=1.8.3"></script>
<link rel="shortcut icon" href="../URL/images/common/favicon.ico">
<link rel="apple-touch-icon" href="../URL/images/common/apple-touch-icon.png">
<?php echo $this->Html->css('Ligfbtest/default'); ?>
<?php echo $this->Html->css('Ligfbtest/common'); ?>
</head>
<body id="form_page">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<noscript>
<div class="noScript">サイトを快適に利用するためには、JavaScriptを有効にしてください。</div>
</noscript>
<header id="header">
	<div id="head_menu">
		<p id="h_logo"><a href="../index.html">
			<img src="rskweb/img/Ligfbtest/common/logo.gng" alt="CakePHP" />
			</a></p>
		<h1 class="catch_phrase">これからの未来をSURVIVEする！グローバルキャリア情報サイト</h1>
		<nav id="nav">
			<ul id="gnavi">
				<li class="gn1"><a href="#">サバイブとは？</a></li>
				<li class="gn2"><img src="../images/common/arrow_down.png" width="5" height="6" alt="↓"><a href="#" id="btnTrg">特徴から探す</a></li>
			</ul>
		</nav>
	</div>
	<div id="searchBox">
		<section>
			<h2 class="s_category01">特徴から探す</h2>
			<p><a href="#">日系企業で働きたい</a> / <a href="#">外資系企業で働きたい</a> / <a href="#">国際色豊かな環境で働きたい</a> / <a href="#">大企業で働きたい</a> / <a href="#">中小企業で働きたい</a> / <a href="#">海外で起業したい</a> / <a href="#">海外でNPO活動がしたい</a> / <a href="#">海外で研究したい</a> / <a href="#">英語以外の語学力を活かす</a> / <a href="#">学歴(MBA/PhD)を活かす</a> / </p>
		</section>
		<section>
			<h2 class="s_category02">エリアから記事を探す</h2>
			<p><a href="#">北米</a> / <a href="#">欧州</a> / <a href="#">東南アジア</a> / <a href="#">東アジア</a> / <a href="#">中近東</a> / <a href="#">オセアニア</a> / <a href="#">中南米</a></p>
		</section>
		<section>
			<h2 class="s_category03">業種から記事を探す</h2>
			<p><a href="#">営業/事務/企画、サービス</a> / <a href="#">販売、コンサルタント</a> / <a href="#">金融、ITエンジニア、電気/電子技術者</a></p>
		</section>
		<p class="close"><a href="#">閉じる</a></p>
	</div>
</header>
<!-- / #header -->

<div id="wrapper">
  <nav id="brdNav">
  	<ul class="clearfix">
    	<li><a href="../index.html">トップ</a></li>
      <li>&gt;</li>
      <li>エントリーフォーム</li>
    </ul>
  </nav>
  
	<article id="main" class="clearfix">
		<h1 class="pageTtl">エントリーフォーム</h1>
		<div id="stepNav"><img src="../images/common/img_step1.png" width="482" height="65" alt="STEP1.Facebook認証 STEP2.エントリー登録 FINISH.完了"></div>
		<section id="formArea">
			<h1>基本情報登録</h1>
			<p>基本情報をご入力ください。<b>※</b>がついているものは必須項目です。</p>
			<?php echo $this->Form->create('Entrystudent', array('type' => 'post','action' => '../ligfbtest/check')); ?>
			<table>
				<tr>
					<th><span>氏名<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('last_name', array('type' => 'text','placeholder' => "山田","name" => "last_name", "value" => $myFbData['last_name'],"label" => "", "class" => "formInpType1")); ?>
						<?php echo $this->Form->input('first_name', array('type' => 'text','placeholder' => "太郎","name" => "first_name", "value" => $myFbData['first_name'],"label" => "", "class" => "formInpType1")); ?>
					</td>
				</tr>
				<tr>
					<th><span>ふりがな<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('last_kana', array('type' => 'text','placeholder' => "やまだ","name" => "last_kana", "value" => $hurigana_sei,"label" => "", "class" => "formInpType1")); ?>
					</td>
				</tr>
				<tr>
					<th><span>性別<b>※</b></span></th>
					<td class="themeSex">
						<label for="themeSex1" class="formLblType1">
							<input type="radio" class="formRdoType1" id="themeSex1" name="themeSexMale" <?php echo $male; ?>>男性
						</label>
						<label for="themeSex2" class="formLblType1">
							<input type="radio" class="formRdoType1" id="themeSex2" name="themeSexFemale" <?php echo $female; ?>>女性
						</label>
					</td>
				</tr>
				<tr>
					<th><span>大学（院）卒業・修了見込年度<b>※</b></span></th>
					<td>
						<select class="formSlcType1" name="graduation_year">
							<option value="2013" selected>2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
						</select><span>年</span>
						<select class="formSlcType2" name="graduation_month">
							<option value="1" selected>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select><span>月</span>
					</td>
				</tr>
				<tr>
					<th><span>大学名 及び 大学院名<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('college', array('type' => 'text','placeholder' => "○○大学","name" => "college", "value" => $mySchool, "class" => "formInpType3","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th><span>学部名<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('faculty', array('type' => 'text','placeholder' => "○○学部","name" => "faculty", "value" => $myFaculty, "class" => "formInpType3","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th><span>留学経験<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('abroad', array('type' => 'text','placeholder' => "アメリカに一年間留学経験があります。","name" => "abroad", "value" => null, "class" => "formInpType3","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th class="vTop"><span>現住所<b>※</b></span></th>
					<td>
						〒<?php echo $this->Form->input('zipcode', array('type' => 'text','placeholder' => "111-1111(半角数字)","name" => "zipcode", "value" => null, "class" => "formInpType4 ml05","label" => "")); ?>
						<?php echo $this->Form->input('address', array('type' => 'text','placeholder' => "東京都○○区△△－□□－××","name" => "address", "value" => $myFbData['location']['name'], "class" => "formInpType5 mt20","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th><span>生年月日<b>※</b></span></th>
					<td>
						<select class="formSlcType1" name="birth_year">
							<option value="<?php echo $birthday_y; ?>" selected><?php echo $birthday_y; ?></option>
						</select><span>年</span>
						<select class="formSlcType2" name="birth_month">
							<option value="<?php echo $birthday_m; ?>" selected><?php echo $birthday_m; ?></option>
						</select><span>月</span>
						<select class="formSlcType2" name="birth_day">
							<option value="<?php echo $birthday_d; ?>" selected><?php echo $birthday_d; ?></option>
						</select><span>日</span>
					</td>
				</tr>
				<tr>
					<th><span>電話番号<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('tel', array('type' => 'text','placeholder' => "000-1234-5678(半角数字)","name" => "tel", "value" => null, "class" => "formInpType1","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th><span>メールアドレス<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('mail', array('type' => 'text','placeholder' => "sample@gmail.com(半角英数)","name" => "mail", "value" => $myFbData['email'], "class" => "formInpType5","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th><span>メールアドレス（確認）<b>※</b></span></th>
					<td>
						<?php echo $this->Form->input('check_mail', array('type' => 'text','placeholder' => "sample@gmail.com(半角英数)","name" => "check_mail", "value" => null, "class" => "formInpType5","label" => "")); ?>
					</td>
				</tr>
				<tr>
					<th class="vTop"><span>働きたい地域</span></th>
					<td id="themeWp">
						<ul>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp1" name="area_ne">
								<label for="themeWp1" class="formLblType2">北米</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp2" name="area_eu">
								<label for="themeWp2" class="formLblType2">欧米</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp3" name="area_sa">
								<label for="themeWp3" class="formLblType2">東南アジア</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp4" name="area_ea">
								<label for="themeWp4" class="formLblType2">東アジア</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp5" name="area_nme">
								<label for="themeWp5" class="formLblType2">中近東</label>
							</li>
						</ul>
						<ul>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp6" name="area_o">
								<label for="themeWp6" class="formLblType2">オセアニア</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWp7" name="area_nsa">
								<label for="themeWp7" class="formLblType2">中南米</label>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th class="vTop"><span>希望する働き方</span></th>
					<td id="themeWway">
						<ul>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWway1" name="work_start">
								<label for="themeWway1" class="formLblType3">海外で起業したい</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWway2" name="work_npo">
								<label for="themeWway2" class="formLblType3">海外でNPO活動がしたい</label>
							</li>
						</ul>
						<ul class="mt15">
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWway3" name="work_study">
								<label for="themeWway3" class="formLblType3">海外で研究したい</label>
							</li>
							<li>
								<input type="checkbox" class="formChkType2"  id="themeWway4" name="work_lang">
								<label for="themeWway4" class="formLblType3">英語以外の語学力を活かしたい</label>
							</li>
						</ul>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->submit("この情報でエントリーする",array("type"=>"submit" ,"value" => "ほげ","class" => "btn_form1")); ?>
		</section>
	</article>
	<!-- / #main -->
	
	<div id="footer_social">
		<section class="clearfix">
			<h1>SURVIVE! の更新情報は メール、Twitter、RSS、Facebookページ で受信できます。</h1>
			<div class="tw_follow"><a href="https://twitter.com/survive" class="twitter-follow-button" data-show-count="false">Follow @survive</a> 
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
			<div class="magazine">
				<p><a href="#">メールマガジンの登録</a></p>
			</div>
			<div class="rss">
				<p><a href="#">RSSフィードの登録</a></p>
			</div>
      <h2><img src="../images/common/ttl_fb.png" width="118" height="20" alt="Facebook"></h2>
			<div class="fb-like-box" data-href="http://www.facebook.com/platform" data-width="935" data-height="185" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
		</section>
		<div class="bannerBox">
			<ul>
				<li><a href="#" class="op"><img src="../images/common/banner01.png" width="143" height="59" alt="banner"></a></li>
				<li><a href="#" class="op"><img src="../images/common/banner02.png" width="143" height="59" alt="banner"></a></li>
				<li><a href="#" class="op"><img src="../images/common/banner03.png" width="143" height="59" alt="banner"></a></li>
				<li><a href="#" class="op"><img src="../images/common/banner04.png" width="143" height="59" alt="banner"></a></li>
				<li><a href="#" class="op"><img src="../images/common/banner05.png" width="143" height="59" alt="banner"></a></li>
				<li><a href="#" class="op"><img src="../images/common/banner06.png" width="143" height="59" alt="banner"></a></li>
			</ul>
		</div>
	</div>
  <p id="btn_pt"><a href="#wrapper" class="scr"><img src="../images/common/btn_pt.png" width="58" height="59" alt="PAGE TOP"></a></p>
</div>
<footer id="footer">
	<div class="fBox">
		<p class="f_logo"><a href="../index.html"><img src="../images/common/logo_small.jpg" width="146" height="45" alt="logo"></a></p>
		<nav class="fListBox clearfix">
			<ul class="fList1">
				<li><a href="#">サバイブとは？</a></li>
				<li><a href="#">採用担当者様へ</a></li>
				<li><a href="#">お問い合わせ</a></li>
			</ul>
			<ul class="fList2">
			    <li class="b_none"><img src="../images/common/icon_border.png" width="1" height="11" alt="border"></li>
				<li><a href="#">サイトマップ</a></li>
				<li><a href="#">個人情報の取り扱いについて</a></li>
				<li><a href="#">ご利用規約</a></li>
				<li><a href="#">運営会社について</a></li>
			</ul>
		</nav>
		<ul class="box_snsbtn clearfix">
			<li class="fb">
				<div class="fb_box"><div class="fb-like" data-href="http://liginc.co.jp/" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div></div>
			</li>
			<li class="tw"><div class="tw_box"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-size="">ツイート</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div></li>
		</ul>
		<small>Copyright©SURVIVE</small>
	</div>
</footer>
<!-- / #footer --> 
<!-- / #wrapper --> 
<?php echo $this->Html->script('Ligfbtest/iecheck'); ?>
<?php echo $this->Html->script('Ligfbtest/script'); ?>
<?php echo $this->Html->script('Ligfbtest/ah-placeholder'); ?>
<script>
$(function(){
	$(".themeSex input").change(function(){
		if($(this).is(":checked")){
			$('.themeSex').find(".checkedLabel:not(:checked)").removeClass("checkedLabel");
			$(this).parent("label").addClass("checkedLabel");
			}
	});
	$("#themeWp input").change(function(){
		if($(this).is(":checked")){
			$(this).next("label").addClass("checkedLabel");
			}else{
				$(this).next("label").removeClass("checkedLabel");
			}
		});
	$("#themeWway input").change(function(){
		if($(this).is(":checked")){
			$(this).next("label").addClass("checkedLabel");
			}else{
				$(this).next("label").removeClass("checkedLabel");
			}
		});
});
</script>
</body>
</html>