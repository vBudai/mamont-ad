<?php
namespace app\s3;
interface FileUploader
{
    function store($file, $filename): \ArrayAccess;
    function delete($url);
}