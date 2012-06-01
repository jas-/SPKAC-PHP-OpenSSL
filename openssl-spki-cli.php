#!/usr/local/bin/php
<?php

echo "Generating private key...";
$pkey = openssl_pkey_new(array('digest_alg' => 'sha512',
                               'private_key_type' => OPENSSL_KEYTYPE_RSA,
                               'private_key_bits' => 2048));
openssl_pkey_export($pkey, $pass);
echo "done\n";
echo "============================\n";

$algo = array('md4'=>OPENSSL_ALGO_MD4,
              'md5'=>OPENSSL_ALGO_MD5,
              'sha1'=>OPENSSL_ALGO_SHA1,
              'sha256'=>OPENSSL_ALGO_SHA256,
              'sha384'=>OPENSSL_ALGO_SHA384,
              'sha512'=>OPENSSL_ALGO_SHA512,
              'ripemd160'=>OPENSSL_ALGO_RIPEMD160);

foreach($algo as $key => $value) {

	echo "Creating SPKAC using ".$key." signature...\n";
	if (function_exists('openssl_spki_new')){
		$spki = openssl_spki_new($pkey, _uuid(), $value);
		echo $spki;
	}
	echo "\ndone\n";
	echo "============================\n";

	echo "Verifying SPKAC with ".$key." signature...\n";
	if (function_exists('openssl_spki_verify')){
		$w = openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki));
		var_dump($w);
	}
	echo "\n============================\n";

	echo "Exporting challenge from SPKAC with ".$key." signature...\n";
	if (function_exists('openssl_spki_export_challenge')){
		$x = openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki));
		echo $x;
	}
	echo "\ndone\n";
	echo "============================\n";

	echo "Exporting public key from SPKAC with ".$key." signature...\n";
	if (function_exists('openssl_spki_export')){
		$y = openssl_spki_export(preg_replace('/SPKAC=/', '', $spki));
		print_r($y);
	}
	echo "\n============================\n";

	unset($w, $x, $y, $z);
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
