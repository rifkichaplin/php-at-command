<?php
        //How to run: php ussd-at-command.php [device] 
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
//      $serial->confFlowControl("rts/cts");
        $serial->confFlowControl("none");
        $ready = $serial->deviceOpen();

	if ($ready)
	{
		$serial->sendMessage("ATQ0 V1 E1 S0=0 &C1 &D2 +FCLASS=0\r\n",0.5);
		$serial->sendMessage("ATZ \r\n",0.5);
		$serial->sendMessage("AT \r\n",0.5);
		$serial->sendMessage("AT+CSQ \r\n",0.5);
		$serial->sendMessage("AT+IPR=? \r\n",0.5);
		$serial->sendMessage("AT+IPR? \r\n",0.5);
		$serial->sendMessage("AT+ICF=? \r\n",0.5);
		$serial->sendMessage("AT+ICF? \r\n",0.5);
		$serial->sendMessage("AT+IFC=? \r\n",0.5);
		
                $serial->sendMessage('AT+CSCS="GSM"' . " \r\n",0.5);
                $serial->sendMessage('AT+CUSD=1,"*808#"' . " \r\n",19);

 		$S = $serial->readPort();
                $serial->deviceClose();
                $S = preg_replace("/(?:(?:\r\n|\r|\n)\s*){2}/","\n",$S);
                echo $S."\n";
        } else 
                echo "failed open device\n";
?>
