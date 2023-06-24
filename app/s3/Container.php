<?php

namespace app\s3;

use Aws\S3\S3Client;

class Container
{
    public static function getS3Client(): S3Client
    {
        $config = self::getS3Config();
        return new S3Client([
            'version' => $config->getVersion(),
            'region' => $config->getRegion(),
            'endpoint' => $config->getEndpoint(),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $config->getKey(),
                'secret' => $config->getSecret(),
            ],
        ]);
    }

    public static function getS3Config(): S3ClientConfig
    {
        $config = require __DIR__ . "/../config/s3_conifg.php";
        return new S3ClientConfig(
            $config['S3_BUCKET'],
            $config['S3_ENDPOINT'],
            $config['S3_REGION'],
            $config['S3_KEY'],
            $config['S3_SECRET'],
            $config['S3_VERSION']
        );
    }

    public static function getFileUploader(): FileUploader
    {
        return self::getS3FileUploader();
    }

    public static function getS3FileUploader(): S3FileUploader
    {
        return new S3FileUploader(self::getS3Client(),self::getS3Config());
    }
}