<?php
namespace RKW\RkwFeecalculator\Domain\Model;
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * SupportRequest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SupportRequest extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $name = '';

    /**
     * name of the founder
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $founderName = '';

    /**
     * address
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $address = '';

    /**
     * zip
     *
     * @var int
     * @validateOnObject NotEmpty, Integer
     */
    protected $zip = 0;

    /**
     * city
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $city = '';

    /**
     * foundationDate
     *
     * @var string
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator
     */
    protected $foundationDate = 0;

    /**
     * intendedFoundationDate
     *
     * @var string
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator
     */
    protected $intendedFoundationDate = 0;

    /**
     * citizenship
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $citizenship = '';

    /**
     * birthdate
     *
     * @var string
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator
     */
    protected $birthdate = 0;

    /**
     * foundationLocation
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $foundationLocation = '';

    /**
     * sales
     *
     * @var int
     * @validateOnObject NotEmpty, Integer
     */
    protected $sales = '';

    /**
     * balance
     *
     * @var int
     * @validateOnObject NotEmpty, Integer
     */
    protected $balance = '';

    /**
     * employeesCount
     *
     * @var int
     * @validateOnObject NotEmpty, Integer
     */
    protected $employeesCount = 0;

    /**
     * manager
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $manager = '';

    /**
     * singleRepresentative
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $singleRepresentative;

    /**
     * preTaxDeduction
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $preTaxDeduction;

    /**
     * businessPurpose
     *
     * @var string
     * @validateOnObject NotEmpty, Text
     */
    protected $businessPurpose = '';

    /**
     * insolvencyProceedings
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $insolvencyProceedings;

    /**
     * chamber
     *
     * @var int
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator
     */
    protected $chamber = 0;

    /**
     * companyShares
     *
     * @var string
     * @validateOnObject NotEmpty, Text
     */
    protected $companyShares = '';

    /**
     * principalBank
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $principalBank = '';

    /**
     * bic
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $bic = '';

    /**
     * iban
     *
     * @var string
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\IbanValidator
     */
    protected $iban = '';

    /**
     * contactPersonName
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $contactPersonName = '';

    /**
     * contactPersonPhone
     *
     * @var string
     * @validateOnObject NotEmpty
     */
    protected $contactPersonPhone = '';

    /**
     * contactPersonFax
     *
     * @var string
     * @validateOnObject NotEmpty
     */
    protected $contactPersonFax = '';

    /**
     * contactPersonMobile
     *
     * @var string
     * @validateOnObject NotEmpty
     */
    protected $contactPersonMobile = '';

    /**
     * contactPersonEmail
     *
     * @var string
     * @validateOnObject NotEmpty, EmailAddress
     */
    protected $contactPersonEmail = '';

    /**
     * preFoundationEmployment
     *
     * @var int
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator
     */
    protected $preFoundationEmployment = 0;

    /**
     * preFoundationSelfEmployment
     *
     * @var int
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator
     */
    protected $preFoundationSelfEmployment = 0;

    /**
     * consultingDays
     *
     * @var int
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator
     */
    protected $consultingDays = 0;

    /**
     * consultingDateFrom
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $consultingDateFrom = '';

    /**
     * consultingDateTo
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $consultingDateTo = '';

    /**
     * consultingContent
     *
     * @var string
     * @validateOnObject NotEmpty, Text
     */
    protected $consultingContent = '';

    /**
     * consultantType
     *
     * @var int
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator
     */
    protected $consultantType = 0;

    /**
     * consultantCompany
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $consultantCompany = '';

    /**
     * consultantName1
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $consultantName1 = '';

    /**
     * consultantName2
     *
     * @var string
     * @validateOnObject NotEmpty, String
     */
    protected $consultantName2 = '';

    /**
     * consultant1AccreditationNumber
     *
     * @var string
     * @validateOnObject NotEmpty
     */
    protected $consultant1AccreditationNumber = '';

    /**
     * consultant2AccreditationNumber
     *
     * @var string
     * @validateOnObject NotEmpty
     */
    protected $consultant2AccreditationNumber = '';

    /**
     * consultantFee
     *
     * @var int
     * @validateOnObject NotEmpty, Integer
     */
    protected $consultantFee = '';

    /**
     * consultantPhone
     *
     * @var string
     * @validateOnObject NotEmpty
     */
    protected $consultantPhone = '';

    /**
     * consultantEmail
     *
     * @var string
     * @validateOnObject NotEmpty, EmailAddress
     */
    protected $consultantEmail = '';

    /**
     * prematureStart
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $prematureStart;

    /**
     * sendDocuments
     *
     * @var int
     * @validateOnObject NotEmpty, \RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator
     */
    protected $sendDocuments = 0;

    /**
     * bafaSupport
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $bafaSupport;

    /**
     * deMinimis
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $deMinimis;

    /**
     * privacy
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $privacy = 0;

    /**
     * terms
     *
     * @var int
     * @validateOnObject NotEmpty
     */
    protected $terms = 0;

    /**
     * supportProgramme
     *
     * @var \RKW\RkwFeecalculator\Domain\Model\Program
     */
    protected $supportProgramme = null;

    /**
     * consulting
     *
     * @var \RKW\RkwFeecalculator\Domain\Model\Consulting
     * @validateOnObject NotEmpty
     */
    protected $consulting = 0;

    /**
     * companyType
     *
     * @var \RKW\RkwBasics\Domain\Model\CompanyType
     * @validateOnObject NotEmpty
     */
    protected $companyType = null;

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name of the founder
     *
     * @return string $founderName
     */
    public function getFounderName()
    {
        return $this->founderName;
    }

    /**
     * Sets the founderName
     *
     * @param string $founderName
     * @return void
     */
    public function setFounderName($founderName)
    {
        $this->founderName = $founderName;
    }

    /**
     * Returns the address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the zip
     *
     * @return int $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param int $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the foundationDate
     *
     * @return \DateTime
     */
    public function getFoundationDate()
    {
        return $this->foundationDate;
    }

    /**
     * Sets the foundationDate
     *
     * @param \DateTime $foundationDate
     * @return void
     */
    public function setFoundationDate($foundationDate)
    {
        $this->foundationDate = $foundationDate;
    }

    /**
     * Returns the intendedFoundationDate
     *
     * @return \DateTime
     */
    public function getIntendedFoundationDate()
    {
        return $this->intendedFoundationDate;
    }

    /**
     * Sets the intendedFoundationDate
     *
     * @param \DateTime $intendedFoundationDate
     * @return void
     */
    public function setIntendedFoundationDate($intendedFoundationDate)
    {
        $this->intendedFoundationDate = $intendedFoundationDate;
    }

    /**
     * Returns the citizenship
     *
     * @return string $citizenship
     */
    public function getCitizenship()
    {
        return $this->citizenship;
    }

    /**
     * Sets the citizenship
     *
     * @param string $citizenship
     * @return void
     */
    public function setCitizenship($citizenship)
    {
        $this->citizenship = $citizenship;
    }

    /**
     * Returns the birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Sets the birthdate
     *
     * @param \DateTime $birthdate
     * @return void
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * Returns the foundationLocation
     *
     * @return string $foundationLocation
     */
    public function getFoundationLocation()
    {
        return $this->foundationLocation;
    }

    /**
     * Sets the foundationLocation
     *
     * @param string $foundationLocation
     * @return void
     */
    public function setFoundationLocation($foundationLocation)
    {
        $this->foundationLocation = $foundationLocation;
    }

    /**
     * Returns the sales
     *
     * @return string $sales
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * Sets the sales
     *
     * @param string $sales
     * @return void
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    }

    /**
     * Returns the balance
     *
     * @return string $balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Sets the balance
     *
     * @param string $balance
     * @return void
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * Returns the employeesCount
     *
     * @return int $employeesCount
     */
    public function getEmployeesCount()
    {
        return $this->employeesCount;
    }

    /**
     * Sets the employeesCount
     *
     * @param int $employeesCount
     * @return void
     */
    public function setEmployeesCount($employeesCount)
    {
        $this->employeesCount = $employeesCount;
    }

    /**
     * Returns the manager
     *
     * @return string $manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Sets the manager
     *
     * @param string $manager
     * @return void
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns the singleRepresentative
     *
     * @return int $singleRepresentative
     */
    public function getSingleRepresentative()
    {
        return $this->singleRepresentative;
    }

    /**
     * Sets the singleRepresentative
     *
     * @param int $singleRepresentative
     * @return void
     */
    public function setSingleRepresentative($singleRepresentative)
    {
        $this->singleRepresentative = $singleRepresentative;
    }

    /**
     * Returns the preTaxDeduction
     *
     * @return int $preTaxDeduction
     */
    public function getPreTaxDeduction()
    {
        return $this->preTaxDeduction;
    }

    /**
     * Sets the preTaxDeduction
     *
     * @param int $preTaxDeduction
     * @return void
     */
    public function setPreTaxDeduction($preTaxDeduction)
    {
        $this->preTaxDeduction = $preTaxDeduction;
    }

    /**
     * Returns the businessPurpose
     *
     * @return string $businessPurpose
     */
    public function getBusinessPurpose()
    {
        return $this->businessPurpose;
    }

    /**
     * Sets the businessPurpose
     *
     * @param string $businessPurpose
     * @return void
     */
    public function setBusinessPurpose($businessPurpose)
    {
        $this->businessPurpose = $businessPurpose;
    }

    /**
     * Returns the insolvencyProceedings
     *
     * @return int $insolvencyProceedings
     */
    public function getInsolvencyProceedings()
    {
        return $this->insolvencyProceedings;
    }

    /**
     * Sets the insolvencyProceedings
     *
     * @param int $insolvencyProceedings
     * @return void
     */
    public function setInsolvencyProceedings($insolvencyProceedings)
    {
        $this->insolvencyProceedings = $insolvencyProceedings;
    }

    /**
     * Returns the chamber
     *
     * @return int $chamber
     */
    public function getChamber()
    {
        return $this->chamber;
    }

    /**
     * Sets the chamber
     *
     * @param int $chamber
     * @return void
     */
    public function setChamber($chamber)
    {
        $this->chamber = $chamber;
    }

    /**
     * Returns the companyShares
     *
     * @return string $companyShares
     */
    public function getCompanyShares()
    {
        return $this->companyShares;
    }

    /**
     * Sets the companyShares
     *
     * @param string $companyShares
     * @return void
     */
    public function setCompanyShares($companyShares)
    {
        $this->companyShares = $companyShares;
    }

    /**
     * Returns the principalBank
     *
     * @return string $principalBank
     */
    public function getPrincipalBank()
    {
        return $this->principalBank;
    }

    /**
     * Sets the principalBank
     *
     * @param string $principalBank
     * @return void
     */
    public function setPrincipalBank($principalBank)
    {
        $this->principalBank = $principalBank;
    }

    /**
     * Returns the bic
     *
     * @return string $bic
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * Sets the bic
     *
     * @param string $bic
     * @return void
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
    }

    /**
     * Returns the iban
     *
     * @return string $iban
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Sets the iban
     *
     * @param string $iban
     * @return void
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
    }

    /**
     * Returns the contactPersonName
     *
     * @return string $contactPersonName
     */
    public function getContactPersonName()
    {
        return $this->contactPersonName;
    }

    /**
     * Sets the contactPersonName
     *
     * @param string $contactPersonName
     * @return void
     */
    public function setContactPersonName($contactPersonName)
    {
        $this->contactPersonName = $contactPersonName;
    }

    /**
     * Returns the contactPersonPhone
     *
     * @return string $contactPersonPhone
     */
    public function getContactPersonPhone()
    {
        return $this->contactPersonPhone;
    }

    /**
     * Sets the contactPersonPhone
     *
     * @param string $contactPersonPhone
     * @return void
     */
    public function setContactPersonPhone($contactPersonPhone)
    {
        $this->contactPersonPhone = $contactPersonPhone;
    }

    /**
     * Returns the contactPersonFax
     *
     * @return string $contactPersonFax
     */
    public function getContactPersonFax()
    {
        return $this->contactPersonFax;
    }

    /**
     * Sets the contactPersonFax
     *
     * @param string $contactPersonFax
     * @return void
     */
    public function setContactPersonFax($contactPersonFax)
    {
        $this->contactPersonFax = $contactPersonFax;
    }

    /**
     * Returns the contactPersonMobile
     *
     * @return string $contactPersonMobile
     */
    public function getContactPersonMobile()
    {
        return $this->contactPersonMobile;
    }

    /**
     * Sets the contactPersonMobile
     *
     * @param string $contactPersonMobile
     * @return void
     */
    public function setContactPersonMobile($contactPersonMobile)
    {
        $this->contactPersonMobile = $contactPersonMobile;
    }

    /**
     * Returns the contactPersonEmail
     *
     * @return string $contactPersonEmail
     */
    public function getContactPersonEmail()
    {
        return $this->contactPersonEmail;
    }

    /**
     * Sets the contactPersonEmail
     *
     * @param string $contactPersonEmail
     * @return void
     */
    public function setContactPersonEmail($contactPersonEmail)
    {
        $this->contactPersonEmail = $contactPersonEmail;
    }

    /**
     * Returns the preFoundationEmployment
     *
     * @return int $preFoundationEmployment
     */
    public function getPreFoundationEmployment()
    {
        return $this->preFoundationEmployment;
    }

    /**
     * Sets the preFoundationEmployment
     *
     * @param int $preFoundationEmployment
     * @return void
     */
    public function setPreFoundationEmployment($preFoundationEmployment)
    {
        $this->preFoundationEmployment = $preFoundationEmployment;
    }

    /**
     * Returns the preFoundationSelfEmployment
     *
     * @return int $preFoundationSelfEmployment
     */
    public function getPreFoundationSelfEmployment()
    {
        return $this->preFoundationSelfEmployment;
    }

    /**
     * Sets the preFoundationSelfEmployment
     *
     * @param int $preFoundationSelfEmployment
     * @return void
     */
    public function setPreFoundationSelfEmployment($preFoundationSelfEmployment)
    {
        $this->preFoundationSelfEmployment = $preFoundationSelfEmployment;
    }

    /**
     * Returns the consultingDays
     *
     * @return int $consultingDays
     */
    public function getConsultingDays()
    {
        return $this->consultingDays;
    }

    /**
     * Sets the consultingDays
     *
     * @param int $consultingDays
     * @return void
     */
    public function setConsultingDays($consultingDays)
    {
        $this->consultingDays = $consultingDays;
    }

    /**
     * Returns the consultingDateFrom
     *
     * @return string $consultingDateFrom
     */
    public function getConsultingDateFrom()
    {
        return $this->consultingDateFrom;
    }

    /**
     * Sets the consultingDateFrom
     *
     * @param string $consultingDateFrom
     * @return void
     */
    public function setConsultingDateFrom($consultingDateFrom)
    {
        $this->consultingDateFrom = $consultingDateFrom;
    }

    /**
     * Returns the consultingDateTo
     *
     * @return string $consultingDateTo
     */
    public function getConsultingDateTo()
    {
        return $this->consultingDateTo;
    }

    /**
     * Sets the consultingDateTo
     *
     * @param string $consultingDateTo
     * @return void
     */
    public function setConsultingDateTo($consultingDateTo)
    {
        $this->consultingDateTo = $consultingDateTo;
    }

    /**
     * Returns the consultingContent
     *
     * @return string $consultingContent
     */
    public function getConsultingContent()
    {
        return $this->consultingContent;
    }

    /**
     * Sets the consultingContent
     *
     * @param string $consultingContent
     * @return void
     */
    public function setConsultingContent($consultingContent)
    {
        $this->consultingContent = $consultingContent;
    }

    /**
     * Returns the consultantType
     *
     * @return int $consultantType
     */
    public function getConsultantType()
    {
        return $this->consultantType;
    }

    /**
     * Sets the consultantType
     *
     * @param int $consultantType
     * @return void
     */
    public function setConsultantType($consultantType)
    {
        $this->consultantType = $consultantType;
    }

    /**
     * Returns the consultantCompany
     *
     * @return string $consultantCompany
     */
    public function getConsultantCompany()
    {
        return $this->consultantCompany;
    }

    /**
     * Sets the consultantCompany
     *
     * @param string $consultantCompany
     * @return void
     */
    public function setConsultantCompany($consultantCompany)
    {
        $this->consultantCompany = $consultantCompany;
    }

    /**
     * Returns the consultantName1
     *
     * @return string $consultantName1
     */
    public function getConsultantName1()
    {
        return $this->consultantName1;
    }

    /**
     * Sets the consultantName1
     *
     * @param string $consultantName1
     * @return void
     */
    public function setConsultantName1($consultantName1)
    {
        $this->consultantName1 = $consultantName1;
    }

    /**
     * Returns the consultantName2
     *
     * @return string $consultantName2
     */
    public function getConsultantName2()
    {
        return $this->consultantName2;
    }

    /**
     * Sets the consultantName2
     *
     * @param string $consultantName2
     * @return void
     */
    public function setConsultantName2($consultantName2)
    {
        $this->consultantName2 = $consultantName2;
    }

    /**
     * Returns the consultant1AccreditationNumber
     *
     * @return string $consultant1AccreditationNumber
     */
    public function getConsultant1AccreditationNumber()
    {
        return $this->consultant1AccreditationNumber;
    }

    /**
     * Sets the consultant1AccreditationNumber
     *
     * @param string $consultant1AccreditationNumber
     * @return void
     */
    public function setConsultant1AccreditationNumber($consultant1AccreditationNumber)
    {
        $this->consultant1AccreditationNumber = $consultant1AccreditationNumber;
    }

    /**
     * Returns the consultant2AccreditationNumber
     *
     * @return string $consultant2AccreditationNumber
     */
    public function getConsultant2AccreditationNumber()
    {
        return $this->consultant2AccreditationNumber;
    }

    /**
     * Sets the consultant2AccreditationNumber
     *
     * @param string $consultant2AccreditationNumber
     * @return void
     */
    public function setConsultant2AccreditationNumber($consultant2AccreditationNumber)
    {
        $this->consultant2AccreditationNumber = $consultant2AccreditationNumber;
    }

    /**
     * Returns the consultantFee
     *
     * @return string $consultantFee
     */
    public function getConsultantFee()
    {
        return $this->consultantFee;
    }

    /**
     * Sets the consultantFee
     *
     * @param string $consultantFee
     * @return void
     */
    public function setConsultantFee($consultantFee)
    {
        $this->consultantFee = $consultantFee;
    }

    /**
     * Returns the consultantPhone
     *
     * @return string $consultantPhone
     */
    public function getConsultantPhone()
    {
        return $this->consultantPhone;
    }

    /**
     * Sets the consultantPhone
     *
     * @param string $consultantPhone
     * @return void
     */
    public function setConsultantPhone($consultantPhone)
    {
        $this->consultantPhone = $consultantPhone;
    }

    /**
     * Returns the consultantEmail
     *
     * @return string $consultantEmail
     */
    public function getConsultantEmail()
    {
        return $this->consultantEmail;
    }

    /**
     * Sets the consultantEmail
     *
     * @param string $consultantEmail
     * @return void
     */
    public function setConsultantEmail($consultantEmail)
    {
        $this->consultantEmail = $consultantEmail;
    }

    /**
     * Returns the prematureStart
     *
     * @return int $prematureStart
     */
    public function getPrematureStart()
    {
        return $this->prematureStart;
    }

    /**
     * Sets the prematureStart
     *
     * @param int $prematureStart
     * @return void
     */
    public function setPrematureStart($prematureStart)
    {
        $this->prematureStart = $prematureStart;
    }

    /**
     * Returns the sendDocuments
     *
     * @return int $sendDocuments
     */
    public function getSendDocuments()
    {
        return $this->sendDocuments;
    }

    /**
     * Sets the sendDocuments
     *
     * @param int $sendDocuments
     * @return void
     */
    public function setSendDocuments($sendDocuments)
    {
        $this->sendDocuments = $sendDocuments;
    }

    /**
     * Returns the bafaSupport
     *
     * @return int $bafaSupport
     */
    public function getBafaSupport()
    {
        return $this->bafaSupport;
    }

    /**
     * Sets the bafaSupport
     *
     * @param int $bafaSupport
     * @return void
     */
    public function setBafaSupport($bafaSupport)
    {
        $this->bafaSupport = $bafaSupport;
    }

    /**
     * Returns the deMinimis
     *
     * @return int $deMinimis
     */
    public function getDeMinimis()
    {
        return $this->deMinimis;
    }

    /**
     * Sets the deMinimis
     *
     * @param int $deMinimis
     * @return void
     */
    public function setDeMinimis($deMinimis)
    {
        $this->deMinimis = $deMinimis;
    }

    /**
     * Returns the privacy
     *
     * @return int $privacy
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * Sets the privacy
     *
     * @param int $privacy
     * @return void
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    /**
     * Returns the terms
     *
     * @return int $terms
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Sets the terms
     *
     * @param int $terms
     * @return void
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
    }

    /**
     * Returns the supportProgramme
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme
     */
    public function getSupportProgramme()
    {
        return $this->supportProgramme;
    }

    /**
     * Sets the supportProgramme
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme
     * @return void
     */
    public function setSupportProgramme($supportProgramme)
    {
        $this->supportProgramme = $supportProgramme;
    }

    /**
     * Returns the consulting
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting
     */
    public function getConsulting()
    {
        return $this->consulting;
    }

    /**
     * Sets the consulting
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting
     * @return void
     */
    public function setConsulting($consulting)
    {
        $this->consulting = $consulting;
    }

    /**
     * Returns the companyType
     *
     * @return \RKW\RkwBasics\Domain\Model\CompanyType $companyType
     */
    public function getCompanyType()
    {
        return $this->companyType;
    }

    /**
     * Sets the companyType
     *
     * @param \RKW\RkwBasics\Domain\Model\CompanyType $companyType
     * @return void
     */
    public function setCompanyType($companyType)
    {
        $this->companyType = $companyType;
    }

    /**
     * Transforms date strings to DateTime object
     *
     * @return void
     */
    public function transformDates()
    {
        $this->foundationDate = $this->transformDate($this->foundationDate);
        $this->intendedFoundationDate = $this->transformDate($this->intendedFoundationDate);
        $this->birthdate = $this->transformDate($this->birthdate);
    }

    /**
     * Transforms date string to DateTime object
     *
     * @param string $dateString
     * @return \DateTime
     */
    protected function transformDate($dateString)
    {
        if ($dateTime = \DateTime::createFromFormat('d.m.Y', $dateString)) {
            return $dateTime->getTimestamp();
        }

        return $dateString;
    }


}
