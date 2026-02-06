<?php
require 'vendor/autoload.php';
use Aws\S3\S3Client;

if (!function_exists('get_s3_client')) {
    function get_s3_client() {
        $CI =& get_instance();
        $CI->load->config('aws');
        
        return new S3Client([
            'version'     => 'latest',
            'region'      => $CI->config->item('aws_region'),
            'credentials' => [
                'key'    => $CI->config->item('aws_access_key'),
                'secret' => $CI->config->item('aws_secret_key'),
            ],
        ]);
        // echo __DIR__;die();
    }
}

if (!function_exists('upload_to_s3')) {
    function upload_to_s3($filePath, $key) {
        $CI =& get_instance();
        $CI->load->config('aws');
        
        $s3 = get_s3_client();
        
        try {
            $result = $s3->putObject([
                'Bucket'     => $CI->config->item('aws_bucket'),
                'Key'        => $key,
                'SourceFile' => $filePath,
                // 'ACL'        => 'public-read'  // You can set different permissions
            ]);
            // echo $CI->config->item('aws_bucket');
            // echo '<br/>'.$key;
            // echo '<br/>'.$filePath;
            // print_r($result);
            // die();
            return $result['ObjectURL'];  // Return the URL of the uploaded file
        } catch (Aws\S3\Exception\S3Exception $e) {
            // Catch and handle the error
            return false;
        }
    }
}

if (!function_exists('get_s3_file_url')) {
    function get_s3_file_url($key) {
        $CI =& get_instance();
        $CI->load->config('aws');
        
        $s3 = get_s3_client();

        try {
            $cmd = $s3->getCommand('GetObject', [
                'Bucket' => $CI->config->item('aws_bucket'),
                'Key'    => $key
            ]);

            $request = $s3->createPresignedRequest($cmd, '+20 minutes');
            return (string)$request->getUri();
        } catch (Aws\S3\Exception\S3Exception $e) {
            // Catch and handle the error
            return false;
        }
    }
}

if (!function_exists('delete_s3_file')) {
    function delete_from_s3($fileKey) {
        $CI =& get_instance();
        $CI->load->config('aws');
        $objectKey = get_key_from_url($fileKey);
        $s3 = get_s3_client();
        // die(json_encode($objectKey));
        try {
            // Delete the file from S3
            $result = $s3->deleteObject([
                'Bucket' => $CI->config->item('aws_bucket'),  // Your bucket name
                'Key'    => $objectKey,  // The path to the file in S3 (e.g., 'folder/file.jpg')
            ]);

            return $result;
        } catch (Aws\S3\Exception\S3Exception $e) {
            // Catch an S3 specific exception
            echo "Error deleting file: " . $e->getMessage();
        }
    }
}

function get_key_from_url($objectUrl) {
    $parsedUrl = parse_url($objectUrl);
    $host = $parsedUrl['host'];
    // Check if the host matches your S3 bucket URL
    if (strpos($host, 'testingbucketforvdo.s3.ap-southeast-1.amazonaws.com') !== false) {
        // Extract the object key (path after the bucket URL)
        return ltrim($parsedUrl['path'], '/');  // Removes leading slash
    }

    // Invalid URL (not an S3 URL)
    return false;
}