<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'file_name' => 'mimes:png,jpg,pdf,jpeg'
        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون pdf, jpeg ,.jpg , png'
        ]);
        $invoice_id = invoices::find($request->invoice_id);
        if ($request->hasFile('file_name')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $invoice_number), $imageName);
            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice_attachment $invoice_attachment)
    {
        //
    }
}
