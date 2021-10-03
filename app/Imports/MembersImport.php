<?php

namespace App\Imports;

use App\Jobs\ImportJob;
use App\Models\Contractor;
use App\Models\Member;
use App\Models\MemberEmail;
use App\Models\MemberPhone;
use App\Models\Payment;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ImportJob::dispatch($row);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
