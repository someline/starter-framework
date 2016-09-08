<?php namespace Someline\Model\Basic;

/**
 * Created for someline-starter.
 * User: Libern
 */

use Illuminate\Contracts\Support\Arrayable;
use libphonenumber\CountryCodeSource;
use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberModel implements Arrayable
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    /**
     * @var PhoneNumber|null
     */
    private $phoneNumberProto;

    private $countryCodeSourcesText = [
        CountryCodeSource::FROM_DEFAULT_COUNTRY => 'FROM_DEFAULT_COUNTRY',
        CountryCodeSource::FROM_NUMBER_WITH_IDD => 'FROM_NUMBER_WITH_IDD',
        CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN => 'FROM_NUMBER_WITH_PLUS_SIGN',
        CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN => 'FROM_NUMBER_WITHOUT_PLUS_SIGN',
    ];

    private $phoneNumberTypesText = [
        PhoneNumberType::FIXED_LINE => 'FIXED_LINE',
        PhoneNumberType::FIXED_LINE_OR_MOBILE => 'FIXED_LINE_OR_MOBILE',
        PhoneNumberType::MOBILE => 'MOBILE',
        PhoneNumberType::EMERGENCY => 'EMERGENCY',
        PhoneNumberType::SHORT_CODE => 'SHORT_CODE',
        PhoneNumberType::UNKNOWN => 'UNKNOWN',
    ];

    /**
     * Fields from libphonenumber\PhoneNumber
     */
    public $country_code;                       // 65
    public $country_code_plus_sign;             // +65
    public $national_number;
    public $extension;
    public $country_code_source;                // 0
    public $country_code_source_text;           // FROM_NUMBER_WITH_PLUS_SIGN
    public $preferred_domestic_carrier_code;
    public $raw_input;
    public $raw_input_country;

    /**
     * Validation Results
     */
    public $is_possible_number = false;
    public $is_valid_number = false;
    public $is_mobile_number = false;
    public $region_code_for_number;     // SG
    public $number_type;                // 1
    public $number_type_text;           // MOBILE

    /**
     * From Formatting
     */
    public $format_e164;                // +6590919293
    public $format_national;            // 9091 9293
    public $format_international;       // +65 9091 9293
    public $format_rfc3966;             // tel:+65-9091-9293

    /**
     * From additional
     */
    public $description;                // Singapore
    public $carrier_name;               // M1
    public $timezones;                  // Asia/Singapore

    /**
     * PhoneNumberModel constructor.
     * @param string $phone_number
     * @param string $country_code An ISO 3166-1 two letter country code
     */
    public function __construct($phone_number, $country_code)
    {
        $this->phoneUtil = PhoneNumberUtil::getInstance();

        $this->phoneNumberProto = phone_parse($phone_number, $country_code);

        $this->raw_input_country = $country_code;

        $this->parse();
    }

    private function parse()
    {
        if ($this->phoneNumberProto) {
            // from phoneNumberProto
            $this->country_code = $this->phoneNumberProto->getCountryCode();
            $this->country_code_plus_sign = "+" . $this->country_code;
            $this->national_number = $this->phoneNumberProto->getNationalNumber();
            $this->extension = $this->phoneNumberProto->getExtension();
            $this->country_code_source = $this->phoneNumberProto->getCountryCodeSource();
            if (isset($this->countryCodeSourcesText[$this->country_code_source])) {
                $this->country_code_source_text = $this->countryCodeSourcesText[$this->country_code_source];
            }
            $this->raw_input = $this->phoneNumberProto->getRawInput();
            $this->preferred_domestic_carrier_code = $this->phoneNumberProto->getPreferredDomesticCarrierCode();

            // from validation
            $this->is_possible_number = $this->phoneUtil->isPossibleNumber($this->phoneNumberProto);
            $this->is_valid_number = $this->phoneUtil->isValidNumber($this->phoneNumberProto);
            $this->region_code_for_number = $this->phoneUtil->getRegionCodeForNumber($this->phoneNumberProto);
            $this->number_type = $this->phoneUtil->getNumberType($this->phoneNumberProto);
            $this->number_type_text = $this->phoneUtil->getNumberType($this->phoneNumberProto);
            if (isset($this->phoneNumberTypesText[$this->number_type])) {
                $this->number_type_text = $this->phoneNumberTypesText[$this->number_type];
            } else {
                $this->number_type_text = "OTHER";
            }
            $this->is_mobile_number = in_array($this->number_type, [
                PhoneNumberType::FIXED_LINE_OR_MOBILE,
                PhoneNumberType::MOBILE,
            ]);

            // from formatting
            $this->format_e164 = $this->phoneUtil->format($this->phoneNumberProto, PhoneNumberFormat::E164);
            $this->format_international = $this->phoneUtil->format($this->phoneNumberProto, PhoneNumberFormat::INTERNATIONAL);
            $this->format_national = $this->phoneUtil->format($this->phoneNumberProto, PhoneNumberFormat::NATIONAL);
            $this->format_rfc3966 = $this->phoneUtil->format($this->phoneNumberProto, PhoneNumberFormat::RFC3966);

            // from additional
            $phoneNumberOfflineGeocoder = PhoneNumberOfflineGeocoder::getInstance();
            $this->description = $phoneNumberOfflineGeocoder->getDescriptionForNumber($this->phoneNumberProto, 'en');

            $phoneNumberToCarrierMapper = PhoneNumberToCarrierMapper::getInstance();
            $this->carrier_name = $phoneNumberToCarrierMapper->getNameForNumber($this->phoneNumberProto, 'en');

            $phoneNumberToTimeZonesMapper = PhoneNumberToTimeZonesMapper::getInstance();
            $this->timezones = $phoneNumberToTimeZonesMapper->getTimeZonesForNumber($this->phoneNumberProto);
        }
    }

    public function isValid()
    {
        return $this->phoneNumberProto != null;
    }

    public function isValidNumberForRegion($country_code)
    {
        return $this->phoneUtil->isValidNumberForRegion($this->phoneNumber, $country_code);
    }

    public function isValidNumber()
    {
        return $this->is_valid_number;
    }

    public function isMobileNumber()
    {
        return $this->is_mobile_number;
    }

    public function __toString()
    {
        return (string)$this->phoneNumberProto;
    }

    public function equals(PhoneNumberModel $other)
    {
        if (empty($this->isValid()) || empty($other->isValid())) {
            return false;
        }
        return $this->phoneNumberProto->equals($other->phoneNumberProto);
    }

    public function toArray()
    {
        return [
            'country_code' => $this->country_code,
            'country_code_plus_sign' => $this->country_code_plus_sign,
            'national_number' => $this->national_number,
            'extension' => $this->extension,
            'country_code_source' => $this->country_code_source,
            'country_code_source_text' => $this->country_code_source_text,
            'preferred_domestic_carrier_code' => $this->preferred_domestic_carrier_code,
            'raw_input' => $this->raw_input,
            'raw_input_country' => $this->raw_input_country,

            'is_possible_number' => $this->is_possible_number,
            'is_valid_number' => $this->is_valid_number,
            'is_mobile_number' => $this->is_mobile_number,
            'region_code_for_number' => $this->region_code_for_number,
            'number_type' => $this->number_type,
            'number_type_text' => $this->number_type_text,

            'format_e164' => $this->format_e164,
            'format_national' => $this->format_national,
            'format_international' => $this->format_international,
            'format_rfc3966' => $this->format_rfc3966,

            'description' => $this->description,
            'carrier_name' => $this->carrier_name,
            'timezones' => $this->timezones,
        ];
    }

}