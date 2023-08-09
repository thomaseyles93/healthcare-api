<?php
/**
 * @OA\Info(title="PDS", version="0.1")
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Pds;
use App\Models\Patient;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;


class PdsController extends Controller
{
     /**
     *
     * @string \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/emis/pfs/patientRecord/{AccessIdentityGuid}/{NationalPracticeCode}",
      *    operationId="patientRecord",
      *    tags={"Medical Record"},
      *    summary="Return a patients medical record",
      *    description="Get/Patients medical record",
      *
      *    @OA\Parameter(in="path", name="AccessIdentityGuid",@OA\Schema(type="string",nullable=false), required=true),
      *    @OA\Parameter(in="path", name="NationalPracticeCode",@OA\Schema(type="string",nullable=false), required=true),
      *
      *    @OA\Response(response="200", description="Returns a patients medical record")

     * )
     */
    public function patient()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'GET',
            url(env('PDS_URL').'Patient?_fuzzy-match=false&_exact-match=false&_history=true&_max-results=1&family=Smith&given=Jane&gender=female&birthdate=eq2010-10-22&death-date=eq2010-10-22&address-postcode=LS1%206AE&general-practitioner=Y12345'),
            [
                'headers' => [
                    'Accept'     => 'application/fhir+json',
                    'NHSD-Session-URID' => '555254240100',
                    'X-Request-ID' => '60E0B220-8136-4CA5-AE46-1D97EF59D068',
                    'X-Correlation-ID' => '11C46F5F-CDEF-4865-94B2-0EE0EDCC26DA',
                    'X-API-SessionId' => 'Y12345',
                ],

            ]
        );

        //Decode the returned body content into JSON
        $data = $res->getBody();

        //Return the EndUserSessionId
        return $data;
    }

}
