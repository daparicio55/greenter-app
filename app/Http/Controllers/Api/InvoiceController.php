<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\SunatService;
use DateTime;
use Greenter\Report\XmlUtils;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();

        $company = Company::where('user_id', auth()->user()->id)
        ->where('ruc', $data['company']['ruc'])
        ->first();
        
        //$fecha = new DateTime();
        //return var_dump($fecha);

        $sunat = new SunatService();

        
       
        $see = $sunat->getSee($company);

        $invoice = $sunat->getInvoice($data);
               
        $result = $see->send($invoice);

        $response['xml'] = $see->getFactory()->getLastXml();

        $response['hash'] = (new XmlUtils())->getHashSign($see->getFactory()->getLastXml());     
        
        $response['sunatResponse'] = $sunat->sunatResponse($result);

        return response()->json($response, 200);
    }
}
