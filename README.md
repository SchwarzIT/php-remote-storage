<div align="center">
  <img src="./docs/s3-php.png" width="540px" alt="aino" />
  <h2>A Filesystem Wrapper for AWS S3</h2>
  <p>Manage the remote files on AWS S3 simple as possible</p>

  <p>
    <a href="#">
      <img src="https://img.shields.io/badge/PRs-Welcome-brightgreen.svg?style=flat-square" alt="PRs Welcome">
    </a>
    <a href="#">
      <img src="https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square" alt="MIT License">
    </a>
  </p>
</div>

---

## Install
```bash
composer install --no-interaction --dev
```

## Update
```bash
composer update 
```

## Test
```bash
composer tests 
```

## Use the `S3FileSystem` in pure PHP
```php
// instantiate S3 File system
$s3FileSystem = new S3FileSystem($s3Client, self::TEST_S3_BUCKET);

// upload a test file
$s3FileSystem->save($pngFile);

// delete a test file
$s3FileSystem->delete($pdfFile);

// load a test file
$s3FileSystem->get($pdfFile);

// more info see S3FileSystemTest.php
```


## licence

MIT [@vikbert](https://vikbert.github.io/)
