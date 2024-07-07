<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\invoices;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $details  = invoices_Details::where('id_Invoice', $id)->get();
        $attachments  = invoice_attachment::where('invoice_id', $id)->get();
        return view('invoices.details_invoice', ['attachments' => $attachments, 'details' => $details, 'invoices' => $invoices]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice = invoice_attachment::findorFail($request->id_file);
        $invoice->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
    public function download_file($invoice_number, $file_name)
    {
        $filePath = $invoice_number . '/' . $file_name;
        if (Storage::disk('public_uploads')->exists($filePath)) {
            // Get the full path to the file
            return Storage::disk('public_uploads')->download($filePath);
        } else {
            return "File does not exist.";
        }
        return back();
    }
    public function open_file($invoice_number, $file_name)
    {
        // Ensure the file exists
        $filePath = $invoice_number . '/' . $file_name;
        if (Storage::disk('public_uploads')->exists($filePath)) {
            // Get the full path to the file
            $fullPath = Storage::disk('public_uploads')->path($filePath);
            return response()->file($fullPath);
        } else {
            return "File does not exist.";
        }
    }
}
