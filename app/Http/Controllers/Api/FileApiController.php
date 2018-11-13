<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\FileRequest;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Request;

class FileApiController extends ApiController
{
    protected $file;

    /**
     * FileApiController constructor.
     * @param FileRepository $file
     */
    public function __construct(FileRepository $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     * store file
     * FileRequest check file type, file size ( < 2mb )
     * request has channel_id, thread_id, creator_id
     * return file_path and file information if store success, if not return error code
     * @param FileRequest $request
     */
    public function upload(FileRequest $request) {

    }

    /**
     * get list file in channel
     * $request has channel_id
     * return list file in channel
     * @param Request $request
     */
    public function getListFile(Request $request) {

    }

    /**
     * remove file in channel
     * $request has file_id
     * return true if remove success, if not return error code
     * @param Request $request
     */
    public function removeFile(Request $request) {

    }

    /**
     * get file path
     * $request has file_id
     * return file path
     * @param Request $request
     */
    public function getFilePath(Request $request) {

    }




}
