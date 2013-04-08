
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

Please report any bugs using the issue tracker here. Thanks.
