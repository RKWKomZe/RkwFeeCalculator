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

use RKW\RkwBasics\Domain\Model\CompanyType;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * SupportRequest
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SupportRequest extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $name = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $founderName = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $address = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     */
    protected int $zip = 0;


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $city = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator")
     */
    protected string $foundationDate = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator")
     */
    protected string $intendedFoundationDate = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $citizenship = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator")
     */
    protected string $birthdate = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $foundationLocation = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     *  @todo you handle it as string (in model as in database) but validate it as integer - and it seems to be a float. Makes no sense IMO.
     */
    protected string $sales = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     *  @todo you handle it as string (in model as in database) but validate it as integer - and it seems to be a float. Makes no sense IMO.
     */
    protected string $balance = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     */
    protected int $employeesCount = 0;


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $manager = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *  @todo Shouldn't this be a boolean?
     */
    protected int $singleRepresentative = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *  @todo Shouldn't this be a boolean?
     */
    protected int $preTaxDeduction = 0;


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $businessPurpose = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     *  @todo Shouldn't this be a boolean?
     */
    protected int $insolvencyProceedings = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator")
     */
    protected int $chamber = 0;


    /**
     * companyShares
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     *  @todo you handle it as string (in model as in database) - and it seems to be a float. Makes no sense IMO.
     */
    protected string $companyShares = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $principalBank = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwBasics\Validation\Validator\SwiftBicValidator")
     */
    protected string $bic = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwBasics\Validation\Validator\IbanValidator")
     */
    protected string $iban = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $contactPersonName = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $contactPersonPhone = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $contactPersonFax = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $contactPersonMobile = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("EmailAddress")
     */
    protected string $contactPersonEmail = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator")
     */
    protected int $preFoundationEmployment = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator")
     */
    protected int $preFoundationSelfEmployment = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator")
     */
    protected int $consultingDays = 0;


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultingDateFrom = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultingDateTo = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultingContent = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *@TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator")
     */
    protected int $consultantType = 0;


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultantCompany = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultantName1 = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultantName2 = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $consultant1AccreditationNumber = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $consultant2AccreditationNumber = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("String")
     */
    protected string $consultantFee = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $consultantPhone = '';


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("EmailAddress")
     */
    protected string $consultantEmail = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *  @todo isn't this a boolean?
     */
    protected int $prematureStart;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>|null
     */
    protected ?ObjectStorage $file = null;


    /**
     * @var array
     */
    protected array $fileUpload = [];

    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\Validator\CustomSelectValidator")
     */
    protected int $sendDocuments = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *  @todo isn't this a boolean?
     */
    protected int $bafaSupport;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *  @todo isn't this a boolean?
     */
    protected int $deMinimis = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     *  @todo isn't this a boolean?
     */
    protected int $existenzGruenderPass = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("int")
     *  @todo isn't this a boolean?
     */
    protected int $privacy = 0;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program|null
     */
    protected ?Program $supportProgramme = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Consulting|null
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected ?Consulting $consulting = null;


    /**
     * @var \RKW\RkwBasics\Domain\Model\CompanyType|null
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected ?CompanyType $companytype = null;


    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->file = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }


    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Returns the name of the founder
     *
     * @return string $founderName
     */
    public function getFounderName(): string
    {
        return $this->founderName;
    }


    /**
     * Sets the founderName
     *
     * @param string $founderName
     * @return void
     */
    public function setFounderName(string $founderName): void
    {
        $this->founderName = $founderName;
    }


    /**
     * Returns the address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }


    /**
     * Sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }


    /**
     * Returns the zip
     *
     * @return int $zip
     */
    public function getZip(): int
    {
        return $this->zip;
    }


    /**
     * Sets the zip
     *
     * @param int $zip
     * @return void
     */
    public function setZip(int $zip): void
    {
        $this->zip = $zip;
    }


    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity(): string
    {
        return $this->city;
    }


    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }


    /**
     * Returns the foundationDate
     *
     * @return string
     */
    public function getFoundationDate(): string
    {
        return $this->foundationDate;
    }


    /**
     * Sets the foundationDate
     *
     * @param string $foundationDate
     * @return void
     */
    public function setFoundationDate(string $foundationDate): void
    {
        $this->foundationDate = $foundationDate;
    }


    /**
     * Returns the intendedFoundationDate
     *
     * @return string
     */
    public function getIntendedFoundationDate(): string
    {
        return $this->intendedFoundationDate;
    }


    /**
     * Sets the intendedFoundationDate
     *
     * @param string $intendedFoundationDate
     * @return void
     */
    public function setIntendedFoundationDate(string $intendedFoundationDate): void
    {
        $this->intendedFoundationDate = $intendedFoundationDate;
    }


    /**
     * Returns the citizenship
     *
     * @return string $citizenship
     */
    public function getCitizenship(): string
    {
        return $this->citizenship;
    }


    /**
     * Sets the citizenship
     *
     * @param string $citizenship
     * @return void
     */
    public function setCitizenship(string $citizenship): void
    {
        $this->citizenship = $citizenship;
    }


    /**
     * Returns the birthdate
     *
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }


    /**
     * Sets the birthdate
     *
     * @param string $birthdate
     * @return void
     */
    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = $birthdate;
    }


    /**
     * Returns the foundationLocation
     *
     * @return string
     */
    public function getFoundationLocation(): string
    {
        return $this->foundationLocation;
    }

    /**
     * Sets the foundationLocation
     *
     * @param string $foundationLocation
     * @return void
     */
    public function setFoundationLocation(string $foundationLocation): void
    {
        $this->foundationLocation = $foundationLocation;
    }


    /**
     * Returns the sales
     *
     * @return string
     */
    public function getSales(): string
    {
        return $this->sales;
    }


    /**
     * Sets the sales
     *
     * @param string $sales
     * @return void
     */
    public function setSales(string $sales): void
    {
        $this->sales = $sales;
    }


    /**
     * Returns the balance
     *
     * @return string
     */
    public function getBalance(): string
    {
        return $this->balance;
    }


    /**
     * Sets the balance
     *
     * @param string $balance
     * @return void
     */
    public function setBalance(string $balance): void
    {
        $this->balance = $balance;
    }


    /**
     * Returns the employeesCount
     *
     * @return int
     */
    public function getEmployeesCount(): int
    {
        return $this->employeesCount;
    }


    /**
     * Sets the employeesCount
     *
     * @param int $employeesCount
     * @return void
     */
    public function setEmployeesCount(int $employeesCount): void
    {
        $this->employeesCount = $employeesCount;
    }


    /**
     * Returns the manager
     *
     * @return string
     */
    public function getManager(): string
    {
        return $this->manager;
    }


    /**
     * Sets the manager
     *
     * @param string $manager
     * @return void
     */
    public function setManager(string $manager): void
    {
        $this->manager = $manager;
    }


    /**
     * Returns the singleRepresentative
     *
     * @return int
     *  @todo isn't this a boolean?
     */
    public function getSingleRepresentative(): int
    {
        return $this->singleRepresentative;
    }


    /**
     * Sets the singleRepresentative
     *
     * @param int $singleRepresentative
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setSingleRepresentative(int $singleRepresentative): void
    {
        $this->singleRepresentative = $singleRepresentative;
    }


    /**
     * Returns the preTaxDeduction
     *
     * @return int
     *  @todo isn't this a boolean?
     */
    public function getPreTaxDeduction(): int
    {
        return $this->preTaxDeduction;
    }


    /**
     * Sets the preTaxDeduction
     *
     * @param int $preTaxDeduction
     * @return void
     */
    public function setPreTaxDeduction(bool $preTaxDeduction): void
    {
        $this->preTaxDeduction = $preTaxDeduction;
    }


    /**
     * Returns the businessPurpose
     *
     * @return string $businessPurpose
     */
    public function getBusinessPurpose(): string
    {
        return $this->businessPurpose;
    }


    /**
     * Sets the businessPurpose
     *
     * @param string $businessPurpose
     * @return void
     */
    public function setBusinessPurpose(string $businessPurpose): void
    {
        $this->businessPurpose = $businessPurpose;
    }


    /**
     * Returns the insolvencyProceedings
     *
     * @return int
     *  @todo isn't this a boolean?
     */
    public function getInsolvencyProceedings(): int
    {
        return $this->insolvencyProceedings;
    }


    /**
     * Sets the insolvencyProceedings
     *
     * @param int $insolvencyProceedings
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setInsolvencyProceedings(int $insolvencyProceedings): void
    {
        $this->insolvencyProceedings = $insolvencyProceedings;
    }


    /**
     * Returns the chamber
     *
     * @return int
     */
    public function getChamber(): int
    {
        return $this->chamber;
    }


    /**
     * Sets the chamber
     *
     * @param int $chamber
     * @return void
     */
    public function setChamber(int $chamber): void
    {
        $this->chamber = $chamber;
    }


    /**
     * Returns the companyShares
     *
     * @return string
     */
    public function getCompanyShares(): string
    {
        return $this->companyShares;
    }


    /**
     * Sets the companyShares
     *
     * @param string $companyShares
     * @return void
     */
    public function setCompanyShares(string $companyShares): void
    {
        $this->companyShares = $companyShares;
    }


    /**
     * Returns the principalBank
     *
     * @return string
     */
    public function getPrincipalBank(): string
    {
        return $this->principalBank;
    }


    /**
     * Sets the principalBank
     *
     * @param string $principalBank
     * @return void
     */
    public function setPrincipalBank(string $principalBank): void
    {
        $this->principalBank = $principalBank;
    }


    /**
     * Returns the bic
     *
     * @return string $bic
     */
    public function getBic(): string
    {
        return $this->bic;
    }


    /**
     * Sets the bic
     *
     * @param string $bic
     * @return void
     */
    public function setBic(string $bic): void
    {
        $this->bic = $bic;
    }


    /**
     * Returns the iban
     *
     * @return string $iban
     */
    public function getIban(): string
    {
        return $this->iban;
    }


    /**
     * Sets the iban
     *
     * @param string $iban
     * @return void
     */
    public function setIban(string $iban): void
    {
        $this->iban = str_replace(' ', '', $iban);
    }


    /**
     * Returns the contactPersonName
     *
     * @return string
     */
    public function getContactPersonName(): string
    {
        return $this->contactPersonName;
    }


    /**
     * Sets the contactPersonName
     *
     * @param string $contactPersonName
     * @return void
     */
    public function setContactPersonName(string $contactPersonName): void
    {
        $this->contactPersonName = $contactPersonName;
    }


    /**
     * Returns the contactPersonPhone
     *
     * @return string
     */
    public function getContactPersonPhone(): string
    {
        return $this->contactPersonPhone;
    }


    /**
     * Sets the contactPersonPhone
     *
     * @param string $contactPersonPhone
     * @return void
     */
    public function setContactPersonPhone(string $contactPersonPhone): void
    {
        $this->contactPersonPhone = $contactPersonPhone;
    }


    /**
     * Returns the contactPersonFax
     *
     * @return string
     */
    public function getContactPersonFax(): string
    {
        return $this->contactPersonFax;
    }


    /**
     * Sets the contactPersonFax
     *
     * @param string $contactPersonFax
     * @return void
     */
    public function setContactPersonFax(string $contactPersonFax): void
    {
        $this->contactPersonFax = $contactPersonFax;
    }


    /**
     * Returns the contactPersonMobile
     *
     * @return string
     */
    public function getContactPersonMobile(): string
    {
        return $this->contactPersonMobile;
    }


    /**
     * Sets the contactPersonMobile
     *
     * @param string $contactPersonMobile
     * @return void
     */
    public function setContactPersonMobile(string $contactPersonMobile): void
    {
        $this->contactPersonMobile = $contactPersonMobile;
    }


    /**
     * Returns the contactPersonEmail
     *
     * @return string
     */
    public function getContactPersonEmail(): string
    {
        return $this->contactPersonEmail;
    }


    /**
     * Sets the contactPersonEmail
     *
     * @param string $contactPersonEmail
     * @return void
     */
    public function setContactPersonEmail(string $contactPersonEmail): void
    {
        $this->contactPersonEmail = $contactPersonEmail;
    }


    /**
     * Returns the preFoundationEmployment
     *
     * @return int
     */
    public function getPreFoundationEmployment(): int
    {
        return $this->preFoundationEmployment;
    }

    /**
     * Sets the preFoundationEmployment
     *
     * @param int $preFoundationEmployment
     * @return void
     */
    public function setPreFoundationEmployment(int $preFoundationEmployment): void
    {
        $this->preFoundationEmployment = $preFoundationEmployment;
    }


    /**
     * Returns the preFoundationSelfEmployment
     *
     * @return int
     */
    public function getPreFoundationSelfEmployment(): int
    {
        return $this->preFoundationSelfEmployment;
    }


    /**
     * Sets the preFoundationSelfEmployment
     *
     * @param int $preFoundationSelfEmployment
     * @return void
     */
    public function setPreFoundationSelfEmployment(int $preFoundationSelfEmployment): void
    {
        $this->preFoundationSelfEmployment = $preFoundationSelfEmployment;
    }


    /**
     * Returns the consultingDays
     *
     * @return int
     */
    public function getConsultingDays(): int
    {
        return $this->consultingDays;
    }

    /**
     * Sets the consultingDays
     *
     * @param int $consultingDays
     * @return void
     */
    public function setConsultingDays(int $consultingDays): void
    {
        $this->consultingDays = $consultingDays;
    }


    /**
     * Returns the consultingDateFrom
     *
     * @return string
     */
    public function getConsultingDateFrom(): string
    {
        return $this->consultingDateFrom;
    }


    /**
     * Sets the consultingDateFrom
     *
     * @param string $consultingDateFrom
     * @return void
     */
    public function setConsultingDateFrom(string $consultingDateFrom): void
    {
        $this->consultingDateFrom = $consultingDateFrom;
    }


    /**
     * Returns the consultingDateTo
     *
     * @return string
     */
    public function getConsultingDateTo(): string
    {
        return $this->consultingDateTo;
    }

    /**
     * Sets the consultingDateTo
     *
     * @param string $consultingDateTo
     * @return void
     */
    public function setConsultingDateTo(string $consultingDateTo): void
    {
        $this->consultingDateTo = $consultingDateTo;
    }


    /**
     * Returns the consultingContent
     *
     * @return string $consultingContent
     */
    public function getConsultingContent(): string
    {
        return $this->consultingContent;
    }


    /**
     * Sets the consultingContent
     *
     * @param string $consultingContent
     * @return void
     */
    public function setConsultingContent(string $consultingContent): void
    {
        $this->consultingContent = $consultingContent;
    }


    /**
     * Returns the consultantType
     *
     * @return int
     */
    public function getConsultantType(): int
    {
        return $this->consultantType;
    }


    /**
     * Sets the consultantType
     *
     * @param int $consultantType
     * @return void
     */
    public function setConsultantType(int $consultantType): void
    {
        $this->consultantType = $consultantType;
    }


    /**
     * Returns the consultantCompany
     *
     * @return string $consultantCompany
     */
    public function getConsultantCompany(): string
    {
        return $this->consultantCompany;
    }


    /**
     * Sets the consultantCompany
     *
     * @param string $consultantCompany
     * @return void
     */
    public function setConsultantCompany(string $consultantCompany): void
    {
        $this->consultantCompany = $consultantCompany;
    }


    /**
     * Returns the consultantName1
     *
     * @return string
     */
    public function getConsultantName1(): string
    {
        return $this->consultantName1;
    }


    /**
     * Sets the consultantName1
     *
     * @param string $consultantName1
     * @return void
     */
    public function setConsultantName1(string $consultantName1): void
    {
        $this->consultantName1 = $consultantName1;
    }


    /**
     * Returns the consultantName2
     *
     * @return string
     */
    public function getConsultantName2(): string
    {
        return $this->consultantName2;
    }


    /**
     * Sets the consultantName2
     *
     * @param string $consultantName2
     * @return void
     */
    public function setConsultantName2(string $consultantName2): void
    {
        $this->consultantName2 = $consultantName2;
    }


    /**
     * Returns the consultant1AccreditationNumber
     *
     * @return string
     */
    public function getConsultant1AccreditationNumber(): string
    {
        return $this->consultant1AccreditationNumber;
    }


    /**
     * Sets the consultant1AccreditationNumber
     *
     * @param string $consultant1AccreditationNumber
     * @return void
     */
    public function setConsultant1AccreditationNumber(string $consultant1AccreditationNumber): void
    {
        $this->consultant1AccreditationNumber = $consultant1AccreditationNumber;
    }


    /**
     * Returns the consultant2AccreditationNumber
     *
     * @return string
     */
    public function getConsultant2AccreditationNumber(): string
    {
        return $this->consultant2AccreditationNumber;
    }


    /**
     * Sets the consultant2AccreditationNumber
     *
     * @param string $consultant2AccreditationNumber
     * @return void
     */
    public function setConsultant2AccreditationNumber(string $consultant2AccreditationNumber): void
    {
        $this->consultant2AccreditationNumber = $consultant2AccreditationNumber;
    }


    /**
     * Returns the consultantFee
     *
     * @return string
     */
    public function getConsultantFee(): string
    {
        return $this->consultantFee;
    }


    /**
     * Sets the consultantFee
     *
     * @param string $consultantFee
     * @return void
     */
    public function setConsultantFee(string $consultantFee): void
    {
        $this->consultantFee = $consultantFee;
    }


    /**
     * Returns the consultantPhone
     *
     * @return string
     */
    public function getConsultantPhone(): string
    {
        return $this->consultantPhone;
    }


    /**
     * Sets the consultantPhone
     *
     * @param string $consultantPhone
     * @return void
     */
    public function setConsultantPhone(string $consultantPhone): void
    {
        $this->consultantPhone = $consultantPhone;
    }


    /**
     * Returns the consultantEmail
     *
     * @return string
     */
    public function getConsultantEmail(): string
    {
        return $this->consultantEmail;
    }


    /**
     * Sets the consultantEmail
     *
     * @param string $consultantEmail
     * @return void
     */
    public function setConsultantEmail(string $consultantEmail): void
    {
        $this->consultantEmail = $consultantEmail;
    }


    /**
     * Returns the prematureStart
     *
     * @return int $prematureStart
     *  @todo isn't this a boolean?
     */
    public function getPrematureStart(): int
    {
        return $this->prematureStart;
    }


    /**
     * Sets the prematureStart
     *
     * @param int $prematureStart
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setPrematureStart(int $prematureStart): void
    {
        $this->prematureStart = $prematureStart;
    }


    /**
     * Returns the file
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getFile(): ObjectStorage
    {
        return $this->file;
    }


    /**
     * Sets the file
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $file
     * @return void
     */
    public function setFile(ObjectStorage $file): void
    {
        $this->file = $file;
    }


    /**
     * Adds a file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function addFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file): void
    {
        $this->file->attach($file);
    }


    /**
     * Removes a file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     * @api
     */
    public function removeFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file): void
    {
        $this->file->detach($file);
    }


    /**
     * Returns the fileUpload
     * ### only for form upload ###
     *
     * @return array $fileUpload
     */
    public function getFileUpload(): array
    {
        return $this->fileUpload;
    }


    /**
     * Sets the fileUpload
     * ### only for form upload ###
     *
     * @param array $fileUpload
     * @return void
     */
    public function setFileUpload(array $fileUpload): void
    {
        $this->fileUpload = $fileUpload;
    }


    /**
     * Returns the sendDocuments
     *
     * @return int
     */
    public function getSendDocuments(): int
    {
        return $this->sendDocuments;
    }


    /**
     * Sets the sendDocuments
     *
     * @param int $sendDocuments
     * @return void
     */
    public function setSendDocuments(int $sendDocuments): void
    {
        $this->sendDocuments = $sendDocuments;
    }


    /**
     * Returns the bafaSupport
     *
     * @return int
     *  @todo isn't this a boolean?
     */
    public function getBafaSupport(): int
    {
        return $this->bafaSupport;
    }


    /**
     * Sets the bafaSupport
     *
     * @param int $bafaSupport
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setBafaSupport(int $bafaSupport): void
    {
        $this->bafaSupport = $bafaSupport;
    }


    /**
     * Returns the deMinimis
     *
     * @return int
     *  @todo isn't this a boolean?
     */
    public function getDeMinimis(): int
    {
        return $this->deMinimis;
    }


    /**
     * Sets the deMinimis
     *
     * @param int $deMinimis
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setDeMinimis(int $deMinimis): void
    {
        $this->deMinimis = $deMinimis;
    }


    /**
     * Returns the existenzGruenderPass
     *
     * @return int
     *  @todo isn't this a boolean?
     */
    public function getExistenzGruenderPass(): int
    {
        return $this->existenzGruenderPass;
    }


    /**
     * Sets the existenzGruenderPass
     *
     * @param int $existenzGruenderPass
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setExistenzGruenderPass(int $existenzGruenderPass): void
    {
        $this->existenzGruenderPass = $existenzGruenderPass;
    }


    /**
     * Returns the privacy
     *
     * @return int $privacy
     *  @todo isn't this a boolean?
     */
    public function getPrivacy(): int
    {
        return $this->privacy;
    }


    /**
     * Sets the privacy
     *
     * @param int $privacy
     * @return void
     *  @todo isn't this a boolean?
     */
    public function setPrivacy(int $privacy): void
    {
        $this->privacy = $privacy;
    }


    /**
     * Returns the supportProgramme
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Program
     */
    public function getSupportProgramme():? Program
    {
        return $this->supportProgramme;
    }


    /**
     * Sets the supportProgramme
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme
     * @return void
     */
    public function setSupportProgramme(Program $supportProgramme): void
    {
        $this->supportProgramme = $supportProgramme;
    }


    /**
     * Returns the consulting
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting
     */
    public function getConsulting():? Consulting
    {
        return $this->consulting;
    }


    /**
     * Sets the consulting
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting
     * @return void
     */
    public function setConsulting(Consulting $consulting): void
    {
        $this->consulting = $consulting;
    }


    /**
     * Returns the companytype
     *
     * @return \RKW\RkwBasics\Domain\Model\CompanyType
     */
    public function getCompanytype():? CompanyType
    {
        return $this->companytype;
    }


    /**
     * Sets the companytype
     *
     * @param \RKW\RkwBasics\Domain\Model\CompanyType $companytype
     * @return void
     */
    public function setCompanytype(CompanyType $companytype): void
    {
        $this->companytype = $companytype;
    }


    /**
     * Transforms date strings to DateTime object
     *
     * @return void
     */
    public function transformDates(): void
    {
        $this->foundationDate = $this->transformDate($this->foundationDate);
        $this->intendedFoundationDate = $this->transformDate($this->intendedFoundationDate);
        $this->birthdate = $this->transformDate($this->birthdate);
    }


    /**
     * Transforms date string to timestamp
     *
     * @param string $dateString
     * @return int
     */
    protected function transformDate(string $dateString): int
    {
        if ($dateTime = \DateTime::createFromFormat('d.m.Y', $dateString)) {
            return $dateTime->getTimestamp();
        }

        return $dateString;
    }

}
