<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * @return string
     */
    public function createEndUserSession()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'POST',
            url(env('EMIS_PFS_URL').'/pfs/sessions/endusersession'),
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'X-API-Version' => env('EMIS_PFS_API_VERSION', '2.1.0.0'),
                    'X-API-ApplicationId' => env('EMIS_PFS_APP_ID')
                ],
            ]
        );

        //Decode the returned body content into JSON
        $endUserSessionId = json_decode($res->getBody());

        //Return the EndUserSessionId
        return $endUserSessionId->EndUserSessionId;
    }


    public function createSession($endUserSession, $AccessIdentityGuid, $NationalPracticeCode)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'POST',
            url(env('EMIS_PFS_URL').'/pfs/sessions'),
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'X-API-Version' => env('EMIS_PFS_API_VERSION', '2.1.0.0'),
                    'X-API-ApplicationId' => env('EMIS_PFS_APP_ID'),
                    'X-API-EndUserSessionId' => $endUserSession
                ],
                'json' => [
                    'AccessIdentityGuid' => $AccessIdentityGuid,
                    'NationalPracticeCode' => $NationalPracticeCode
                ]
            ]
        );

        //Decode the returned body content into JSON
        $sessionId = json_decode($res->getBody());

        //Return the EndUserSessionId
        return $sessionId;
    }

    /**
     * @return string
     */
    public function getMedicalRecord($session, $endUserSession, $itemType = null, $filterFromDate = null, $filterToDate = null)
    {
        //Set variables from the session response
        $sessionId = $session->SessionId;
        $userPatientLinkToken = $session->UserPatientLinks[0]->UserPatientLinkToken;

        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'GET',
            url(env('EMIS_PFS_URL').'/pfs/record?UserPatientLinkToken='.$userPatientLinkToken.'&ItemType=Medication&FilterFromDate=2023-03-07&FilterToDate=2023-03-07'),
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'X-API-Version' => env('EMIS_PFS_API_VERSION', '2.1.0.0'),
                    'X-API-ApplicationId' => env('EMIS_PFS_APP_ID'),
                    'X-API-EndUserSessionId' => $endUserSession,
                    'X-API-SessionId' => $sessionId,
                    'ItemType' => 'Documents',
                    'FilterFromDate' => '2023-03-07T00:00:00.001Z',
                    'FilterToDate' => '2023-03-07T23:59:59.591Z',
                ],

            ]
        );

        //Decode the returned body content into JSON
//        $sessionId = json_decode($res->getBody());
        $sessionId = $res->getBody();
//        echo '<pre>';
//        print_r(json_decode($res->getBody()));
//        echo '</pre>';

        //Check reponse and link if not linked

        //Return the EndUserSessionId
        return $sessionId;
    }


    /**
     * @return string
     */
    public function getAppoinments($session, $endUserSession, $filterFromDate = false, $filterToDate = null)
    {
        //Set variables from the session response
        $sessionId = $session->SessionId;
        $userPatientLinkToken = $session->UserPatientLinks[0]->UserPatientLinkToken;

        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'GET',
            url(env('EMIS_PFS_URL').'/pfs/appointments?UserPatientLinkToken='.$userPatientLinkToken),
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'X-API-Version' => env('EMIS_PFS_API_VERSION', '2.1.0.0'),
                    'X-API-ApplicationId' => env('EMIS_PFS_APP_ID'),
                    'X-API-EndUserSessionId' => $endUserSession,
                    'X-API-SessionId' => $sessionId,
                    'FetchPreviousAppointments' => $filterFromDate,
                    'PreviousAppointmentsFromDate' => $filterToDate,
                ],

            ]
        );

        //Decode the returned body content into JSON
        $sessionId = json_decode($res->getBody());

        //Check reponse and link if not linked

        //Return the EndUserSessionId
        return $sessionId;
    }
}
