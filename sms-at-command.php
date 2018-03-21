<?php
        // How to run: php sms-at-command.php [number] "[message]" [device]
	ini_set('memory_limit', '-1');
	require 'php_serial.class.php';
	$SMS=$argv;

        $serial = new phpSerial;
//      $serial->deviceSet("/dev/ttyUSB32");
        $serial->deviceSet("$SMS[3]");
        $serial->confBaudRate(115200);
        $serial->confCharacterLength(8);
        $serial->confParity("none");
        $serial->confStopBits(1);
//      $serial->confFlowControl("rts/cts");
        $serial->confFlowControl("none");
        $ready = $serial->deviceOpen();


	if ($ready)
	{
		$serial->sendMessage("ATZ \r\n",0.5);
		$serial->sendMessage("AT \r\n",0.5);
		$serial->sendMessage("AT+CSQ \r\n",0.5);
		$serial->sendMessage("AT+IPR=? \r\n",0.5);
		$serial->sendMessage("AT+IPR? \r\n",0.5);
		$serial->sendMessage("AT+ICF=? \r\n",0.5);
		$serial->sendMessage("AT+ICF? \r\n",0.5);
		$serial->sendMessage("AT+IFC=? \r\n",0.5);
		
		$message = preg_replace("%[^\040-\176\r\n\t]%", '', $SMS[2]);
		$serial->sendMessage("AT+CMGF=1"."\r\n",1);	
		$serial->sendMessage("AT+CMGS=\"+62$SMS[1]\"\r\n",1);
		$serial->sendMessage("$message\r\n".chr(26), 2);
		//$serial->sendMessage(chr(26));

		$S = $serial->readPort();
                echo $S."\n";
		$serial->deviceClose();
		$S = preg_replace("/(?:(?:\r\n|\r|\n)\s*){2}/","\n",$S);
		echo $S."\n";
	};
?>
