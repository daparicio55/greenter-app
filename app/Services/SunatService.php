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
            ->setTipoOperacion($data['tipoOperacion'] ?? '0101') // Venta - Catalog. 51
            ->setTipoDoc($data['tipoDoc']) // Factura - Catalog. 01 
            ->setSerie($data['serie'])
            ->setCorrelativo($data['correlativo'])
            ->setFechaEmision(new DateTime($data['fechaEmision'])) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            ->setTipoMoneda($data['tipoMoneda']) // Sol - Catalog. 02
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
            ->setRuc($company['ruc'])
            ->setRazonSocial($company['razonSocial'])
            ->setNombreComercial($company['nombreComercial'])
            ->setAddress($this->getAddres($company['address']));
        return $company;
    }

    public function getClient($client){
        $client = (new Client())
            ->setTipoDoc($client['tipoDoc']) // RUC - Catalog. 06
            ->setNumDoc($client['numDoc'])
            ->setRznSocial($client['rznSocial']);
        return $client;
    }

    public function getAddres($address){
        $address = (new Address())
            ->setUbigueo($address['ubigueo'])
            ->setDepartamento($address['departamento'])
            ->setProvincia($address['provincia'])
            ->setDistrito($address['distrito'])
            ->setUrbanizacion($address['urbanizacion'])
            ->setDireccion($address['direccion'])
            ->setCodLocal($address['codLocal']); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
        return $address;
    }

    public function getDetails($details){

        $green_details = [];

        foreach ($details as $key => $detail) {
            # code...
            $green_details[] = (new SaleDetail())
            ->setCodProducto($detail['codProducto']) // Codigo Producto
            ->setUnidad($detail['unidad']) // Unidad - Catalog. 03
            ->setCantidad($detail['cantidad'])
            ->setMtoValorUnitario($detail['mtoValorUnitario'])
            ->setDescripcion($detail['descripcion'])
            ->setMtoBaseIgv($detail['mtoBaseIgv'])
            ->setPorcentajeIgv($detail['porcentajeIgv']) // 18%
            ->setIgv($detail['igv'])
            ->setTipAfeIgv($detail['tipAfeIgv']) // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos($detail['totalImpuestos']) // Suma de impuestos en el detalle
            ->setMtoValorVenta($detail['mtoValorVenta'])
            ->setMtoPrecioUnitario($detail['mtoPrecioUnitario']);
        }

        return $green_details;
    }

    public function getLegends($legends){
        $green_legends = [];

        foreach ($legends as $key => $legend) {
            # code...
            $green_legends[] = (new Legend())
            ->setCode($legend['code']) // Monto en letras - Catalog. 52
            ->setValue($legend['value']);
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
}