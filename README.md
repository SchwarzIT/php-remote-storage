<div align="center">
  <img src="docs/php.png" width="240px" alt="aino" />
  <h2>A Minimal PHP Remote Storage Library</h2>
  <p>Manage the remote files with minimal dependency</p>

  <p>
    <a href="#">
      <img src="https://img.shields.io/badge/PRs-Welcome-brightgreen.svg?style=flat-square" alt="PRs Welcome">
    </a>
    <a href="#">
      <img src="https://img.shields.io/badge/SIT-ChapterPhp-blue.svg?style=flat-square" alt="chapter-php">
    </a>
    
  </p>
</div>

---

## Supported Remote Storage

the following remote storage are supported in this library:
- `AWS S3 Bucket` ✅
- `SFTP file server` 🛠 


<div align="center">
  <img src="docs/s3-php.png" width="840px" alt="aino" />
</div>

> I used the `MinIO` docker instead of AWS S3 for local testing


<div align="center">
  <img src="docs/minio.png" width="840px" alt="aino" />
</div>

> Symfony + AWS S3 Demo: List, download, delete, upload file object in Symfony5 Demo


# Install
```bash
git clone https://github.com/SchwarzIT/php-remote-storage.git storage && cd storage
make install
```

# Run Tests
```bash
make test 
```


> http://localhost:9001/ for `MinIO` bucket (the credentials are test data for local env.)
> - Access-Key: `I3uWTHZGke8RWa1j` 
> - secret-Key: `G0OC3OYQ5Qw59z61`


## Use the `S3Adapter` in pure PHP
```php
// instantiate S3 File system
$S3Adapter = new S3Adapter($s3Client, self::TEST_S3_BUCKET);

// upload a test file
$S3Adapter->save($pngFile);

// delete a test file
$S3Adapter->delete($pdfFile);

// load a test file
$S3Adapter->get($pdfFile);

// @more info see S3AdapterTest.php
```

## Use the `S3Adapter` in Symfony Project

config the `AWS S3 Client` and `S3Adapter`
```yaml
## config/packages/s3.yaml
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

    Chapterphp\Storage\RemoteStorageInterface: '@Chapterphp\Storage\S3Adapter'
```

config the services for the package ``
```yaml
### config/services.yaml
services:
    Chapterphp\Storage\S3Adapter:
        arguments:
            $s3Bucket: '%env(S3_BUCKET)%'
```

## licence

[apache-2.0](https://choosealicense.com/licenses/apache-2.0/) [xun.zhou@mail.schwarz](https://vikbert.github.io/)
