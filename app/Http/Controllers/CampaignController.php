<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Campaign;
use Carbon\Carbon;
class CampaignController extends Controller
{
    public function index()
    {
        $link = Campaign::first();
        $status = false;
        if ($link) {
            // using greaterThan()
            $firstDate = Carbon::now();
            $secondDate = Carbon::parse($link->end_date);
            if ($firstDate->greaterThan($secondDate)) {
                $status = false;
            } else {
                $status = true;
            }
        }
        return view('content.campaign.index',compact('status','link'));
    }

    public function generateLink(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        try {
            $token = Str::random(40);
            Campaign::updateOrCreate(
                [],
                [
                    'token' => $token,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ],
            );
            return redirect()
                ->back()
                ->with('success', 'Link Gnerated Successfully');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }
}
