<?php
	
	App::import('Vendor', 'tcpdf/tcpdf');
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//デフォルトのヘッダーを削除
	$pdf->setPrintHeader(false);
	//デフォルトのフッターを削除
	$pdf->setPrintFooter(false);
	//1ページ目を準備
	$pdf->AddPage();
	// フォントを指定 ( 小塚ゴシックPro M を指定 )
	// 日本語を使う場合は、日本語に対応しているフォントを使う
	$pdf->SetFont('kozgopromedium', '', 10);
	//見出し 
	$pdf->writeHTML('<h1>もりけん1級</h1><br />', false, false, false, false, 'C');

	foreach ($quiz as $key => $value){
		//問題文
		$pdf->writeHTML("問".($key+1).": ".$value['AutoQuiz']['sentence'].'<br />',
				false, false, false, false, 'L');
		
		//選択肢
		$pdf->writeHTML(
			$value['AutoQuiz']['option1'].' '.
			$value['AutoQuiz']['option2'].' '.
			$value['AutoQuiz']['option3'].' '.
			'<font color="red">'.
			$value['AutoQuiz']['right_answer'].'</font><br /><br />',
			false, false, false, false, 'L');
	}

	$pdf->Output('exit.pdf', 'I');
	
// 	App::import('Vendor', 'PHPWord/PHPWord');
// 	$PHPWord = new PHPWord();

// $document = $PHPWord->loadTemplate('Template.docx');

// $document->setValue('Value1', '太陽');
// $document->setValue('Value2', '水星');
// $document->setValue('Value3', '火星');
// $document->setValue('Value4', 'Earth');
// $document->setValue('Value5', 'Mars');
// $document->setValue('Value6', 'Jupiter');
// $document->setValue('Value7', 'Saturn');
// $document->setValue('Value8', 'Uranus');
// $document->setValue('Value9', 'Neptun');
// $document->setValue('Value10', 'Pluto');

// $document->setValue('weekday', date('l'));
// $document->setValue('time', date('H:i'));

// $document->save('Solarsystem.docx');