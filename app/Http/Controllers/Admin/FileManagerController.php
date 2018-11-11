<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FileRepository;

class FileManagerController extends Controller
{
    protected $file;

    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }

    public function index(){
        $files = $this->file->all();
        return view('admin.files', compact('files'));
    }


    public function delete($id){
        $status = $this->file->destroy($id);
        return response()->json(['data'=> $status ], self::CODE_DELETE_SUCCESS);
    }

    public function download($id)
    {
        $file = $this->file->getById($id);
        $file_download= public_path(). $file->file_path;
        $ext = pathinfo($file->file_path, PATHINFO_EXTENSION);
        $headers = array(
            'Content-Type: application/octet-stream',
        );

        return \Response::download($file_download, $file->file_name . '.'. $ext, $headers);
    }
}
