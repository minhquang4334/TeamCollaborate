<?php

namespace App\Transformers;
use App\Model\React;
use App\Model\Report;
use League\Fractal\TransformerAbstract;

class ReportTransformer extends TransformerAbstract {

    public function transform(Report $report) {
        return [
            'report_creator_id' => $report->report_creator_id,
            'channel_id' => $report->channel_id,
            'post_id' => $report->post_id,
            'description' => $report->description,
            'subject' => $report->subject,
            'status' => $report->status
        ];
    }
}
