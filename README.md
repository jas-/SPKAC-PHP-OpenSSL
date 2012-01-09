
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
