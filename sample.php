<?

$str = isset($_POST['str']) ? $_POST['str'] : '<font style="color:#FF00FF">ぽ</font><span style="font-size:50px;"><font style="color:#ED12FF">ん</font><font style="color:#E51AFF">ぽ</font><font style="color:#DC23FF">ん</font><font style="color:#D32CFF">う</font><font style="color:#CA35FF">ぇ</font><font style="color:#C13EFF">い</font><font style="color:#B946FF">う</font><font style="color:#B04FFF">ぇ</font><font style="color:#A758FF">い</font><font style="color:#9E61FF">う</font><font style="color:#956AFF">ぇ</font><font style="color:#8D72FF">い</font><font style="color:#847BFF">ぽ</font><font style="color:#7B84FF">ん</font><font style="color:#728DFF">ぽ</font><font style="color:#6A95FF">ん</font></span><font style="color:#619EFF">う</font><font style="color:#58A7FF">ぇ</font><font style="color:#4FB0FF">い</font><font style="color:#46B9FF">ぽ</font><font style="color:#3EC1FF">ん</font><font style="color:#35CAFF">う</font><font style="color:#2CD3FF">ぇ</font><font style="color:#23DCFF">い</font><font style="color:#1AE5FF">ぽ</font><font style="color:#12EDFF">ん</font><font style="color:#09F6FF">ぽ</font><font style="color:#00FFFF">ん</font>';
$len = isset($_POST['len']) ? $_POST['len'] : 7;
$result = HTMLCodeSummary($str, $len);


function HTMLCodeSummary($str='', $len=0){
	$flag = true;
	$tagFlag = false;
	$unsetTagFlag = false;
	$tag='';
	$unsetTag='';
	$tags = array();
	$cnt = 1;
	$result = '';

	preg_match_all("/(.)/u", $str, $mat);
	foreach($mat[0] as $key=>$value){
		if($cnt>$len){
			break;
		}
		$result.= $value;
//		echo '['.$cnt.']'.$value.'<br>';

		

		if($value == '<' ){
			if($mat[0][$key+1]=='/'){
				$unsetTagFlag=true;
			}else{
				$tagFlag=true;
//				echo 'tag';
			}
			$flag=false;
		}
		if($tagFlag){
			if($value == ' '){
				$tagFlag=false;
				$tag.='>';
				$tags[] = str_replace('<', '</', $tag);
				$tag='';
			}else{
				$tag.= $value;
			}
		}
		if($flag){
			$cnt++;
		}
		if($unsetTagFlag){
			$unsetTag.=$value;
		}
		if($value == '>'){
			$unsetTagFlag=false;

			$key = array_search($unsetTag, $tags);
			unset($tags[$key]);
			$unsetTag='';
			$flag=true;
		}
	}
	
	while($popTag = array_pop($tags)){
		$result.= $popTag;
	}

	return $result;
}?>
<!DOCTYPE html>
<html lang="ja-JP" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<html>
<form action="split.php" method="POST">
<label>文字数<input type="text" name="len" value="<?=$len?>"></label><input type="submit" value="送信">

<label>
<p>入力テキスト</p>
<textarea name="str" cols="100" rows="20"><?=$str?></textarea>
</label>
<p>入力テキスト（HTML）</p>
<div><?=$str?></div>
<p>処理テキスト（HTML）</p>
<div><?=$result?>...</div>
<p>処理テキスト（noHTML）</p>
<div><?=htmlspecialchars($result)?></div>

</form>
</html>
</body>