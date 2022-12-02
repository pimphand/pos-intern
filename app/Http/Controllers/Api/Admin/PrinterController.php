<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Models\OrderCategory;

class PrinterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-printer.index', ['only' => ['index']]);
    }

    public function setting(Request $request)
    {
        $connector = new WindowsPrintConnector("LPT2");

        $connector = new FilePrintConnector("LPT2");
        $printer = new Printer($connector);
        $printer -> text("Hello World!\n");
        $printer -> cut();
        $printer -> close();
        $status = $printer->getPrinterStatus(Printer::STATUS_PRINTER);

        return response()->json([
            'success'   => true,
            'status'    => $status
        ],200);

            
       
    }
}