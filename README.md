
#Patching the PHP OpenSSL extension to implement native SPKI support

  I needed a place to put this for future work. The patch implements five
  new native functions within the PHP OpenSSL extension for handling SPKAC
  (signed public key and challenge) strings either generated and signed on the
  server or from a client using the HTML5 KeyGen element.

  Fork me @ https://www.github.com/jas-/SPKAC-PHP-OpenSSL

## REQUIREMENTS:
* OpenSSL < 0.9.8
* PHP < 5.3

## FEATURES:
* Generate and sign SPKAC's (signture algorithms; md5, sha1, sha256 & sha512)
* Verify SPKAC (returns boolean)
* Extract challenge from SPKAC
* Extract public key form SPKAC

## USAGE EXAMPLES:
  Here is a complete list of the functions this patch implements as well as
  usage examples of how ot use them.

## Creating new SPKAC's

### Creating a new SPKAC with defaults (sha256 signature)
  Returns SPKAC string

```
openssl_spki_new($private_key, $challenge);
```

### Creating a new SPKAC using MD5 signature
  Returns SPKAC string

```php
openssl_spki_new($private_key, $challenge, OPENSSL_ALGO_MD5);
```

### Creating new SPKAC using sha1 signature
  Returns SPKAC string

```php
openssl_spki_new($private_key, $challenge, OPENSSL_ALGO_SHA1);
```

### Creating new SPKAC using sha512 signature
  Returns SPKAC string

```php
openssl_spki_new($private_key, $challgen, OPENSSL_ALGO_SHA512);
```

## Verification
  You can verify an existing SPKAC (possibly one generated from the HTML5
  KeyGen element)

### Verifying an existing SPKAC
  Returns boolean true/false value

```php
openssl_spki_verify($spkac);
```

## Extracting from SPKAC
  You may wish use the SPKAC for more then just generating certificate
  signing requests. The next two functions will allow you retrieve the
  formatted public key as well as the associated challenge from the SPKAC.

### Extracting the challenge
  Returns challenge string

```php
openssl_spki_export_challenge($spkac);
```

### Extracting the public key
  Returns a formatted string containing the public key

```php
openssl_spki_export($spkac);
```


## INSTALLATION:
* Download & install latest OpenSSL stable (0.9.8x or 1.0.x)
* Download & install latest PHP stable (5.3.x)
* Clone this repo into root of extracted PHP source code
* Run these commands:

```
%> patch -p0 < php-openssl-spki.patch
%> cd php-5.3.x
%> ./configure --with-openssl
%> make
%> make test | grep spki
%> make install
```

  Once it is installed you can use either test case provided to test. The CLI
  version might be easier for immediate testing of applied patch.

```php
/path/to/php ./openssl-spki-cli.php
```

## EXAMPLE OUTPUT
The following sample output from the test case accompanying this distribution.

All key sizes & hashing algorithms that accompany the OpenSSL libraries are tested.

