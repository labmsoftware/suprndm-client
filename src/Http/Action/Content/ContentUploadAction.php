<?php

namespace App\Http\Action\Content;

use App\Http\Action\Action;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ContentUploadAction extends Action
{
    public function __construct(

    ) {
        
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (!isset($_FILES["file"])) {
            die("There is no file to upload.");
        }
        
        $filepath = $_FILES['file']['tmp_name'];
        $fileSize = filesize($filepath);
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);
        
        if ($fileSize === 0) {
            die("The file is empty.");
        }
        
        $allowedTypes = [
           'video/mp4' => 'mp4',
        ];
        
        if (!in_array($filetype, array_keys($allowedTypes))) {
            die("File not allowed.");
        }
        
        $filename = 'target';
        $extension = $allowedTypes[$filetype];
        $targetDirectory = ROOT_DIR . "/public/uploads"; // __DIR__ is the directory of the current PHP file
        
        $newFilepath = $targetDirectory . "/" . $filename . "." . $extension;
        
        if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
            die("Can't move file.");
        }
        unlink($filepath); // Delete the temp file

        return $response->withHeader('HX-Redirect', '/');
    }
}