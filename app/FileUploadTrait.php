<?php
// app/Traits/FileUploadTrait.php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

trait FileUploadTrait
{

    protected function uploadFile($file, $path, $oldFile = null, $maxSize = 2048)
    {
        try {
            if ($oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            $newPath = $file->store($path, 'public');
            
            return $newPath;
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            session()->flash('error', 'Failed to upload file: ' . $e->getMessage());
            return null;
        }
    }

    protected function deleteFile($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return true;
        }
        return false;
    }

    protected function getFileSize($file)
    {
        if (!$file) return '0 KB';
        
        $size = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }

    protected function getFileExtension($file)
    {
        return $file ? $file->getClientOriginalExtension() : null;
    }

    protected function getFileName($file)
    {
        return $file ? $file->getClientOriginalName() : null;
    }

    protected function isImage($file)
    {
        if (!$file) return false;
        
        $mimeType = $file->getMimeType();
        return strpos($mimeType, 'image/') === 0;
    }
}