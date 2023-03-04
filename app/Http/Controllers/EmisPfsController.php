<?php
/**
 * @OA\Info(title="EMIS PFS", version="0.1")
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\EmisPfs;
use App\Models\Patient;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;


class EmisPfsController extends Controller
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
    public function patientRecord(string $NationalPracticeCode, string $AccessIdentityGuid)
    {
        //Create Patient
        $patient = new Patient();

        //Create EndUser Session (If doesn't exist)
        $endUserSession = $patient->createEndUserSession();

        //Create Session
        $sessionId = $patient->createSession($endUserSession, $NationalPracticeCode, $AccessIdentityGuid);

        //Get Medical Record
        $medicalRecord = $patient->getMedicalRecord($sessionId, $endUserSession);

        return $medicalRecord;
    }

    /**
     *
     * @string \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/emis/pfs/patientAppointments/{AccessIdentityGuid}/{NationalPracticeCode}",
     *    operationId="patientAppointments",
     *    tags={"Appointments"},
     *    summary="Return a patients appointments",
     *    description="Get/Patients appointments",
     *
     *    @OA\Parameter(in="path", name="AccessIdentityGuid",@OA\Schema(type="string",nullable=false), required=true),
     *    @OA\Parameter(in="path", name="NationalPracticeCode",@OA\Schema(type="string",nullable=false), required=true),
     *
     *    @OA\Response(response="200", description="Returns appointments for a patient, which can be filtered by future/previous appointments")

     * )
     */
    public function patientAppointments(string $NationalPracticeCode, string $AccessIdentityGuid)
    {
        //Create Patient
        $patient = new Patient();

        //Create EndUser Session (If doesn't exist)
        $endUserSession = $patient->createEndUserSession();

        //Create Session
        $sessionId = $patient->createSession($endUserSession, $NationalPracticeCode, $AccessIdentityGuid);

        //Get Medical Record
        $medicalRecord = $patient->getAppoinments($sessionId, $endUserSession);

        return $medicalRecord;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmisPfs  $emisPfs
     * @return \Illuminate\Http\Response
     */
    public function edit(EmisPfs $emisPfs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmisPfs  $emisPfs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmisPfs $emisPfs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmisPfs  $emisPfs
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmisPfs $emisPfs)
    {
        //
    }
}
