#!/usr/local/bin/php
<?php

error_reporting(0);

/* array of private key sizes to test */
$ksize = array('1024'=>1024,
			   '2048'=>2048,
			   '4096'=>4096);

/* array of available hashing algorithms to test */
$algo = array('md4'=>OPENSSL_ALGO_MD4,
              'md5'=>OPENSSL_ALGO_MD5,
              'sha1'=>OPENSSL_ALGO_SHA1,
			  'sha224'=>OPENSSL_ALGO_SHA224,
              'sha256'=>OPENSSL_ALGO_SHA256,
              'sha384'=>OPENSSL_ALGO_SHA384,
              'sha512'=>OPENSSL_ALGO_SHA512,
              'rmd160'=>OPENSSL_ALGO_RMD160);

/* loop over key sizes for test */
foreach($ksize as $k => $v) {

	/* generate new private key of specified size to use for tests */
	echo "Generating private key of ".$k." bits...";
	$pkey = openssl_pkey_new(array('digest_alg' => 'sha512',
	                               'private_key_type' => OPENSSL_KEYTYPE_RSA,
	                               'private_key_bits' => $v));
	openssl_pkey_export($pkey, $pass);
	echo "done\n";
	echo "============================\n";

	/* test each size private key with specified hashing algorithms */
	foreach($algo as $key => $value) {

		/* create SPKAC block */
		echo "Creating SPKAC using ".$key." signature and ".$v." size key...\n";
		if (function_exists('openssl_spki_new')){
			$spki = openssl_spki_new($pkey, _uuid(), $value);
			var_dump($spki);
		}
		echo "\ndone\n";
		echo "============================\n";

		/* verify SPKAC block */
 		echo "Verifying SPKAC with ".$key." signature...\n";
		if (function_exists('openssl_spki_verify')){
			$w = openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki));
			var_dump($w);
			$ww = openssl_spki_verify($spki.'an error should occur');
			var_dump($ww);
		}
		echo "\ndone\n";
		echo "\n============================\n";

		/* export challenge from SPKAC block */
		echo "Exporting challenge from SPKAC with ".$key." signature...\n";
		if (function_exists('openssl_spki_export_challenge')){
			$x = openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki));
			var_dump($x);
			$xx = openssl_spki_export_challenge($spki.'an error should occur');
			var_dump($xx);
		}
		echo "\ndone\n";
		echo "============================\n";

		/* export public key from SPKAC block */
		echo "Exporting public key from SPKAC with ".$key." signature...\n";
		if (function_exists('openssl_spki_export')){
			$y = openssl_spki_export(preg_replace('/SPKAC=/', '', $spki));
			print_r($y);
			$yy = openssl_spki_export($spki.'an error should occur');
			print_r($yy);
		}
		echo "\ndone\n";
		echo "\n============================\n";
	}
}

openssl_free_key($pkey);

function _uuid()
{
 return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff),
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff),
                mt_rand(0, 0xffff), mt_rand(0, 0xffff));
}

?>
