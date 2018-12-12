<?php

namespace App\Repositories;

use App\Model\Admin;
use App\Model\Report;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class ReportRepository {
    use BaseRepository;
    //

    /**
     * User Model
     *
     * @var User
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->model = $report;
    }

}
