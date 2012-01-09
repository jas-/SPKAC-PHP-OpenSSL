#!/usr/local/bin/php
<?php

echo "Generating private key...";
$key = openssl_pkey_new(array('digest_alg' => 'sha512',
                              'private_key_type' => OPENSSL_KEYTYPE_RSA,
                              'private_key_bits' => 2048));
echo "done\n";
echo "============================\n";

echo "Creating SPKAC using md5 signature...\n";
if (function_exists('openssl_spki_new')){
 $spki = openssl_spki_new($key, _uuid(), 'md5');
 echo $spki;
}
echo "\ndone\n";
echo "============================\n";

echo "Verifying SPKAC with md5 signature...\n";
if (function_exists('openssl_spki_verify')){
 $w = openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki));
 var_dump($w);
}
echo "\n============================\n";

echo "Exporting challenge from SPKAC with md5 signature...\n";
if (function_exists('openssl_spki_export_challenge')){
 $x = openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki));
 echo $x;
}
echo "\ndone\n";
echo "============================\n";

echo "Exporting public key from SPKAC with md5 signature...\n";
if (function_exists('openssl_spki_export')){
 $y = openssl_spki_export(preg_replace('/SPKAC=/', '', $spki));
 print_r($y);
}
echo "\n============================\n";

echo "SPKAC details with md5 signature...\n";
if (function_exists('openssl_spki_details')){
 $z = openssl_spki_details(preg_replace('/SPKAC=/', '', $spki));
 print_r($z);
}
echo "done\n";
echo "============================\n";

unset($w, $x, $y, $z);

echo "Creating SPKAC using sha1 signature...\n";
if (function_exists('openssl_spki_new')){
 $spki = openssl_spki_new($key, _uuid(), 'sha1');
 echo $spki;
}
echo "\ndone\n";
echo "============================\n";

echo "Verifying SPKAC with sha1 signature...\n";
if (function_exists('openssl_spki_verify')){
 $w = openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki));
 var_dump($w);
}
echo "\n============================\n";

echo "Exporting challenge from SPKAC with sha1 signature...\n";
if (function_exists('openssl_spki_export_challenge')){
 $x = openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki));
 echo $x;
}
echo "\ndone\n";
echo "============================\n";

echo "Exporting public key from SPKAC with sha1 signature...\n";
if (function_exists('openssl_spki_export')){
 $y = openssl_spki_export(preg_replace('/SPKAC=/', '', $spki));
 print_r($y);
}
echo "\n============================\n";

echo "SPKAC details with sha1 signature...\n";
if (function_exists('openssl_spki_details')){
 $z = openssl_spki_details(preg_replace('/SPKAC=/', '', $spki));
 print_r($z);
}
echo "done\n";
echo "============================\n";

unset($w, $x, $y, $z);

echo "Creating SPKAC using sha256 signature...\n";
if (function_exists('openssl_spki_new')){
 $spki = openssl_spki_new($key, _uuid(), 'sha256');
 echo $spki;
}
echo "\ndone\n";
echo "============================\n";

echo "Verifying SPKAC with sha256 signature...\n";
if (function_exists('openssl_spki_verify')){
 $w = openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki));
 var_dump($w);
}
echo "\n============================\n";

echo "Exporting challenge from SPKAC with sha256 signature...\n";
if (function_exists('openssl_spki_export_challenge')){
 $x = openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki));
 echo $x;
}
echo "\ndone\n";
echo "============================\n";

echo "Exporting public key from SPKAC with sha256 signature...\n";
if (function_exists('openssl_spki_export')){
 $y = openssl_spki_export(preg_replace('/SPKAC=/', '', $spki));
 print_r($y);
}
echo "\n============================\n";

echo "SPKAC details with sha256 signature...\n";
if (function_exists('openssl_spki_details')){
 $z = openssl_spki_details(preg_replace('/SPKAC=/', '', $spki));
 print_r($z);
}
echo "done\n";
echo "============================\n";

unset($w, $x, $y, $z);

echo "Creating SPKAC using sha512 signature...\n";
if (function_exists('openssl_spki_new')){
 $spki = openssl_spki_new($key, _uuid(), 'md5');
 echo $spki;
}
echo "\ndone\n";
echo "============================\n";

echo "Verifying SPKAC with sha512 signature...\n";
if (function_exists('openssl_spki_verify')){
 $w = openssl_spki_verify(preg_replace('/SPKAC=/', '', $spki));
 var_dump($w);
}
echo "\n============================\n";

echo "Exporting challenge from SPKAC with sha512 signature...\n";
if (function_exists('openssl_spki_export_challenge')){
 $x = openssl_spki_export_challenge(preg_replace('/SPKAC=/', '', $spki));
 echo $x;
}
echo "\ndone\n";
echo "============================\n";

echo "Exporting public key from SPKAC with sha512 signature...\n";
if (function_exists('openssl_spki_export')){
 $y = openssl_spki_export(preg_replace('/SPKAC=/', '', $spki));
 print_r($y);
}
echo "\n============================\n";

echo "SPKAC details with sha512 signature...\n";
if (function_exists('openssl_spki_details')){
 $z = openssl_spki_details(preg_replace('/SPKAC=/', '', $spki));
 print_r($z);
}
echo "done\n";
echo "============================\n";

unset($w, $x, $y, $z);

openssl_free_key($key);

function _uuid()
{
 return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff),
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff),
                mt_rand(0, 0xffff), mt_rand(0, 0xffff));
}

?>
