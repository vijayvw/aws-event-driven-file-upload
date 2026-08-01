<?php
/**
 * upload.php
 * ------------------------------------------------------------
 * Uploads a file from the web form to Amazon S3.
 *
 * Requirements:
 * - EC2 instance with an IAM Role that allows:
 *     s3:PutObject
 *     s3:GetObject
 *     s3:ListBucket
 * - Apache
 * - PHP
 * - AWS SDK for PHP
 *
 * Install on EC2:
 * composer install
 *
 * Environment Variables (set by Apache):
 * S3_BUCKET
 * AWS_REGION
 * ------------------------------------------------------------
 */

require __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$bucket = getenv('S3_BUCKET');
$region = getenv('AWS_REGION') ?: 'us-east-1';

if (!$bucket) {
    die("<h3 style='color:red'>S3_BUCKET environment variable is not configured.</h3>");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

if (!isset($_FILES['fileToUpload'])) {
    die("<h3 style='color:red'>No file selected.</h3>");
}

$file = $_FILES['fileToUpload'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    die("<h3 style='color:red'>Upload Error: {$file['error']}</h3>");
}

$maxSize = 10 * 1024 * 1024;

if ($file['size'] > $maxSize) {
    die("<h3 style='color:red'>File size exceeds 10 MB.</h3>");
}

$tmpPath = $file['tmp_name'];

$fileType = mime_content_type($tmpPath);

$allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'application/pdf',
    'text/plain',
    'application/zip'
];

if (!in_array($fileType, $allowedTypes)) {
    die("<h3 style='color:red'>Unsupported file type.</h3>");
}

$originalName = basename($file['name']);

$key = date('YmdHis') . "-" . uniqid() . "-" . preg_replace(
    "/[^A-Za-z0-9._-]/",
    "_",
    $originalName
);

$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => $region
]);

try {

    $result = $s3Client->putObject([
        'Bucket'      => $bucket,
        'Key'         => $key,
        'SourceFile'  => $tmpPath,
        'ContentType' => $fileType,

        'Metadata' => [
            'uploaded-by'   => 'terraform-ec2',
            'original-name' => $originalName,
            'upload-time'   => date('c')
        ]
    ]);

    header('Content-Type: application/json');

    echo json_encode([
        "success" => true,
        "message" => "File uploaded successfully!",
        "file"    => $originalName,
        "size"    => round($file['size'] / 1024, 2) . " KB",
        "bucket"  => $bucket,
        "url"     => $result['ObjectURL']
    ]);

    exit;

} catch (AwsException $e) {

    http_response_code(500);

    header('Content-Type: application/json');

    echo json_encode([
        "success" => false,
        "message" => $e->getAwsErrorMessage() ?: $e->getMessage()
    ]);

    exit;

}
