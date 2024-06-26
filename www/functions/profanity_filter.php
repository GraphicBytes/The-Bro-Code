<?php
class filter_profanity
{

	private $joining_chars = ' _\-\+\.';

	private $profanity = array( 'cunt','fuck','nigger','pussy','coon');

	private $replacement = array(
		'a' => 'aªàáâãäåāăąǎȁȃȧᵃḁẚạảₐ⒜ⓐａ4⍺4⁴₄④⑷⒋４₳@',
		'b' => 'bᵇḃḅḇ⒝ⓑｂɞßℬ฿',
		'c' => 'cçćĉċčᶜⅽ⒞ⓒｃ©¢℃￠€\<',
		'd' => 'dďᵈḋḍḏḑḓⅆⅾ⒟ⓓｄ',
		'e' => 'eèéêëēĕėęěȅȇȩᵉḙḛẹẻẽₑ℮ℯⅇ⒠ⓔｅ⅀∑⨊⨋€℮',
		'f' => 'fᶠḟ⒡ⓕﬀｆƒ⨐ƒ៛',
		'g' => 'gĝğġģǧǵɡᵍᵹḡℊ⒢ⓖｇ',
		'h' => 'hĥȟʰһḣḥḧḩḫẖₕℎ⒣ⓗｈ44⁴₄④⑷⒋４',
		'i' => 'iìíîïĩīĭįİıǐȉȋᵢḭỉịⁱℹⅈⅰⅱ⒤ⓘｉlĺļľŀˡḷḻḽₗℓⅼ⒧ⓛｌ|׀∣❘｜1¹₁⅟①⑴⒈１',
		'j' => 'jĵǰʲⅉ⒥ⓙⱼｊ',
		'k' => 'kķǩᵏḱḳḵₖ⒦ⓚｋ',
		'l' => 'iìíîïĩīĭįİıǐȉȋᵢḭỉịⁱℹⅈⅰⅱ⒤ⓘｉlĺļľŀˡḷḻḽₗℓⅼ⒧ⓛｌ|׀∣❘｜1¹₁⅟①⑴⒈１',
		'm' => 'mᵐḿṁṃₘⅿ⒨ⓜ㎜ｍℳ',
		'n' => 'nñńņňŉƞǹṅṇṉṋⁿₙ⒩ⓝｎ',
		'o' => 'oºòóôõöōŏőơǒǫȍȏȯᵒọỏₒℴ⒪ⓞｏ°⃝⃠⊕⊖⊗⊘⊙⊚⊛⊜⊝⌼⌽⌾⍉⍜⍟⍥⎉⎊⎋⏀⏁⏂⏣○◌●◯⚆⚇⚪⚬❍⦲⦵⦶⦷⦸⦹⦾⧂⧃⧲⧬⨀㊀0⁰₀⓪０',
		'p' => 'pᵖṕṗₚ⒫ⓟｐ',
		'q' => 'q⒬ⓠｑ',
		'r' => 'rŕŗřȑȓɼʳᵣṙṛṟ⒭ⓡｒſẛɼẛ',
		's' => 'sśŝşšșˢṡṣₛ⒮ⓢｓ$﹩＄5⁵₅⑤⑸⒌５§',
		't' => 'tţťƫțᵗƾṫṭṯṱẗₜ⒯ⓣｔ☨☩♰♱⛨✙✚✛✜✝✞✟⧧†\+',
		'u' => 'uùúûüũūŭůűųưǔȕȗᵘᵤṳṵṷụủ⒰ⓤｕvᵛᵥṽṿⅴ⒱ⓥｖ',
		'v' => 'uùúûüũūŭůűųưǔȕȗᵘᵤṳṵṷụủ⒰ⓤｕvᵛᵥṽṿⅴ⒱ⓥｖ',
		'w' => 'wŵʷẁẃẅẇẉẘ⒲ⓦｗ',
		'x' => 'xˣẋẍₓⅹ⒳ⓧｘ˟╳❌❎⤫⤬⤭⤮⤯⤰⤱⤲⨯×✕✖⨰⨱⨴⨵⨶⨷',
		'y' => 'yýÿŷȳʸẏẙỳỵỷỹ⒴ⓨｙ¥￥',
		'z' => 'zźżžƶᶻẑẓẕ⒵ⓩｚ2²₂②⑵⒉２',
		' ' => ' _\-\+\.',
	);

	public function filter_string($filter_line, $replace_char='*')
	{
		foreach($this->profanity as $word)
		{
			$regex = '/(\b|[ \t])';
			$regex_parts = array();

			for($i=0; $i<strlen($word); $i++)
			{
				$letter = substr($word, $i, 1);
				$regex_parts[] = "[{$this->replacement[$letter]}]+";
			}
			$regex_parts[] = "[{$this->replacement['e']}]*[{$this->replacement['s']}{$this->replacement['d']}]*";

			$regex .= join("[{$this->joining_chars}]*", $regex_parts);
			$regex .= '(\b|[ \t])/ui';

			$replacement = (mb_strlen($replace_char))?' '.str_pad('', strlen($word), $replace_char).' ':'';
			$filter_line = preg_replace($regex, $replacement, $filter_line );
		}
		return $filter_line;
	}
}

?>
