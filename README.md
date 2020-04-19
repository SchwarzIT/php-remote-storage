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

## 

<div align="center">
  <img src="./docs/minio.png" width="840px" alt="aino" />
  <span>I used the `MinIO` docker instead of AWS S3 for local testing</span>
</div>


<div align="center">
  <img src="./docs/symfony-demo.png" width="840px" alt="aino" />
  <span>List, download, delete, upload file object in Symfony5 Demo</span>
</div>



# Start
```bash
git clone git@github.com:SchwarzIT/php-filesystem.git && cd php-filesystem
make install
make start
```

> http://localhost:9001/ for `MinIO` bucket
> - Access-Key: `I3uWTHZGke8RWa1j` 
> - secret-Key: `G0OC3OYQ5Qw59z61`


> https://127.0.0.1:8000/ for `Symfony demo App`


# Stop
```bash
make stop
```

# Test
```bash
make test
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

## Use the `S3FileSystem` in Symfony Project
```yaml
services:
    Aws\S3\S3Client:
        arguments:
            -   region: '%env(S3_REGION)%'
                endpoint: '%env(S3_ENDPOINT)%'
                version: '2006-03-01'
                use_path_style_endpoint: true
                credentials:
                    key: '%env(S3_ACCESS_KEY)%'
                    secret: '%env(S3_ACCESS_SECRET)%'

    Chapterphp\FileSystem\FileSystemInterface: '@Chapterphp\FileSystem\S3FileSystem'

```

## Open Todos:
- [✅] implement Symfony 5 Demo with AWS S3 Integraiton
    - list files
    - download file
    - delete file
    - upload file
- [🔥] update the README: how to config S3 client + S3FileSystem
- [🔥] complete the unit tests

## licence

MIT [@vikbert](https://vikbert.github.io/)
