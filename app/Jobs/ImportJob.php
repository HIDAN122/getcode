<?php

namespace App\Jobs;

use App\Models\Contractor;
use App\Models\Member;
use App\Models\MemberEmail;
use App\Models\MemberPhone;
use App\Models\Payment;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public array $row
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $member = Member::where('member_number', $this->row['member_number'])->first();

        if (!$member) {
            $member = Member::where('first_name', $this->row['first_name'])
                ->orWhere('last_name', $this->row['last_name'])->first();
            if ($member) {
                $member->update([
                    'address' => $this->row['address'],
                    'city' => $this->row['city'],
                    'country' => $this->row['country']
                ]);
            } else {
                $member =  Member::create([
                    'first_name' => $this->row['first_name'],
                    'last_name' => $this->row['last_name'],
                    'member_number' => $this->row['member_number'],
                    'email' => $this->row['email'],
                    'phone' => $this->row['phone'],
                    'address' => $this->row['address'],
                    'city' => $this->row['city'],
                    'country' => $this->row['country']
                ]);

            }
        } else {
            $member->update([
                'address' => $this->row['address'],
                'city' => $this->row['city'],
                'country' => $this->row['country']
            ]);
        }

        $email = MemberEmail::where('member_id', $member->id)
            ->where('is_primary', 1)->first();

        if ($email) {
            $email->update([
                'is_primary' => 0
            ]);
        }

        MemberEmail::create([
            'member_id' => $member->id,
            'email' => $this->row['email'],
            'is_primary' => 1
        ]);

        $phone = MemberPhone::where('member_id', $member->id)
            ->where('is_primary', 1)->first();

        if ($phone) {
            $phone->update([
                'is_primary' => 0
            ]);
        }

        MemberPhone::create([
            'member_id' => $member->id,
            'phone' => $this->row['phone'],
            'is_primary' => 1
        ]);


        $company = Contractor::where('name',$this->row['company'])->first();

        if(!$company) {
            $company = Contractor::create([
                'name' => $this->row['company']
            ]);
        }

        $workHistory = WorkHistory::where('contractor_id',$company->id)
            ->where('start_date',$this->row['start_date'])
            ->first();

        if($workHistory) {
            $workHistory->update([
                'title' => $this->row['title']
            ]);
        } else {
            WorkHistory::create([
                'member_id' => $member->id,
                'contractor_id' => $company->id,
                'title' => $this->row['title'],
                'start_date' => $this->row['start_date'],
                'end_date' => $this->row['end_date']
            ]);
        }

        Payment::create([
            'member_id' => $member->id,
            'amount' => round($this->row['payment'],3),
            'effective_date' => Carbon::parse($this->row['start_date'])->subMonth()->endOfMonth()->toDateTimeString(),
            'paid_date' => Carbon::parse($this->row['end_date'])->addMonth()->startOfMonth()->toDateTimeString()
        ]);
    }
}
