# php-crypt

How to using:

**Calling to class**
```
$crypt = new Crypt;
```

**Create a text**
```
$text = "Hello World!"
```

**Crypt the text**
```
$crypted = $crypt->_crypt($text);
```

**Decrypt the crypted value**
```
$decrypted = $crypt->_decrypt($crypted);
```

**For password**
```
$password = $crypt->password($text);
```
