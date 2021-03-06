<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportDua;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ReportDuaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'case_list_id' => 'required',
                'file_upload' => 'required',
                'file_upload.*' => 'max:10240|mimes:xlsx,xls,docx,doc,pdf,mp4',
                'time_upload' => 'required',
                'pr_amount' => 'required',
                'ir_status' => 'required',
            ]);

            if ($request->hasFile('file_upload')) {
                $files = $request->file('file_upload');
                foreach ($files as $file) {
                    $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                    $filename = 'files/report-dua/' . $name;
                    $path = 'files/report-dua/' . $name;

                    if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                        \Image::make($file)->resize(480, 360)->save($path, 90);
                    } else {
                        $file->storeAs('files/report-dua/', $name);
                    }

                    ReportDua::create([
                        'case_list_id' => $request->case_list_id,
                        'file_upload' => $filename,
                        'time_upload' => Carbon::now()
                    ]);
                }
            }

            $caseList = CaseList::find($request->case_list_id);
            $update = [
                'pr_amount' => $request->pr_amount,
                'pr_status' => 1,
                'pr_date' => Carbon::now(),
                'now_update' => Carbon::now(),
                'ir_status' => $request->ir_status,
                'file_status_id' => 4
            ];

            if ($caseList->pr_status == 0) {
                if ($request->ir_status == 0) {
                    $update['pa_limit'] = Carbon::now()->addDay(14);
                    $caseList->update($update);
                } else {
                    $update['ir_st_limit'] = Carbon::now()->addDay(14);
                    $caseList->update($update);
                }
            } else {
                $caseList->update(['pr_amount' => $request->pr_amount, 'date_complete' => $request->date_complete]);
            }

            return back()->with('success', 'Report dua has been uploaded');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportDua  $reportDua
     * @return \Illuminate\Http\Response
     */
    public function show(ReportDua $reportDua)
    {
        $file = explode('.', $reportDua->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($reportDua->file_upload);
        } else {
            return Storage::download($reportDua->file_upload);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportDua  $reportDua
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportDua $reportDua)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportDua  $reportDua
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportDua $reportDua)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportDua  $reportDua
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportDua $reportDua)
    {
        //
    }
}
