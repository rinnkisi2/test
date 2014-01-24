<!doctype html> <!-- layoutfile -->
<html lang="ja">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>	
	</title>
	<link rel="shortcut icon" href="/app/maker/favicon.ico" />
	<?php echo $this->Html->css('bootstrap'); ?>
	<?php echo $this->Html->css('jquery.toastmessage'); ?>
	<?php echo $this->Html->css('autostyle'); //メイン共通CSS ?>
	<?php echo $this->Html->css('sagscroller'); //縦スクロール: group_top ?>
	<?php echo $this->Html->script('jquery'); ?>
	<?php echo $this->Html->script('bootstrap'); ?>
	<?php echo $this->Html->script('jquery.toastmessage'); ?>
	<?php echo $this->Html->script('autoscript'); //メイン共通JS ?>
	<?php echo $this->Html->script('sagscroller'); //縦スクロール: group_top ?>
</head>
<body>
	<div id="wrapper">
		<div class="navbar navbar-fixed-top navbar-inverse">
			<div class="navbar-inner">
				<div class="container">
					<?php $rooturl = "http://".$_SERVER["HTTP_HOST"].$this->webroot.'auto/'; ?>
					
					<a class="brand" href="<?php echo $rooturl; ?>group_top/37">KENTEI MAKER v2</a>
					<?php if(!empty($user)): //ログイン後ならば ?>
					<ul class="nav">
						<!-- <li >
							<a href="<?php echo $rooturl; ?>group_add">グループ作成</a>
						</li> -->
						<?php $group = $this->Session->read('group'); ?>
						<?php if(!empty($group) && !empty($user)): ?>
							<li><a href="<?php echo $rooturl; ?>draft_create">
								<i class="icon-pencil icon-white"></i>下書き作問</a>
							</li>
							<li><a href="<?php echo $rooturl; ?>user_note">
								<i class="icon-th-list icon-white"></i>下書き</a>
							</li>
							<li>
								<a href="<?php echo $rooturl; ?>user_made">
								<i class="icon-flag icon-white"></i>提出済</a>
							</li>
							<!-- その他 -->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									その他機能<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $rooturl; ?>discuss">ディスカッション</a></li>
									<li><a href="<?php echo $rooturl; ?>search">過去問検索</a></li>
									<li><a href="<?php echo $rooturl; ?>index">グループ切り替え</a></li>
								</ul>
							</li>
							
							<!-- メンバーリスト -->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									メンバー<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<?php foreach ($group['AutoGur'] as $key => $value): ?>
										<li>
											<a href="<?php echo $rooturl; ?>user_info/<?php echo $value['user_id']; ?>" id=<?php echo $value['user_id']; ?>>
											<?php echo $value['AutoUser']['name']; ?>
											</a>
										</li>
									<?php endforeach; ?>	
								</ul>
							</li>
							<!-- 試験一覧 -->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									試験一覧<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<?php foreach ($group['AutoExam'] as $key => $value): ?>
										<li>
										<?php echo $this->Html->link($value['name'],array(
											'action' => 
											'exam_top/'.$value['id'])); ?>
										</li>
									<?php endforeach; ?>	
								</ul>
							</li>
						<?php endif; ?>
					</ul>
					<a class="brand" href="<?php echo $rooturl; ?>logout" >ログアウト</a>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<div id="main">
			<!-- 中身 -->
			<div id="share_contents">
		 		<?php echo $this->fetch('content'); ?>
		 	</div>
		</div>
	</div>

	
</body>
</html>