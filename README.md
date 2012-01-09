
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

### Verifying an existing SPKAC
  Returns boolean true/false value

```php
openssl_spki_verify($spkac);
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

Once it is installed you can use either test case provided to test.

Author: Jason Gerfen <jason.gerfen@gmail.com>
License: GPL (see LICENSE)
