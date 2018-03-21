<?php
        //How to run: php signal-check-at-command.php [device]
	ini_set('memory_limit', '-1');
	require 'php_serial.class.php';
	$SMS=$argv;

        $serial = new phpSerial;
//      $serial->deviceSet("/dev/ttyUSB32");
        $serial->deviceSet("$SMS[1]");
        $serial->confBaudRate(115200);
        $serial->confCharacterLength(8);
        $serial->confParity("none");
        $serial->confStopBits(1);
        $serial->confFlowControl("rts/cts");
        $serial->confFlowControl("none");
        $ready = $serial->deviceOpen();

	if ($ready)
	{
		$serial->sendMessage("ATZ \r\n",0.5);
		$serial->sendMessage("AT \r\n",0.5);
		$serial->sendMessage("AT+CSQ \r\n",0.5);

		$S = $serial->readPort();
                echo $S."\n";
		$serial->deviceClose();
		$S = preg_replace("/(?:(?:\r\n|\r|\n)\s*){2}/","\n",$S);
		echo $S."\n";
	};
?>
