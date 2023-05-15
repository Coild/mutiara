<?php

namespace App\Http\Controllers;

class StorageLinkController extends Controller
{
    public function index()
    {
        $target = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
        $link = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';

        symlink($target, $link);
    }
}
