<?php
	ini_set('memory_limit', '-1');
	require 'php_serial.class.php';
	$SMS=$argv;



        $serial = new phpSerial;
//        $serial->deviceSet("/dev/ttyUSB32");
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
		$serial->sendMessage('AT+CSCS="GSM"' . " \r\n",0.5);
                $serial->serialflush();
                sleep(1);
		$serial->sendMessage("AT+CMGF=0 \r\n",0.5);
		$serial->sendMessage("AT+CUSD=1,$SMS[2] \r\n",30);
		//$serial->sendMessage("AT+CUSD=1,*776*$SMS[2]# \r\n",30);
		//$serial->sendMessage('AT+CUSD=1,"'*776*8511#'"' . " \r\n",19);
                //$serial->sendMessage('AT+CUSD=1,"1"' . " \r\n",20);


		$S = $serial->readPort();
		//echo $S."\n";
	//	$serial->deviceClose();
		$S = preg_replace("/(?:(?:\r\n|\r|\n)\s*){2}/","\n",$S);
		echo $S."\n";
		$serial->deviceClose();		

	};
?>
