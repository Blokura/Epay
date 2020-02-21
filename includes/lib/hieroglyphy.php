<?php
namespace lib;

class hieroglyphy{
	private $characters;
	private $numbers;
	private $unescape;
	private $functionConstructor;

	public function __construct(){
		$this->precharacters();
	}

	private function precharacters(){
		$this->numbers = array(
			"+[]",
			"+!![]",
			"!+[]+!![]",
			"!+[]+!![]+!![]",
			"!+[]+!![]+!![]+!![]",
			"!+[]+!![]+!![]+!![]+!![]",
			"!+[]+!![]+!![]+!![]+!![]+!![]",
			"!+[]+!![]+!![]+!![]+!![]+!![]+!![]",
			"!+[]+!![]+!![]+!![]+!![]+!![]+!![]+!![]",
			"!+[]+!![]+!![]+!![]+!![]+!![]+!![]+!![]+!![]"
		);

		$this->characters = array(
			"0" => "(" . $this->numbers[0] . "+[])",
			"1" => "(" . $this->numbers[1] . "+[])",
			"2" => "(" . $this->numbers[2] . "+[])",
			"3" => "(" . $this->numbers[3] . "+[])",
			"4" => "(" . $this->numbers[4] . "+[])",
			"5" => "(" . $this->numbers[5] . "+[])",
			"6" => "(" . $this->numbers[6] . "+[])",
			"7" => "(" . $this->numbers[7] . "+[])",
			"8" => "(" . $this->numbers[8] . "+[])",
			"9" => "(" . $this->numbers[9] . "+[])"
		);

		$_object_Object = "[]+{}";
		$_NaN = "+{}+[]";
		$_true = "!![]+[]";
		$_false = "![]+[]";
		$_undefined = "[][[]]+[]";

		$this->characters[" "] = "(" . $_object_Object . ")[" . $this->numbers[7]  . "]";
		$this->characters["["] = "(" . $_object_Object . ")[" . $this->numbers[0]  . "]";
		$this->characters["]"] = "(" . $_object_Object . ")[" .  $this->characters[1] . "+" . $this->characters[4] . "]";
		$this->characters["a"] = "(" . $_NaN . ")[" . $this->numbers[1] . "]";
		$this->characters["b"] = "(" . $_object_Object . ")[" . $this->numbers[2] . "]";
		$this->characters["c"] = "(" . $_object_Object . ")[" . $this->numbers[5] . "]";
		$this->characters["d"] = "(" . $_undefined . ")[" . $this->numbers[2] . "]";
		$this->characters["e"] = "(" . $_undefined . ")[" . $this->numbers[3] . "]";
		$this->characters["f"] = "(" . $_false . ")[" . $this->numbers[0] . "]";
		$this->characters["i"] = "(" . $_undefined . ")[" . $this->numbers[5] . "]";
		$this->characters["j"] = "(" . $_object_Object . ")[" . $this->numbers[3] . "]";
		$this->characters["l"] = "(" . $_false . ")[" . $this->numbers[2] . "]";
		$this->characters["n"] = "(" . $_undefined . ")[" . $this->numbers[1] . "]";
		$this->characters["o"] = "(" . $_object_Object . ")[" . $this->numbers[1] . "]";
		$this->characters["r"] = "(" . $_true . ")[" . $this->numbers[1] . "]";
		$this->characters["s"] = "(" . $_false . ")[" . $this->numbers[3] . "]";
		$this->characters["t"] = "(" . $_true . ")[" . $this->numbers[0] . "]";
		$this->characters["u"] = "(" . $_undefined . ")[" . $this->numbers[0] ."]";
		$this->characters["N"] = "(" . $_NaN . ")[" . $this->numbers[0] . "]";
		$this->characters["O"] = "(" . $_object_Object . ")[" . $this->numbers[8] . "]";

		$_Infinity = "+(" . $this->numbers[1] . "+" . $this->characters["e"] . "+" . $this->characters[1] . "+" . $this->characters[0] . "+" . $this->characters[0] . "+" . $this->characters[0] . ")+[]";

		$this->characters["y"] = "(" . $_Infinity . ")[" . $this->numbers[7] . "]";
		$this->characters["I"] = "(" . $_Infinity . ")[" . $this->numbers[0] . "]";

		$_1e100 = "+(" . $this->numbers[1] . "+" . $this->characters["e"] . "+" . $this->characters[1] . "+" . $this->characters[0] . "+" . $this->characters[0] . ")+[]";

		$this->characters["+"] = "(" . $_1e100 . ")[" . $this->numbers[2] . "]";

		$this->functionConstructor = "[][" . $this->hieroglyphyString("sort") . "][" . $this->hieroglyphyString("constructor") . "]";

		//Below  $this->characters need target http(s) pages
		$locationString = "[]+" . $this->hieroglyphyScript("return location");
		$this->characters["h"] = "(" . $locationString . ")" . "[" . $this->numbers[0] . "]";
		$this->characters["p"] = "(" . $locationString . ")" . "[" . $this->numbers[3] . "]";
		$this->characters["/"] = "(" . $locationString . ")" . "[" . $this->numbers[6] . "]";

		$this->unescape = $this->hieroglyphyScript("return unescape");
		$escape = $this->hieroglyphyScript("return escape");

		$this->characters["%"] = $escape . "(" . $this->hieroglyphyString("[") . ")[" . $this->numbers[0] . "]";
	}