```php
Generating private key of 1024 bits...done
============================
Creating SPKAC using md4 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkYjViMzYxMTktNjY5YS00ZDljLWEyYzctMGZjNGFhMjVlMmE2MA0GCSqGSIb3DQEBAwUAA4GBAF7hu0ifzmjonhAak2FhhBRsKFDzXdKIkrWxVNe8e0bZzMrWOxFM/rqBgeH3/gtOUDRS5Fnzyq425UsTYbjfiKzxGeCYCQJb1KJ2V5Ij/mIJHZr53WYEXHQTNMGR8RPm7IxwVXVSHIgAfXsXZ9IXNbFbcaLRiSTr9/N4U+MXUWL7"

done
============================
Verifying SPKAC with md4 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with md4 signature...
string(36) "b5b36119-669a-4d9c-a2c7-0fc4aa25e2a6"
bool(false)

done
============================
Exporting public key from SPKAC with md4 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using md5 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkYzBkZjFlYjctMTU0NC00MWVkLWFmN2EtZDRkYjBkNDc5ZjZmMA0GCSqGSIb3DQEBBAUAA4GBALEiapUjaIPs5uEdvCP0gFK2qofo+4GpeK1A43mu28lirYPAvCWsmYvKIZIT9TxvzmQIxAfxobf70aSNlSm6MJJKmvurAK+Bpn6ZUKQZ6A1m927LvctVSYJuUi+WVmr0fGE/OfdQ+BqSm/eQ3jnm3fBPVx1uwLPgjC5g4EvGMh8M"

done
============================
Verifying SPKAC with md5 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with md5 signature...
string(36) "c0df1eb7-1544-41ed-af7a-d4db0d479f6f"
bool(false)

done
============================
Exporting public key from SPKAC with md5 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha1 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkZmI5YWI4MTQtNjY3Ny00MmE0LWE2MGMtZjkwNWQxYTY5MjRkMA0GCSqGSIb3DQEBBQUAA4GBADu1U9t3eY9O3WOofp1RHX2rkh0TPs1CeS+sNdWUSDmdV5ifaGdeXpDikEnh4QIUIeZehxwgy2EjiZqMjMJHF++KPTzfAnHuuEtpDmIGzBnodZa1qt322iGZwgREvacv78GxJBJvPP3KLe+EDDsERG1aWLJoSZRusadacdzNmdV4"

done
============================
Verifying SPKAC with sha1 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha1 signature...
string(36) "fb9ab814-6677-42a4-a60c-f905d1a6924d"
bool(false)

done
============================
Exporting public key from SPKAC with sha1 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha224 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkMTM4Y2MxY2ItMzNkMy00Zjk1LWFiMGEtM2I2ZWFkNzhkYjY3MA0GCSqGSIb3DQEBDgUAA4GBAKIjFSzlrhJpq1I3hKt0GL62ASgS86Lte2F0Ksp2tm2Nn8vvnZf78z46SuTW54uJT6c4NKoOgf4Fi8kk5pBR49m1ckZ8zlGvMk1d9VB7JX2oM88qA8YMlBfil8W/hI2SQ80WdffuVJ18nZFp7aqnAMB7DEYBi5Ncadnzew5+4SdO"

done
============================
Verifying SPKAC with sha224 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha224 signature...
string(36) "138cc1cb-33d3-4f95-ab0a-3b6ead78db67"
bool(false)

done
============================
Exporting public key from SPKAC with sha224 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha256 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkNjRhYmQzZGYtMzgyOS00NzVjLWJjNWEtMWY4YmMwYmM2YmUxMA0GCSqGSIb3DQEBCwUAA4GBAKlPC8NGR3GNZU/vkocxpnjdWoUCqN0zr4POqpuhfYdJyrnwEuhjMD7Ti2QyIXwAirjb6otm9DAMrQURKuges8yp7JeiN94efvHJi9ceUiyP3dT6EcRtgXLF7Ifx67NK9t69UuwlTs+TJJdzR1dRICLILqA0oX2GDyaV42/rF2tF"

done
============================
Verifying SPKAC with sha256 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha256 signature...
string(36) "64abd3df-3829-475c-bc5a-1f8bc0bc6be1"
bool(false)

done
============================
Exporting public key from SPKAC with sha256 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha384 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkMjIxN2FjMzItMjgxMS00MmVhLTlmMmItNTk4ZTk4ZTBlZGQwMA0GCSqGSIb3DQEBDAUAA4GBAGlUNMeVZphzRAfuH5QaMWUJFKneG+Mq3cEjxDu4uXT14geBXz76zjgfMTFaVFq2B96Pge0L5tAgRlDuBbM7SzsTQWDrR4alz+nsCKu7U3usT38ecOUnczUiYOaV1bw/OFKS47nLokyj6YWAxdvDAcEApQWUGY3+HPW9As693UwD"

done
============================
Verifying SPKAC with sha384 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha384 signature...
string(36) "2217ac32-2811-42ea-9f2b-598e98e0edd0"
bool(false)

done
============================
Exporting public key from SPKAC with sha384 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha512 signature and 1024 size key...
string(478) "SPKAC=MIIBXjCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkNGVmZmZiYjgtNmI2ZC00MTllLThhNTUtOTYzYmQzNWRkYWI5MA0GCSqGSIb3DQEBDQUAA4GBALl1q2/ce5L8Ai7CsHC7nrPbSeIfSrPFctLmPoHd1EAMOJL8yFC9fZ7l7mhPqEBh+0SKch8yrxpdzRHVGnPUfhqMdoMRK0zE9s8BoBgerH08T8ScLaFZfjHQYGM2Can8rHl4D2NkPBg3g2B6yIoszV887l3Lrxkx4whK+xTacrAc"

done
============================
Verifying SPKAC with sha512 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha512 signature...
string(36) "4efffbb8-6b6d-419e-8a55-963bd35ddab9"
bool(false)

done
============================
Exporting public key from SPKAC with sha512 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using rmd160 signature and 1024 size key...
string(474) "SPKAC=MIIBWzCByDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3L0IfUijj7+A8CPC8EmhcdNoe5fUAog7OrBdhn7EkxFButUp40P7+LiYiygYG1TmoI/a5EgsLU3s9twEz3hmgY9mYIqb/rb+SF8qlD/K6KVyUORC7Wlz1Df4L8O3DuRGzx6/+3jIW6cPBpfgH1sVuYS1vDBsP/gMMIxwTsKJ4P0CAwEAARYkYTBiNDU1MzUtNTE1YS00OTM4LWI2N2UtNTM1MTI3MGJjM2FhMAoGBiskAwMBAgUAA4GBAEAoNEf9RPO4NV+Gmkd5oU5/qnw9AM81lVKDgGCHh5DZRDncX1Pqq5HS9IPy2rLFZUWpKGQiUzk0VYjeiXZkBndOvbocNpAWnnt4z4fpBn4LBBeW0hU32INDXtiSzJAN5yN+XOk5DlJ2R8YVGcp1cC/juVq95pnJZyH0UrsNgiyY"

done
============================
Verifying SPKAC with rmd160 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with rmd160 signature...
string(36) "a0b45535-515a-4938-b67e-5351270bc3aa"
bool(false)

done
============================
Exporting public key from SPKAC with rmd160 signature...

done
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDcvQh9SKOPv4DwI8LwSaFx02h7
l9QCiDs6sF2GfsSTEUG61SnjQ/v4uJiLKBgbVOagj9rkSCwtTez23ATPeGaBj2Zg
ipv+tv5IXyqUP8ropXJQ5ELtaXPUN/gvw7cO5EbPHr/7eMhbpw8Gl+AfWxW5hLW8
MGw/+AwwjHBOwong/QIDAQAB
-----END PUBLIC KEY-----

============================
Generating private key of 2048 bits...done
============================
Creating SPKAC using md4 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJGMxYWMzMzFlLTAzMWItNDNhNS1hMWY2LTg1NjQ1ZWVlOThlZTANBgkqhkiG9w0BAQMFAAOCAQEAVFvmwKgxjcmf2ckdDZgP8pJtwi3LZnBy9dSUCVZqAuwuZ8aTX++Sz/2/EyJmM45LOlLVFv/qnmGZEFyd0s+g0kN/ZyZDaDpd4BjKhnUrRiTPhvVfhhyRSAZDKFDjc8ZZDkDNXBXexTBHof3y+A8CKzi1D+wcrSwwfW95g6NAMDhZ5xbsc+od9sfQMM+7sN1D/xxuZ4Chm2FnNNWjErENOz4kNwcs0xU0Q3Gjt+nJr9HFbo7bdFVqKl8Tq1VwlZu1caMuBSKyTaXscYaial5ueWcRasTtHRYuqswthTvUzC5Ap8mrOrHjKE4x385hOrpYY1uGHj2RiVouiy6oui9aMA=="

done
============================
Verifying SPKAC with md4 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with md4 signature...
string(36) "c1ac331e-031b-43a5-a1f6-85645eee98ee"
bool(false)

done
============================
Exporting public key from SPKAC with md4 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using md5 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJGIyYTZlZDY5LWMwNjktNDgwNS1hMDYwLTIxMjAyZTBmMTlkNTANBgkqhkiG9w0BAQQFAAOCAQEADeHneffyM9PdSRm/RMSmNazAeSMxZzY+M8TxVrrtersZ2mg5MvBUaZcOV3fYGO/p3y7lI+ygn7qx8m8xTwOs82Ppl800NPfDmRkMqambN/ZxkT92sCG+KeCwuoACvUhEZn32GPRV1iu3AndUNbnsHwMAtXMvcFx0NJiyMLki4XtoD6U/D+xwtRFJoJrJNwPWoKbvrVng2T2c7rUoUsDSe85ZDmmEn9Hzw4dQuQGu0aWCe6rW5SjwhYvzYy+1AYXY+XQKv8uyQkPPJjHdG4ibMEYRcRqAC/TEEGEF0SbsuG3K0+sm9OcZnjs7utRwprjQqRaxmsRisD1oNsHL0TB2xg=="

done
============================
Verifying SPKAC with md5 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with md5 signature...
string(36) "b2a6ed69-c069-4805-a060-21202e0f19d5"
bool(false)

done
============================
Exporting public key from SPKAC with md5 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha1 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJGVjNTcyZTc5LWJjNGUtNGI3OS1iNGZjLWE2YjQ3OTc5MzBlZTANBgkqhkiG9w0BAQUFAAOCAQEAiuDJ7z8Qw/M4E++WZcuc0RfxKXgC7AQPadtKnI0YrPfOLHe3kFPjj8qDdWItS6XBNOS88NBeyn/MWUyzefetetmpGmRxnDtxmXKKEaPBJRJj7nc9+mxI6laf3F3J0p1EZxyKOgyWggx0BVIsyZNy6bHMJUE5cPXQtlp4wha9ismcFlMULJ1OBWe5xZToBPcHqW/Umw0oS1hSdU1B6r93QSgdgR6RnoeaKLKpz52riX2Qrdus8WBNHMPc9PU5kVo5gg0NduBoKFGDZVSlZLvoabD/eqirWH7q7CeJYJFPgoyXM+PRCkEvOsM4IuPRF1oNlgc6CjHfr9fUCCaPhQvFYA=="

done
============================
Verifying SPKAC with sha1 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha1 signature...
string(36) "ec572e79-bc4e-4b79-b4fc-a6b4797930ee"
bool(false)

done
============================
Exporting public key from SPKAC with sha1 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha224 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJDYyNzE1NDA1LTAzMTctNGQ5ZC04ZTY1LTdiYjhhYzk1NWJiYzANBgkqhkiG9w0BAQ4FAAOCAQEArPu8iRsO4yMhaEi8egenqbA8UrwbDujVvBsTlcP8ODLPb3WOyA4T4f0q6VJAGc3PZXYeIB3dg2L2ydsZLGYDIyX4ZszMSGzIU1iHAgaJiEXOZ0VPZ+HbdwLwJNCr9+D37XQ4JPzmzbEOp9BB9LtvNmuMWgsDaOUlwVzsufMP418lCTmEuO6MoiWHdttwavZaC6as3PZNdL9FzjGvGBHZmpSm/pmVhPhh+m1nzbZ7DxqTsjyRYC1PFAm4sybnLBT2gDrAR3Y+LQiQytO3hxHcq21EdLH8sjcouijmq7BWkH3MDzbAIKlbdjw4OsYODFlFJ5tcN+xY8qxd5OSXZuLwJQ=="

done
============================
Verifying SPKAC with sha224 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha224 signature...
string(36) "62715405-0317-4d9d-8e65-7bb8ac955bbc"
bool(false)

done
============================
Exporting public key from SPKAC with sha224 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha256 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJGIzNzUzMTA4LWMyMTgtNDBkNy1hMjY0LTE0NDc3NmM2NDVjZjANBgkqhkiG9w0BAQsFAAOCAQEAEjv//kS6PiYz9SAXvSYBHlswtSigNr1kS8tl6c9mOMPj1MOiXAwDC2u6qbrDCQ82OTZ5H9Q2Od2cRHbsFVmD3mkBvXVAmv1hzdc5NjRtFuzQ8kDhgSvoS9wI7UTfge+4n4zIjIWO/IDwAN4YlKYAJlp7Noj2k0f2vHAO0DS8arSp1q0912M9Jzar2x1wecBGMkgB2VzkXYSYvu1/DSAOWyb6D+U6NroAmTcoOzaipZ4ZuN3SjCkZvfXpO1yPhiElUOQu7VErull6ymcwRCIOc8SMTNXVHoMBiv2GTKfUyDhvRvFtEkMVVKJFvbZ8ROaa/cHWkgy2MgL/5tSgBbdhrQ=="

done
============================
Verifying SPKAC with sha256 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha256 signature...
string(36) "b3753108-c218-40d7-a264-144776c645cf"
bool(false)

done
============================
Exporting public key from SPKAC with sha256 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha384 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJDhlNDliOWJiLTc1MTAtNDU5ZS1iOWUwLTBlYTU5MTU1OWExZDANBgkqhkiG9w0BAQwFAAOCAQEAefNKOYPURaemFAO8GUUi1966S2+HP7fEgAPzv/Fny/19hTQHpP5rGWYFGq0kvAAVhCHldEFD6+eduzrDaMVIYLD8OMOX6h688tzP3Hsy1rShdi2VzsK0nyRdZQJuLZMxmDcdXrJVTqrCbT6Ivfmah1LGbltpBbYw/Lb83kYyHEcmEr1Qkt41uHlmB7oHAM60HR2BqPMil+Pl25sx3Is6WWdesK0dxEmzR2ap/77rI4uKINWJLcP+fb0Eo5p4360WqVi1YC2lnlEYGhnyketl/ZH0QC3l31Y6ZgRO+Vn/OeIdBayEIvrJJdsaRLqhMeTzvtTvJEovRDn8AbipOsnoDg=="

done
============================
Verifying SPKAC with sha384 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha384 signature...
string(36) "8e49b9bb-7510-459e-b9e0-0ea591559a1d"
bool(false)

done
============================
Exporting public key from SPKAC with sha384 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha512 signature and 2048 size key...
string(830) "SPKAC=MIICZDCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJGVhOGRkMjZmLTA0MTQtNGY2Yy05NGIzLTU5NjJhODBlYTc5ZDANBgkqhkiG9w0BAQ0FAAOCAQEAQCn+RvC/Ak78AOnO7YGEpqsmNO36p6cmiaxryyOcRRQbrkKRpjbjP/KkpWUELdlyVjkVnGTMIMMLxAfbvkVR+Pe3FWwfbKTs5oToVxo1NfH+h495ijS5u/PRBIDJtLnC5ggUo2hAQDppyNeyuh23oljT9+U3EDG9dDO1x01dSEUf003IqBxgLU59TOzs5+ouxISRqT7ww8DE57mWRKEQsnegKpgSka6dI7JcHFrDuV2cFN/Zha9Iyk9kE4Ox8saWa8rGZ7dL2GH4Q3PCZoTftruoyF9P7kF8qhZ8m2AfJL+6k8D2W7qRYL4LE/EmAQR9a4rN1Wd/xVlANevMrdqpnw=="

done
============================
Verifying SPKAC with sha512 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha512 signature...
string(36) "ea8dd26f-0414-4f6c-94b3-5962a80ea79d"
bool(false)

done
============================
Exporting public key from SPKAC with sha512 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Creating SPKAC using rmd160 signature and 2048 size key...
string(826) "SPKAC=MIICYTCCAUwwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDGUKiE6xqFCsreRygPVnt1ZODwUKaXxgp1mWNrkWNlvdwNK088nxevVndZea3JuPIkxfNJah7muZ9ueoI2iZm6xn9kYH2eQcUeaOcnWb64t9TjMYI+LbW+zeGfyYV6Wgq8m0ExhzQWIbi8flAJAsV8VUbk6fb1a/gdfq8Sx6WYu5ttuN6p3YT+h7gijw5bcmZIzUKfESOpiYSVnARfOjtQ6IJFB0FqK5CKdYP01ZPz8p5Kn35wOkbwusk81CgRWmZhs1WoRJOCm3eE/kR5ou/6ACWB3P55DGopxyVdYsaVyyZ/TPGt6Hn/gzLQ08vyLWge6qBkVXNlWAt+yW42HR9PAgMBAAEWJDlmY2RiNDk3LWM4NzItNGY1Ny1iYmJhLTEzNTVlY2I0M2I0NjAKBgYrJAMDAQIFAAOCAQEAmAJdpd1Wo8D7tkU0EF6hMVAmHl5smeMTX11Gp+fL0hlKtG3VZ8t8Hm5is8GAGfkxWp/cPkLNU8TcET31zT3Bwr4eL/lUXu9EuqMbMJORyx7zCAhNQ5Nb19kn99D5jmJ6vHQs3bLj8AcMf/KEj8SzN/5BXUY9ksKlaMIwDwFW+odVKAOwpUPK88DFaxaZ+mhhej4jxrt3f7uZsV5K7nNvkyhYwjtjsn5MyPe9slFEe3am2mA1eI/hnkj4KLNoK2uDgh3I7c+jKZtI2fyKrKKva2p31sYxx5ybnOPG1iSg8/B7Cy4/0U2cks0lrOdXCF+YRxEUn50xxh+AlCY1iVYb0g=="

done
============================
Verifying SPKAC with rmd160 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with rmd160 signature...
string(36) "9fcdb497-c872-4f57-bbba-1355ecb43b46"
bool(false)

done
============================
Exporting public key from SPKAC with rmd160 signature...

done
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxlCohOsahQrK3kcoD1Z7
dWTg8FCml8YKdZlja5FjZb3cDStPPJ8Xr1Z3WXmtybjyJMXzSWoe5rmfbnqCNomZ
usZ/ZGB9nkHFHmjnJ1m+uLfU4zGCPi21vs3hn8mFeloKvJtBMYc0FiG4vH5QCQLF
fFVG5On29Wv4HX6vEselmLubbbjeqd2E/oe4Io8OW3JmSM1CnxEjqYmElZwEXzo7
UOiCRQdBaiuQinWD9NWT8/KeSp9+cDpG8LrJPNQoEVpmYbNVqESTgpt3hP5EeaLv
+gAlgdz+eQxqKcclXWLGlcsmf0zxreh5/4My0NPL8i1oHuqgZFVzZVgLfsluNh0f
TwIDAQAB
-----END PUBLIC KEY-----

============================
Generating private key of 4096 bits...done
============================
Creating SPKAC using md4 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiQyMzE5MWI4Mi1hYjAzLTRiYjYtODBiOC0xYmUxNmE4NWY3MmIwDQYJKoZIhvcNAQEDBQADggIBAIIC/e5CQkMYbXsqsidrCLQ3+PG3nURUquBZFTVC0G7Yr3v7j7iZIA3lqdn9uklTHg+hPr5o0CAF4F9NFBGH9GfXmRk3yVjvoRUw4Kn1opE9jWonjv6Lrsy7QzbWaOJ8NmIcP6QJAASpAqwmb3StndYPAU6nhZvK1ApkTFt3oKm/379/CfIA96tp9VYg7Z4X31u7C3+PT25flpWTvyVEdYIfIbNYss+SJ5gkiGB5laHWRYyiPenAdzHcQU4NCShsJb149uKe894uQsjBlme2VTULs42nMYxWH5d+ECtrKApuWF7v7yMdaypz7wskI019UytIjcFkcleG1zf2KyyUAgt4feT4zVrERcPcnu/rHaIVZ2FVwnVag8L8Dj049d+pW1xiA4zAAZ1n7Yh2p+nrd9pqsdn53A1etS3Bs0YkIHTdjc8NuD2RVFuqvzV8nyQbrsxm6jDsenMzG4BAK33AugnjzdEB1CY0hYK4miV4YFIgbkcKX26HKckHi6BIZYk61pyrDwrt62Cwbe89m68ape4VuOoTtuy///6d414DdyluPjtRHoQ75Pp3Ilpv54WXh4TesLRDnDmZcQ3at4DuHZvZMtFW5+2v2Tp6rmUM8TuT2Jb8AwF1t38Z7UU8HfDYXWhlT5rB9UtrMXyDVIBsDJW6/gai4yxWE+SPpLhFaPeZ"

done
============================
Verifying SPKAC with md4 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with md4 signature...
string(36) "23191b82-ab03-4bb6-80b8-1be16a85f72b"
bool(false)

done
============================
Exporting public key from SPKAC with md4 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using md5 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiQ5ZWI1MjFmMi0wYTFmLTRmNTgtOGE1ZS1jYTMxOGI4Zjk0ZTIwDQYJKoZIhvcNAQEEBQADggIBAJJJux48/uB2f9ef4lKtcz0Nn9gVfWfo5KZmThVu9MEpPGI/awHrpWA7Det1H4v1oducIUHqBKdufU9OHeYxQ8RZMan5+Da6uaBjn1dYcpQdCHstjtiJgSIxxGU7Gv4icdrJ0M4vBQ96x5dWZk24cCeL4CEqpK/UDd60cO2yk2EpFvlmws5jkJByM2EIqg19Zp5oOvixGybfxG06KMwwrZ+r3t1UgBgsiUX6P6ZLgTWqcv/TsAK4m8XO6AcxnuyU62a6f0xza+C/gvomiT/8/ZSVQh7vdDxl2QeGW75qVN7Gh9zjnnSLt8YcyeHz8YFNlrjMLGd6M2soafnUDE/PUszxqp3DrU43cbLxqOMRJBiotyR//4d0y8N3LpisI2VbN2HEX3IkdRzqVgGasOBeyBi9RUrUp7jP/84j/aBseGmaDpOZbcysLuS00s+N+JluuK4vBtMOMm6AdBZg5AWQoD+EvJsG/JHoEtx1+Tm5DsaBIm1E1IsMgRrgqvyBzIVr/Nwt+UoLNhMzKGR9PKb0gjBMld7fsHprkiurhPr5klM/+QVR1Mo/fhb1EeMwZz4se1xQ/o+hLp7I0/x7jWiYk06XlbvQj5kl/+MZA4ESBhgo1alQ2u+ecf6oEh7l2tCP08vRSIs2JcOMY5z0a16yWOrOaPION+UioRtgrMkfKyA8"

done
============================
Verifying SPKAC with md5 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with md5 signature...
string(36) "9eb521f2-0a1f-4f58-8a5e-ca318b8f94e2"
bool(false)

done
============================
Exporting public key from SPKAC with md5 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha1 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiRiYTBkNjhmMS04N2NlLTQ5OTUtODE3OS03MzczM2MyZjJlNjEwDQYJKoZIhvcNAQEFBQADggIBAL9pHr92a0OIzQRrsovVSX99gvOhkNTgDigIaxVCLR304HUyYLooRxiycYeu2yE+j66BbuC9B0W8SrkrWWAyh3/7t8Y8pYSJzItLXTzWzwWWClI15rmSl71iHJQ4hc1mY+418J39FQKfzCFAyrYwAZJ6eWSes8CYcxK9AlEbEJ4LJ+S7yJV2vIHgivXiE/pnkTkjbFg3yU2mD3cndXAHyCJwD3qKyF9ptaneC9urX3St9ZY67p8XpkJPTqGoE9LXXO75VxFIf6nAVPYwqTkEZUn8djPClMhiSjvDPirP0O/lcVWmhU+JmRzw7aQpDYew8pUyux36PCdmDCeSThgbKKd9+w1yQ/lmggXTUkxMaqCzs6K8st1V9cGykSHZEqq4yenMzqjAFlgHT01IzS+n6o0+buj9B7+3WjSgq+6EVy31fWDW3YQbw64vDkUnvxhcVDtI8SbiqcOn4SKIK0OZbE4Urx7r91gIca/cx9Bik3Wu2M6k6E796OPQvuMKqFwgXk9FJFsQ9ffMdoJpza3UwoDPL9znf2M26MhXzLKHtddb78eoTY6HP72f6tl+rGCe4dCj6Y46Q1HyF4GdCWx/ljuobJau1/rzzAcOF9ZaCJZR/6zkkUuYCh1I9OSJn58EGDMAb3duNlnZ+DNZtd0J3qPXexCAxE70Q5j+qWDAWMTY"

done
============================
Verifying SPKAC with sha1 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha1 signature...
string(36) "ba0d68f1-87ce-4995-8179-73733c2f2e61"
bool(false)

done
============================
Exporting public key from SPKAC with sha1 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha224 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiRhZDg2ZjkzOS1iZDlhLTQzMGItOWQ2MS04MGQ2NTI0NzMwMDcwDQYJKoZIhvcNAQEOBQADggIBACEO5mq2bUiJV27Sw/b2lCbfqa9SHbU0nprk7cJed1JBFs1cS5cBGHtSU/bWF2xIiyU+jkVFf4jk+KGRiqu4+kdpLTbdy1eVThIsDSit7isscS4rtIRkoVrnBAmn1aJ9d1i1xTZVT4zjPydlKNNXVysqnPxgjDaxMRKk8WPafijK9PVJjX4lpXUIGS0gB3mL94Po7cvoLvlSVSM0rZxgHs4RCr/FRRQGBiCcPfKcyYWrcSL232ejP8SSaaGvOMkCy4acaBxKYOlwtxlp7bIXI5N2t5KnpgAewe3T35Piwy7BR+UkwgLMrAQRpupjXXB7q9gP+QSKZgcqIMBLov/Shg+NNlCqZnMPjhNO4ArWfHJbCQL7iQhpcBDXSmyJ3gkn2OfCLpaUqMGz5MfsZAoZQ1y0gZ1sFgR/WoycZeBW6kGdIYSur932dRwPYwOkt9WFu3GNiqqu5Rh9LamYMl5Ezc24ItzXfvKE+rvxSV2CfjeHGSvORhtgbJv39auL+3zVh7reKuhT74qRv797s2170XyZPZeJui6TCBxXafP7IxvygE9DprHu5TRnjtn+d/CnGJYZdviDNchZo/G0aLgbkhUQ56XajmgiIRD/yzVlb9246PsPhfpYkqAC3R1RiNgMaDsKCkOVlJ5DtEB+OLXbn1zZ1ksT0aHFIwpDDF9ADmbu"

done
============================
Verifying SPKAC with sha224 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha224 signature...
string(36) "ad86f939-bd9a-430b-9d61-80d652473007"
bool(false)

done
============================
Exporting public key from SPKAC with sha224 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha256 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiQ0ZGYwZGViNC03NWY5LTRiY2QtOTNiYi00Yjg3NWE0ZTI4ZGMwDQYJKoZIhvcNAQELBQADggIBAI89JU/5UPTvTIRc1DZJIOX/NJwQj3STqKfThN947vUgauj+0bB3rqBRo8AMyIRy4vdRm66qmA+3PLEDLtFFzTCxXP1mjYQ5KPM8IX+Chz68rkaE0ia58/tg55TyuMENJmYAjG+1IxeLTzesqRwI5P8ut/rZpu9TY795U5J4LHSUFuZWQn+VbN+hKyt3liIZSDEgEE4dTWSj2n8m4cqpRZaSbZw9uYKcylMfaIAr+Nl8i4l3WMyG1sIaCY/wz7yP0rPxg2Yazh5ksfRTuKo8K37cNfWG7Vsnfl5YI6w/9Dz49dGH0IeXl78mLbwdPVD/F0pJA37/iXW35hcj4QSp6wd6XdUJEN1GOk4qR8RTGm3W2Cw5o4g37efGa/CMeLWXBdYPgOeilh5BSL+9BtnQdqOxYvQFSuQiKoZf+A5udlaOb+5B6MnvE05oblvvYtsvqq+4/UCzztjsPhJKeTMzVX55wq4u/uqt0tJ8FYQp9MKpP72k5IdMrAlM8HdClZl6OC96PwLaehKLiRdBxhWZC7JZQ9jIaV55EHqAfxBqahrzw7fGEariWhAVkWXgEml/SlGqSCtQUqY6qge/SlvIIls5GR0ZxWiKNQtn2gSE4B+jspKyAHVFRu73bxpW7N/fI8PrPotlWfEjxdAg5Mo1bphyQH1/3jA8xzh2wvS8gEuE"

done
============================
Verifying SPKAC with sha256 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha256 signature...
string(36) "4df0deb4-75f9-4bcd-93bb-4b875a4e28dc"
bool(false)

done
============================
Exporting public key from SPKAC with sha256 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha384 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiQxMzEzZjI2Ny05NmE0LTQ5YzEtODQ4NS1iYjg4OGY5YTM2MmIwDQYJKoZIhvcNAQEMBQADggIBACWK6+9JShRHqJNRaMrQZxLMXXEiyXTAZAbTUvWWHupF6iGjC0St4BX253u2kuAr02v95Z4K2jerREjBsGbhR0pFjGpriExE5FnSooOJigvT+D6gv1Khaz56VWzcgYZDQQN2XwKCrHr/YdmDr/Sd9cdgRJ9fnJVNu9LRpE9W6BBEUJn8P3ThHf1tJHCxZqo5H7qoIB+gNZwWL5yoJ1sl4RXcdjyJ6Neza3pQ6tV6tqWn4yh65VqF+yVLMq7ycCX8vpoU16QalBkbqVUX0ap7Z4cx7U3bXCYr+lCji0VhrTSuyc4G1EL3jxf4TMjfsVJpsKR+hOhzrZNKPL1k+U59Whtc0jWFPPXY7dJEDng8+7veYu2pczBzaEvyYVHOuQl49SlaM9vFoplyADdET9Fgv0/nUm5uBNyrROlXNd7XOOzYp8Axepbq54Fs9t2EHJCcHENjHzzMgaAfjFI0ar0yBRtvhgyV7/Vw18xkTjvHZILSWA/FkKhtGD1qND6Nc5wJ/0f+B35cCTcfmO8E/vXMkfAgacgS/Q0ljkejJ/NnYm5rR5W+gAqXciE42ZWRbXH2mlAhFZu/+eGg7Rtozlgxx5qWRBCfSNTd0Srn/u2+yPAL89XKAGPjgyaXNsqR82eTiLGRNt9U0S6ob1NkfwqQ4ioO6RgDKIrz2XJ94rHdlFeQ"

done
============================
Verifying SPKAC with sha384 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha384 signature...
string(36) "1313f267-96a4-49c1-8485-bb888f9a362b"
bool(false)

done
============================
Exporting public key from SPKAC with sha384 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using sha512 signature and 4096 size key...
string(1510) "SPKAC=MIIEZDCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiQ3ODdmYjc2ZC01NWViLTQzOWYtYjg0Ni1hZDY1ZDFjYmY5YjkwDQYJKoZIhvcNAQENBQADggIBAKTkLUiwz+VeX2OkD/YzleHVDrh3BzCXwUBtVUueDgP5/BPfAF7/p7uMZ2kM4Eg48cI9XrymIcp3I4mVa488p5M0iA+0Nx67YAhCvzed57G0vVRlb6ZM5hIduy8WCcGaxRUm7Wv8tYS2pcsPm2zTh//uWbofTcvx0otQQc6XSdhD4+4qM+Ad4neTzqFngDYsZavDPWFsYN6oODh17i3ByAnA8oVTfjSj6eYs32tAEHh5Gag+H1ebFh4QuxORUno0PpJ4sfY5l10bH6vu/j/RlXSYgHHNp2E2cjJl81Copy8J8zyYBr+kpwQRqbxiabrFtqZYFiVj87BEVSoFQMjZACPs8Ff8sGAHbuWDHzjKsZd3zsbpb2Tz5cGmvyfqc2b4xhnUHQ5T2w64kB4ZR9L03LmE5EPxSaFMayZZC/B7IJanbcaLEl5j5ce1Dn6ToeYCV65JP7ZJc7+/dNT5tU+znt2/m04vk9Vq14dhJ5d4nrXU5IkxG1dSWiyDd0Q+LW77pbf5+v4wdlBRWgoOkPGSAIztrtv0iLjBEA8mesefz7Wlkka0g865eetuIlDpjYwOPmlu+7xnstKlC5gB7V3e2gGPDX8UrGsNf0/2G+O/0K0+kPxx9WDUuWtUGRNYd+Ny1ljY4RPHBiKmPKiCJyfoUWw4j2TDbxcmCZhxEfkmXmKC"

done
============================
Verifying SPKAC with sha512 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with sha512 signature...
string(36) "787fb76d-55eb-439f-b846-ad65d1cbf9b9"
bool(false)

done
============================
Exporting public key from SPKAC with sha512 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
Creating SPKAC using rmd160 signature and 4096 size key...
string(1506) "SPKAC=MIIEYTCCAkwwggIiMA0GCSqGSIb3DQEBAQUAA4ICDwAwggIKAoICAQDIY5P5YLslXFx62YGZRHfqhVEGTT4xvvJbcjT+SY0tfVl6vWI9bB1jWxMfRkuKewCLl5AeXIYmOXOdIFHTYyHFpKaBxRrDC87GLWvPkvJtspWySM5S55FpDRugKIFGTTLc3IUIZfEC5mG/F2mxzZ7cThgI99vVBlwKngvPEO4ihhNwaEfcVf3+eiQ+pfh5Uqx1n27Xj/Da5yBIyvKAqR8MHtfuhflTjqgzk7wGMi0nD/FvGsiVLEu9b3/3pnjWYOTkOsTQibPXWgAZyFRVSblt+KUW59R39Hf284rnbL0FPkhDn8Z+u2B9uYbiWoL4cuPpk3isfK/tuR5a5rME/lVwoStlncwhxJoMwiBWM/ItZBoWrm5e1ZbQRx80r7QBhl90v/oGUhM4RNuUCXGbBtJQ7Jy6edl+wnC6HQvj5KzdpK0pCMGRsIgko5G7T1rVkxpQxIjSBkps4Ijjf5TiGsTwJRQKimJWnbUHY0x+bpLaczLgHmjAIXO/5xerlNPm2CzTfyAoWcNAgohc7dn7nFBwwqy2WWRa6empXleGG6e48skenKPU99IIigGLF/xRtyplDdoPBn6xhvqLE7K8e1NiHQK+Bgby2vEVVM4PNQo9xGpfTdhN91DkvbOivOTY/G16W5Lb6EJwFuvbYeX7+hMDR5nD47DGAnvkNWV1n4zrDQIDAQABFiQ2NWU0YTRmYi1iMzAzLTQwMTMtOGFkYS0xN2NlOWE3MWUzMmUwCgYGKyQDAwECBQADggIBACrIQrhwBin9Pf6wMkc9m+y8o2/7f/4hBl2wQktcmCAyE4eBc1tXmKoYtkwsRhtm/J1lOSZv6KU+c3nDSpOZeL9oc1EAKC6eQ3YUmxlQ/BjOQRuPkC88WZcg2d7o6Xat8skrBWAEQ5LMpaVJirscsuYNloD31PmYasr3995iCX14v1jUEleWeOOiDnpB+KH7iig7HBPYFJ4QDXJVuFxq4N52cyRd4moDaMiq+nj/0UO+WPNHYObh97u2c3Scrf+Q/nGw4opyi7Oxr7e0Zy8q0Isw5ka9NwVxiSbKfi3m21g8X4zBn5+x6DuPj7+BnqqXsm8Q72FiGFneFx4LagbbVMSgBspvEOopCIxdicyU+nHR35QCWGlQ7eFk2Fmn+oOqBTwSPXKf9ehQIhuCNYgxbaHTGbFBWrdm/ap5jq66IroiOMZaZJ1Jo2kfSc+LEPuVeB1Am7c6KD6Dw8dWeDCbygwa8EbFR63S47tYlUWB+M1FgCOr62eh/iMgcyJCHvRjuKhz7ef+KH00jiBwCsBRQidjkmGrzB/sxeO3/s3O69NSsBMe3+e97eL1LgEUufPQzU6lCT/+AJbKKnkgQQJMTRCywUgiqxu4AG5ZcsgDhCmVUBgH8t7fHYfdLSTaJI3U7uN3H2QxHhBqOwJSr0vccyrMjNSyyp/VVXApOzGMsrOG"

done
============================
Verifying SPKAC with rmd160 signature...
bool(true)
bool(false)

done

============================
Exporting challenge from SPKAC with rmd160 signature...
string(36) "65e4a4fb-b303-4013-8ada-17ce9a71e32e"
bool(false)

done
============================
Exporting public key from SPKAC with rmd160 signature...

done
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAyGOT+WC7JVxcetmBmUR3
6oVRBk0+Mb7yW3I0/kmNLX1Zer1iPWwdY1sTH0ZLinsAi5eQHlyGJjlznSBR02Mh
xaSmgcUawwvOxi1rz5LybbKVskjOUueRaQ0boCiBRk0y3NyFCGXxAuZhvxdpsc2e
3E4YCPfb1QZcCp4LzxDuIoYTcGhH3FX9/nokPqX4eVKsdZ9u14/w2ucgSMrygKkf
DB7X7oX5U46oM5O8BjItJw/xbxrIlSxLvW9/96Z41mDk5DrE0Imz11oAGchUVUm5
bfilFufUd/R39vOK52y9BT5IQ5/GfrtgfbmG4lqC+HLj6ZN4rHyv7bkeWuazBP5V
cKErZZ3MIcSaDMIgVjPyLWQaFq5uXtWW0EcfNK+0AYZfdL/6BlITOETblAlxmwbS
UOycunnZfsJwuh0L4+Ss3aStKQjBkbCIJKORu09a1ZMaUMSI0gZKbOCI43+U4hrE
8CUUCopiVp21B2NMfm6S2nMy4B5owCFzv+cXq5TT5tgs038gKFnDQIKIXO3Z+5xQ
cMKstllkWunpqV5XhhunuPLJHpyj1PfSCIoBixf8UbcqZQ3aDwZ+sYb6ixOyvHtT
Yh0CvgYG8trxFVTODzUKPcRqX03YTfdQ5L2zorzk2PxteluS2+hCcBbr22Hl+/oT
A0eZw+OwxgJ75DVldZ+M6w0CAwEAAQ==
-----END PUBLIC KEY-----

============================
```

Please report any bugs using the issue tracker here. Thanks.
