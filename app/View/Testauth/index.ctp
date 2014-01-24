<p>ようこそ！<?php echo h($userinfo['username']);?>さん</p>
<p>あなたの登録メールアドレスは<?php echo h($userinfo['email']);?>です。</p>
<h2>ここはIndexページです</h2>
<ul>
<li><?php echo $this->Html->link('ログアウト','logout',array(),'ログアウトしてもいいですか？');?></li>
<li><?php echo $this->Html->link('新規ユーザ作成','add',array());?></li>
</ul>