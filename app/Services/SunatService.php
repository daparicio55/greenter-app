<?php

namespace App\Services;

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Report\HtmlReport;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Storage;

class SunatService
{
    public function getSee($company){
        
        $see = new See();
        $see->setCertificate(Storage::get($company->cert_path));
        $see->setService( $company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA);
        $see->setClaveSOL($company->ruc, $company->sol_user, $company->sol_pass);
        return  $see;

    }
    public function getInvoice($data){
        $invoice = (new Invoice())
            ->setUblVersion($data['ublVersion'] ?? '2.1')
            ->setTipoOperacion($data['tipoOperacion'] ?? null) // Venta - Catalog. 51
            ->setTipoDoc($data['tipoDoc']?? null) // Factura - Catalog. 01 
            ->setSerie($data['serie']?? null)
            ->setCorrelativo($data['correlativo']?? null)
            ->setFechaEmision(new DateTime($data['fechaEmision'] ?? null)) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            ->setTipoMoneda($data['tipoMoneda'] ?? null) // Sol - Catalog. 02
            ->setCompany($this->getCompany($data['company']))
            ->setClient($this->getClient($data['client']))
            // Montos de Operaciones gravadas, exoneradas, inafectas, exportación y gratuitas
            ->setMtoOperGravadas($data['mtoOperGravadas'])
            ->setMtoOperExoneradas($data['mtoOperExoneradas'])
            ->setMtoOperInafectas($data['mtoOperInafectas'])
            ->setMtoOperExportacion($data['mtoOperExportacion'])
            ->setMtoOperGratuitas($data['mtoOperGratuitas'])

            // Impuestos
            ->setMtoIGV($data['mtoIGV'])
            ->setMtoIGVGratuitas($data['mtoIGVGratitutas'])
            ->setTotalImpuestos($data['totalImpuestos'])
            ->setIcbper($data['icbper'])

            //totales
            ->setValorVenta($data['valorVenta'])
            ->setSubTotal($data['subTotal'])
            ->setRedondeo($data['redondeo'])
            ->setMtoImpVenta($data['mtoImpVenta'])

            //productos
            ->setDetails($this->getDetails($data['details']))

            //Leyendas
            ->setLegends($this->getLegends($data['legends']));
        return $invoice;
    }
    public function getCompany($company){
        $company = (new Company())
            ->setRuc($company['ruc'] ?? null)
            ->setRazonSocial($company['razonSocial'] ?? null)
            ->setNombreComercial($company['nombreComercial'] ?? null)
            ->setAddress($this->getAddres($company['address']));
        return $company;
    }

    public function getClient($client){
        $client = (new Client())
            ->setTipoDoc($client['tipoDoc'] ?? null) // RUC - Catalog. 06
            ->setNumDoc($client['numDoc'] ?? null)
            ->setRznSocial($client['rznSocial'] ?? null);
        return $client;
    }

    public function getAddres($address){
        $address = (new Address())
            ->setUbigueo($address['ubigueo'] ?? null)
            ->setDepartamento($address['departamento'] ?? null)
            ->setProvincia($address['provincia'] ?? null)
            ->setDistrito($address['distrito'] ?? null)
            ->setUrbanizacion($address['urbanizacion'] ?? null)
            ->setDireccion($address['direccion'] ?? null)
            ->setCodLocal($address['codLocal'] ?? null); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
        return $address;
    }

    public function getDetails($details){

        $green_details = [];

        foreach ($details as $key => $detail) {
            # code...
            $green_details[] = (new SaleDetail())
            ->setCodProducto($detail['codProducto'] ?? null) // Codigo Producto
            ->setUnidad($detail['unidad'] ?? null) // Unidad - Catalog. 03
            ->setCantidad($detail['cantidad'] ?? null)
            ->setMtoValorUnitario($detail['mtoValorUnitario'] ?? null)
            ->setDescripcion($detail['descripcion'] ?? null)
            ->setMtoBaseIgv($detail['mtoBaseIgv'] ?? null)
            ->setPorcentajeIgv($detail['porcentajeIgv'] ?? null) // 18%
            ->setIgv($detail['igv'] ?? null)
            ->setFactorIcbper($detail['factorIcbper'] ?? null) // 0.2
            ->setIcbper($detail['icbper'] ?? null)
            ->setTipAfeIgv($detail['tipAfeIgv'] ?? null) // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos($detail['totalImpuestos'] ?? null) // Suma de impuestos en el detalle
            ->setMtoValorVenta($detail['mtoValorVenta'] ?? null)
            ->setMtoPrecioUnitario($detail['mtoPrecioUnitario'] ?? null);
        }

        return $green_details;
    }

    public function getLegends($legends){
        $green_legends = [];

        foreach ($legends as $key => $legend) {
            # code...
            $green_legends[] = (new Legend())
            ->setCode($legend['code'] ?? null) // Monto en letras - Catalog. 52
            ->setValue($legend['value'] ?? null);
        }

        return $green_legends;
    }

    public function sunatResponse($result){

        $response['success'] = $result->isSuccess();
        
        if (!$response['success']) {
            // Mostrar error al conectarse a SUNAT.
            $response['erros'] = [
                'code' => $result->getError()->getCode(),
                'message' => $result->getError()->getMessage()
            ];
            return $response;
        }

        $response['cdrZip'] = base64_encode($result->getCdrZip());

        $cdr = $result->getCdrResponse();

        $response['cdrResponse'] = [
            'code' => (int)$cdr->getCode(),
            'description' => $cdr->getDescription(),
            'notes' => $cdr->getNotes()
        ];
        return $response; 
    }

    
    public function getHtmlReport($invoice,$company){
        $report = new HtmlReport();

        $resolver = new DefaultTemplateResolver();

        $report->setTemplate($resolver->getTemplate($invoice));

        $params = [
            'system' => [
                'logo' => Storage::get($company->logo_path), // Logo de Empresa
                'hash' => 'qqnr2dN4p/HmaEA/CJuVGo7dv5g=', // Valor Resumen 
            ],
            'user' => [
                'header'     => 'Telf: <b>(01) 123375</b>', // Texto que se ubica debajo de la dirección de empresa
                'extras'     => [
                    // Leyendas adicionales
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'     ],
                    ['name' => 'VENDEDOR'         , 'value' => 'GITHUB SELLER'],
                ],
                'footer' => '<p>Nro Resolucion: <b>3232323</b></p>'
            ]
        ];

        return $report->render($invoice, $params);

    }
}