    private function getHexaString ($number, $digits) {
        $string = bin2hex($number);

        while (strlen($string) < $digits) {
            $string = "0" . $string;
        }

        return $string;
    }

    private function getUnescapeSequence ($charCode) {
        return $this->unescape . "(" .
            $this->hieroglyphyString("%" . $this->getHexaString($charCode, 2)) . ")";
    }

    private function getHexaSequence ($charCode) {
        return $this->hieroglyphyString("\\x" . $this->getHexaString($charCode, 2));
    }

    private function getUnicodeSequence ($charCode) {
        return $this->hieroglyphyString("\\u" . $this->getHexaString($charCode, 4));
    }

    private function hieroglyphyCharacter ($char) {
        $charCode = ord($char);

        if (isset($this->characters[$char])) {
            return  $this->characters[$char];
        }

        if (($char == "\\") || ($char == "x")) {
            //These chars must be handled appart becuase the others need them
            $this->characters[$char] = $this->getUnescapeSequence($charCode);
            return  $this->characters[$char];
        }

        $shortestSequence = $this->getUnicodeSequence($charCode);

        //ASCII  $characters can be obtained with hexa and unscape sequences
        if ($charCode < 128) {
            $unescapeSequence = $this->getUnescapeSequence($charCode);
            if (strlen($shortestSequence) > strlen($unescapeSequence)) {
                $shortestSequence = $unescapeSequence;
            }

            $hexaSequence = $this->getHexaSequence($charCode);
            if (strlen($shortestSequence) > strlen($hexaSequence)) {
                $shortestSequence = $hexaSequence;
            }
        }

        $this->characters[$char] = $shortestSequence;
        return $shortestSequence;
    }

    public function hieroglyphyString ($str) {
        $hieroglyphiedStr = "";

        for ($i = 0; $i < strlen($str); $i++) {

            $hieroglyphiedStr .= ($i > 0) ? "+" : "";
            $hieroglyphiedStr .= $this->hieroglyphyCharacter($str[$i]);
        }

        return $hieroglyphiedStr;
    }

    public function hieroglyphyNumber ($n) {
        $n = +$n;

        if ($n <= 9) {
            return $this->numbers[$n];
        }

        return "+(" . $this->hieroglyphyString(ord($n[10])) . ")";
    }

    public function hieroglyphyScript ($src) {
        return $this->functionConstructor . "("  . $this->hieroglyphyString($src) . ")()";
    }
}