class SimpleICS {
	use SimpleICS_Util;
	const MIME_TYPE = 'text/calendar; charset=utf-8';
	
	var $events = [];
	var $productString = '-//hacksw/handcal//NONSGML v1.0//EN';
	static $Template = null;
	function addEvent($eventOrClosure) {
		if (is_object($eventOrClosure) && ($eventOrClosure instanceof Closure)) {
			$event = new SimpleICS_Event();
			$eventOrClosure($event);
		}
		$this->events[] = $event;
		return $event;
	}
	function serialize() {
		return $this->filter_linelimit($this->render(self::$Template, $this));
	}
}
class SimpleICS_Event {
	use SimpleICS_Util;
	var $uniqueId;
	var $startDate;
	var $endDate;
	var $dateStamp;
	var $location;
	var $description;
	var $uri;
	var $summary;
	static $Template;
	function __construct() {
		$this->uniqueId = uniqid();
	}
	function serialize() {
		return $this->render(self::$Template, $this);
	}
}
trait SimpleICS_Util {
	function filter_linelimit($input, $lineLimit = 70) {
		// go through each line and make them shorter.
		$output = '';
		$line = '';
		$pos = 0;
		while ($pos < strlen($input)) {
			// find the newline
			$newLinepos = strpos($input, "\n", $pos + 1);
			if (!$newLinepos)
				$newLinepos = strlen($input);
			$line = substr($input, $pos, $newLinepos - $pos);
			if (strlen($line) <= $lineLimit) {
				$output .= $line;
			} else {
				// First line cut-off limit is $lineLimit
				$output .= substr($line, 0, $lineLimit);
				$line = substr($line, $lineLimit);
				
				// Subsequent line cut-off limit is $lineLimit - 1 due to the leading white space
				$output .= "\n " . substr($line, 0, $lineLimit - 1);
				
				while (strlen($line) > $lineLimit - 1){
					$line = substr($line, $lineLimit - 1);
					$output .= "\n " . substr($line, 0, $lineLimit - 1);
				}
			}
			$pos = $newLinepos;
		}
		return $output;
	}
	function filter_calDate($input) {
		if (!is_a($input, 'DateTime'))
			$input = new DateTime($input);
		else
			$input = clone $input;
		$input->setTimezone(new DateTimeZone('UTC'));
		return $input->format('Ymd\THis\Z');
	}
	function filter_serialize($input) {
		if (is_object($input)) {
			return $input->serialize();
		}
		if (is_array($input)) {
			$output = '';
			array_walk($input, function($item) use (&$output) {
				$output .= $this->filter_serialize($item);
			});
			return trim($output, "\r\n");
		}
		return $input;
	}
	function filter_quote($input) {
		return quoted_printable_encode($input);
	}
	function filter_escape($input) {
		$input = preg_replace('/([\,;])/','\\\$1', $input);
		$input = str_replace("\n", "\\n", $input);
		$input = str_replace("\r", "\\r", $input);
		return $input;
	}
	function render($tpl, $scope) {
		while (preg_match("/\{\{([^\|\}]+)((?:\|([^\|\}]+))+)?\}\}/", $tpl, $m)) {
			$replace = $m[0];
			$varname = $m[1];
			$filters = isset($m[2]) ? explode('|', trim($m[2], '|')) : [];
			$value = $this->fetch_var($scope, $varname);
			$self = &$this;
			array_walk($filters, function(&$item) use (&$value, $self) {
				$item = trim($item, "\t\r\n ");
				if (!is_callable([ $self, 'filter_' . $item ]))
					throw new Exception('No such filter: ' . $item);
				$value = call_user_func_array([ $self, 'filter_' . $item ], [ $value ]);
			});
			$tpl = str_replace($m[0], $value, $tpl);
		}
		return $tpl;
	}
	function fetch_var($scope, $var) {
		if (strpos($var, '.')!==false) {
			$split = explode('.', $var);
			$var = array_shift($split);
			$rest = implode('.', $split);
			$val = $this->fetch_var($scope, $var);
			return $this->fetch_var($val, $rest);
		}
		if (is_object($scope)) {
			$getterMethod = 'get' . ucfirst($var);
			if (method_exists($scope, $getterMethod)) {
				return $scope->{$getterMethod}();
			}
			return $scope->{$var};
		}
		if (is_array($scope))
			return $scope[$var];
		throw new Exception('A strange scope');
	}
}
SimpleICS::$Template = <<<EOT
BEGIN:VCALENDAR
VERSION:2.0
PRODID:{{productString}}
METHOD:PUBLISH
CALSCALE:GREGORIAN
{{events|serialize}}
END:VCALENDAR
EOT;

SimpleICS_Event::$Template = <<<EOT
BEGIN:VEVENT
UID:{{uniqueId}}
DTSTART:{{startDate|calDate}}
DTSTAMP:{{dateStamp|calDate}}
DTEND:{{endDate|calDate}}
LOCATION:{{location|escape}}
DESCRIPTION:{{description|escape}}
URL;VALUE=URI:{{uri|escape}}
SUMMARY:{{summary|escape}}
END:VEVENT
EOT;