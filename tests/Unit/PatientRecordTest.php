<?php

use App\Models\Patient;
use PHPUnit\Framework\TestCase;

class PatientRecordTest extends TestCase
{
    public function testPatientRecord()
    {
        $patientMock = $this->getMockBuilder(Patient::class)
            ->onlyMethods(['createEndUserSession', 'createSession', 'getMedicalRecord'])
            ->getMock();

        // Mock the return values for the mocked methods
        $endUserSessionMock = 'mockedEndUserSession';
        $sessionIdMock = 'mockedSessionId';
        $medicalRecordMock = 'mockedMedicalRecord';

        $patientMock->expects($this->once())
            ->method('createEndUserSession')
            ->willReturn($endUserSessionMock);

        $patientMock->expects($this->once())
            ->method('createSession')
            ->with($endUserSessionMock, 'mockedNationalPracticeCode', 'mockedAccessIdentityGuid')
            ->willReturn($sessionIdMock);

        $patientMock->expects($this->once())
            ->method('getMedicalRecord')
            ->with($sessionIdMock, $endUserSessionMock)
            ->willReturn($medicalRecordMock);

        // Create an instance of the class under test
        $patient = new Patient();

        // Set the mocked object for the patient
        $patient->setPatientMock($patientMock);

        // Call the method being tested
        $result = $patient->patientRecord('mockedNationalPracticeCode', 'mockedAccessIdentityGuid');

        // Assert the expected output
        $this->assertSame($medicalRecordMock, $result);
    }
}
