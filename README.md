
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
* Print formatted details of SPKAC

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
openssl_spki_new($private_key, $challenge, 'md5');
```

### Creating new SPKAC using sha1 signature
  Returns SPKAC string

```php
openssl_spki_new($private_key, $challenge, 'sha1');
```

### Creating new SPKAC using sha512 signature
  Returns SPKAC string

```php
openssl_spki_new($private_key, $challgen, 'sha512');
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

## SPKAC details
  This next function may be unnecessary but will provide a formatted copy of the
  details of the SPKAC (the signature algorithm, the associated challenge string,
  the public key modulus etc.)

### Providing details of SPKAC

```php
openssl_spki_details($spkac);
```

## INSTALLATION:
* Download & install latest OpenSSL stable (0.9.8x or 1.0.x)
* Download & install latest PHP stable (5.3.x)
* Clone this repo into root of extracted PHP source code
* Run these commands:

```
%> patch -p0 < 12.28.2012-spki.patch
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
  Here are the output examples if you would like to know what type of information
  you can retrieve from a signed public key and challenge.

### A signed public key and challenge string

```php
SPKAC=MIICRzCCAS8wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDkehFnCJLB2cdqQCVdpaK/0pWVXSCJy+fEypQGGbOyG2ufHNdgU4CVwlgJn+pvr0Yk4txALP2W5OJOUcVVYHCdT52nerm2U4BrWD5TYOTHgbH5y33yro8bsEYDK+mp8xQlfBfIse8P1899hJ6t1mt0VWHPC3P6IxaE2j7CDJJ8p0J1JqfzqkOpy1hCw9sjQQOlMk6oBGqOwnCtqsjBczYiq/Tr/UCGfIzJoBdBap+ez/RR/o4qYF3h1iAGLmQ8FNpIZdFWi3iwts/Kjk+UC4ZMuiqDy+3JEXfrzm7y6YEUhFkSIScPZ9h4Z/99wpzsAwj9XF/yT6qzQhdxdbCGqprFAgMBAAEWB3d0ZmQwMGQwDQYJKoZIhvcNAQENBQADggEBAH5SWT6AyVuhdjVmJr0GkdU18jS6TBNt3lyp8Zh1Mc/99TGzKxOtaP02v9JZcvX4PnWV0XBiqUQjdl7exFkP3IudVp6OyxwpA7e/y94U9WVOwMr6U9qTSlQ3rozNNO01lrl++yc/RTEGmV/UDiImeAALhh7FfDrbgDQcjttmk8LbIfy11aMmzmtk01juWDnjInHFgNvkrcnfsKl9ejau0Vhn2W0NOplZC+nE8rdHStt/m6Bc6E66XF7T5E3v/mZFR8bihCPy0a0ujYj3cf1Ak+ySGanobqJ3SC3aqY+3fUiUZDOFwwUQ56oK79jV5lcb6LW3JLcBi7xxSu2IQntfwes=
```

### Extracting the associated public key

```php
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5HoRZwiSwdnHakAlXaWi
v9KVlV0gicvnxMqUBhmzshtrnxzXYFOAlcJYCZ/qb69GJOLcQCz9luTiTlHFVWBw
nU+dp3q5tlOAa1g+U2Dkx4Gx+ct98q6PG7BGAyvpqfMUJXwXyLHvD9fPfYSerdZr
dFVhzwtz+iMWhNo+wgySfKdCdSan86pDqctYQsPbI0EDpTJOqARqjsJwrarIwXM2
Iqv06/1AhnyMyaAXQWqfns/0Uf6OKmBd4dYgBi5kPBTaSGXRVot4sLbPyo5PlAuG
TLoqg8vtyRF3685u8umBFIRZEiEnD2fYeGf/fcKc7AMI/Vxf8k+qs0IXcXWwhqqa
xQIDAQAB
-----END PUBLIC KEY-----
```

### Providing details of the SPKAC

```php
Netscape SPKI:
  Public Key Algorithm: rsaEncryption
  RSA Public Key: (2048 bit)
  Modulus (2048 bit):
      00:e4:7a:11:67:08:92:c1:d9:c7:6a:40:25:5d:a5:
      a2:bf:d2:95:95:5d:20:89:cb:e7:c4:ca:94:06:19:
      b3:b2:1b:6b:9f:1c:d7:60:53:80:95:c2:58:09:9f:
      ea:6f:af:46:24:e2:dc:40:2c:fd:96:e4:e2:4e:51:
      c5:55:60:70:9d:4f:9d:a7:7a:b9:b6:53:80:6b:58:
      3e:53:60:e4:c7:81:b1:f9:cb:7d:f2:ae:8f:1b:b0:
      46:03:2b:e9:a9:f3:14:25:7c:17:c8:b1:ef:0f:d7:
      cf:7d:84:9e:ad:d6:6b:74:55:61:cf:0b:73:fa:23:
      16:84:da:3e:c2:0c:92:7c:a7:42:75:26:a7:f3:aa:
      43:a9:cb:58:42:c3:db:23:41:03:a5:32:4e:a8:04:
      6a:8e:c2:70:ad:aa:c8:c1:73:36:22:ab:f4:eb:fd:
      40:86:7c:8c:c9:a0:17:41:6a:9f:9e:cf:f4:51:fe:
      8e:2a:60:5d:e1:d6:20:06:2e:64:3c:14:da:48:65:
      d1:56:8b:78:b0:b6:cf:ca:8e:4f:94:0b:86:4c:ba:
      2a:83:cb:ed:c9:11:77:eb:ce:6e:f2:e9:81:14:84:
      59:12:21:27:0f:67:d8:78:67:ff:7d:c2:9c:ec:03:
      08:fd:5c:5f:f2:4f:aa:b3:42:17:71:75:b0:86:aa:
      9a:c5
  Exponent: 65537 (0x10001)
  Challenge String: wtfd00d
  Signature Algorithm: sha512WithRSAEncryption
      7e:52:59:3e:80:c9:5b:a1:76:35:66:26:bd:06:91:d5:35:f2:
      34:ba:4c:13:6d:de:5c:a9:f1:98:75:31:cf:fd:f5:31:b3:2b:
      13:ad:68:fd:36:bf:d2:59:72:f5:f8:3e:75:95:d1:70:62:a9:
      44:23:76:5e:de:c4:59:0f:dc:8b:9d:56:9e:8e:cb:1c:29:03:
      b7:bf:cb:de:14:f5:65:4e:c0:ca:fa:53:da:93:4a:54:37:ae:
      8c:cd:34:ed:35:96:b9:7e:fb:27:3f:45:31:06:99:5f:d4:0e:
      22:26:78:00:0b:86:1e:c5:7c:3a:db:80:34:1c:8e:db:66:93:
      c2:db:21:fc:b5:d5:a3:26:ce:6b:64:d3:58:ee:58:39:e3:22:
      71:c5:80:db:e4:ad:c9:df:b0:a9:7d:7a:36:ae:d1:58:67:d9:
      6d:0d:3a:99:59:0b:e9:c4:f2:b7:47:4a:db:7f:9b:a0:5c:e8:
      4e:ba:5c:5e:d3:e4:4d:ef:fe:66:45:47:c6:e2:84:23:f2:d1:
      ad:2e:8d:88:f7:71:fd:40:93:ec:92:19:a9:e8:6e:a2:77:48:
      2d:da:a9:8f:b7:7d:48:94:64:33:85:c3:05:10:e7:aa:0a:ef:
      d8:d5:e6:57:1b:e8:b5:b7:24:b7:01:8b:bc:71:4a:ed:88:42:
      7b:5f:c1:eb
```

Please report any bugs using the issue tracker here. Thanks.
