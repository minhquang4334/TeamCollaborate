<?php

namespace App\Repositories;

use App\Model\File;
use Illuminate\Support\Facades\Auth;

class FileRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param File $file
     */

    public function __construct(File $file)
    {
        $this->model = $file;
    }

}
