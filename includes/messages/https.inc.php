<?#//v.1.1.0
	$R = @mysql_query("SELECT * FROM PHPAUCTIONPROPLUS_https");
	if(!$R)
	{
		MySQLError($query);
		exit;
	}
	else
	{
		$Https = @mysql_fetch_array($R);
		if($Https[https] == 'no')
		{
			$Https[httpsurl] = $SETTINGS[siteurl];
		}
	}
	
	#// Force SSL transaction if it's set to on and the user is logged in.
	if($HTTPS != "on" && $Https[https] == 'yes' && isset($HTTP_SESSION_VARS[PHPAUCTION_LOGGED_IN]))
	{
		$GOTO = "$Https[httpsurl]".basename($PHP_SELF);
		Header("Location: $GOTO");
	}
	#// Force SSL transaction if this is the sign up script.
	if($HTTPS != "on" && $Https[https] == 'yes' && basename($PHP_SELF) == "register.php")
	{
		$GOTO = "$Https[httpsurl]".basename($PHP_SELF);
		Header("Location: $GOTO");
	}

	#// Force HTTP transaction if necessary
	if($HTTPS == "on" && !isset($HTTP_SESSION_VARS[PHPAUCTION_LOGGED_IN]) && (basename($PHP_SELF) != "register.php" && basename($PHP_SELF) != "login.php"))
	{
//	print $SETTINGS[siteurl].basename($PHP_SELF);
		$GOTO = $SETTINGS[siteurl].basename($PHP_SELF);
		Header("Location: $GOTO");
	}

?>
