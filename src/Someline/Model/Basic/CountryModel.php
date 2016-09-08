<?php namespace Someline\Model\Basic;

/**
 * Created for someline-starter.
 * User: Libern
 */

use Countries;

class CountryModel
{

    const COUNTRY_CHINA = 'CN';
    const COUNTRY_SINGAPORE = 'SG';
    const COUNTRY_UNITED_STATES = 'US';
    const CURRENT_USER_COUNTRY_KEY = 'Country.CurrentUser';

    public static $fallback_country = self::COUNTRY_UNITED_STATES;

    public static $all_available_countries = [
        self::COUNTRY_SINGAPORE,
        self::COUNTRY_CHINA,
        self::COUNTRY_UNITED_STATES,
    ];

    public static $nexmo_supported_country_calling_codes = [
        'AD' => '+376',
        'AE' => '+971',
        'AF' => '+93',
        'AG' => '+1268',
        'AI' => '+1264',
        'AL' => '+355',
        'AM' => '+374',
        'AO' => '+244',
        'AR' => '+54',
        'AT' => '+43',
        'AU' => '+61',
        'AW' => '+297',
        'AZ' => '+994',
        'BA' => '+387',
        'BB' => '+1246',
        'BD' => '+880',
        'BE' => '+32',
        'BF' => '+226',
        'BG' => '+359',
        'BH' => '+973',
        'BI' => '+257',
        'BJ' => '+229',
        'BM' => '+1441',
        'BN' => '+673',
        'BO' => '+591',
        'BQ' => '+599',
        'BR' => '+55',
        'BS' => '+1242',
        'BT' => '+975',
        'BW' => '+267',
        'BY' => '+375',
        'BZ' => '+501',
        'CA' => '+1',
        'CD' => '+243',
        'CF' => '+236',
        'CG' => '+242',
        'CH' => '+41',
        'CI' => '+225',
        'CK' => '+682',
        'CL' => '+56',
        'CM' => '+237',
        'CN' => '+86',
        'CO' => '+57',
        'CR' => '+506',
        'CU' => '+53',
        'CV' => '+238',
        'CW' => '+599',
        'CY' => '+357',
        'CZ' => '+420',
        'DE' => '+49',
        'DJ' => '+253',
        'DK' => '+45',
        'DM' => '+1767',
        'DO' => '+1809',
        'DZ' => '+213',
        'EC' => '+593',
        'EE' => '+372',
        'EG' => '+20',
        'ES' => '+34',
        'ET' => '+251',
        'FI' => '+358',
        'FJ' => '+679',
        'FO' => '+298',
        'FR' => '+33',
        'GA' => '+241',
        'GB' => '+44',
        'GD' => '+1473',
        'GE' => '+995',
        'GF' => '+594',
        'GH' => '+233',
        'GI' => '+350',
        'GL' => '+299',
        'GM' => '+220',
        'GN' => '+224',
        'GP' => '+590',
        'GQ' => '+240',
        'GR' => '+30',
        'GT' => '+502',
        'GU' => '+1671',
        'GW' => '+245',
        'GY' => '+592',
        'HK' => '+852',
        'HN' => '+504',
        'HR' => '+385',
        'HT' => '+509',
        'HU' => '+36',
        'ID' => '+62',
        'IE' => '+353',
        'IL' => '+972',
        'IN' => '+91',
        'IQ' => '+964',
        'IR' => '+98',
        'IS' => '+354',
        'IT' => '+39',
        'JM' => '+1876',
        'JO' => '+962',
        'JP' => '+81',
        'KE' => '+254',
        'KG' => '+996',
        'KH' => '+855',
        'KI' => '+686',
        'KM' => '+269',
        'KN' => '+1869',
        'KR' => '+82',
        'KW' => '+965',
        'KY' => '+1345',
        'KZ' => '+7',
        'LA' => '+856',
        'LB' => '+961',
        'LC' => '+1758',
        'LI' => '+423',
        'LK' => '+94',
        'LR' => '+231',
        'LS' => '+266',
        'LT' => '+370',
        'LU' => '+352',
        'LV' => '+371',
        'LY' => '+218',
        'MA' => '+212',
        'MC' => '+377',
        'MD' => '+373',
        'ME' => '+382',
        'MG' => '+261',
        'MK' => '+389',
        'ML' => '+223',
        'MM' => '+95',
        'MN' => '+976',
        'MO' => '+853',
        'MQ' => '+596',
        'MR' => '+222',
        'MS' => '+1664',
        'MT' => '+356',
        'MU' => '+230',
        'MV' => '+960',
        'MW' => '+265',
        'MX' => '+52',
        'MY' => '+60',
        'MZ' => '+258',
        'NA' => '+264',
        'NC' => '+687',
        'NE' => '+227',
        'NG' => '+234',
        'NI' => '+505',
        'NL' => '+31',
        'NO' => '+47',
        'NP' => '+977',
        'NZ' => '+64',
        'OM' => '+968',
        'PA' => '+507',
        'PE' => '+51',
        'PF' => '+689',
        'PG' => '+675',
        'PH' => '+63',
        'PK' => '+92',
        'PL' => '+48',
        'PM' => '+508',
        'PR' => '+1787',
        'PS' => '+970',
        'PT' => '+351',
        'PW' => '+680',
        'PY' => '+595',
        'QA' => '+974',
        'RE' => '+262',
        'RO' => '+40',
        'RS' => '+381',
        'RU' => '+7',
        'RW' => '+250',
        'SA' => '+966',
        'SB' => '+677',
        'SC' => '+248',
        'SD' => '+249',
        'SE' => '+46',
        'SG' => '+65',
        'SI' => '+386',
        'SK' => '+421',
        'SL' => '+232',
        'SM' => '+378',
        'SN' => '+221',
        'SO' => '+252',
        'SR' => '+597',
        'SS' => '+211',
        'ST' => '+239',
        'SV' => '+503',
        'SX' => '+1721',
        'SY' => '+963',
        'SZ' => '+268',
        'TC' => '+1649',
        'TD' => '+235',
        'TG' => '+228',
        'TH' => '+66',
        'TJ' => '+992',
        'TL' => '+670',
        'TM' => '+993',
        'TN' => '+216',
        'TO' => '+676',
        'TR' => '+90',
        'TT' => '+1868',
        'TW' => '+886',
        'TZ' => '+255',
        'UA' => '+380',
        'UG' => '+256',
        'US' => '+1',
        'UY' => '+598',
        'UZ' => '+998',
        'VC' => '+1784',
        'VE' => '+58',
        'VG' => '+1284',
        'VI' => '+1340',
        'VN' => '+84',
        'VU' => '+678',
        'WS' => '+685',
        'YE' => '+967',
        'YT' => '+269',
        'ZA' => '+27',
        'ZM' => '+260',
        'ZW' => '+263',
    ];

    public static $country_calling_codes = array(
        'AF' => '+93',
        'AX' => '+358',
        'AL' => '+355',
        'DZ' => '+213',
        'AS' => '+1',
        'AD' => '+376',
        'AO' => '+244',
        'AI' => '+1',
        'AQ' => '+672',
        'AG' => '+1',
        'AR' => '+54',
        'AM' => '+374',
        'AW' => '+297',
        'SH' => '+247',
        'AU' => '+61',
        'AT' => '+43',
        'AZ' => '+994',
        'BS' => '+1',
        'BH' => '+973',
        'BD' => '+880',
        'BB' => '+1',
        'BY' => '+375',
        'BE' => '+32',
        'BZ' => '+501',
        'BJ' => '+229',
        'BM' => '+1',
        'BT' => '+975',
        'BO' => '+591',
        'BQ' => '+599',
        'BA' => '+387',
        'BW' => '+267',
        'BV' => '+47',
        'BR' => '+55',
        'IO' => '+246',
        'BN' => '+673',
        'BG' => '+359',
        'BF' => '+226',
        'BI' => '+257',
        'KH' => '+855',
        'CM' => '+237',
        'CA' => '+1',
        'CV' => '+238',
        'KY' => '+1',
        'CF' => '+236',
        'TD' => '+235',
        'CL' => '+56',
        'CN' => '+86',
        'CX' => '+61',
        'CC' => '+891',
        'CO' => '+57',
        'KM' => '+269',
        'CD' => '+243',
        'CG' => '+242',
        'CK' => '+682',
        'CR' => '+506',
        'CI' => '+225',
        'HR' => '+385',
        'CU' => '+53',
        'CW' => '+599',
        'CY' => '+357',
        'CZ' => '+420',
        'DK' => '+45',
        'DJ' => '+253',
        'DM' => '+1',
        'DO' => '+1',
        'TL' => '+670',
        'EC' => '+593',
        'EG' => '+20',
        'SV' => '+503',
        'GQ' => '+240',
        'ER' => '+291',
        'EE' => '+372',
        'ET' => '+251',
        'FK' => '+500',
        'FO' => '+298',
        'FJ' => '+679',
        'FI' => '+358',
        'FR' => '+33',
        'GF' => '+594',
        'PF' => '+689',
        'TF' => '+262',
        'GA' => '+241',
        'GM' => '+220',
        'GE' => '+995',
        'DE' => '+49',
        'GH' => '+233',
        'GI' => '+350',
        'GR' => '+30',
        'GL' => '+299',
        'GD' => '+1',
        'GP' => '+590',
        'GU' => '+1',
        'GT' => '+502',
        'GG' => '+44',
        'GN' => '+224',
        'GW' => '+245',
        'GY' => '+592',
        'HT' => '+509',
        'HM' => '+61',
        'VA' => '+379',
        'HN' => '+504',
        'HK' => '+852',
        'HU' => '+36',
        'IS' => '+354',
        'IN' => '+91',
        'ID' => '+62',
        'IQ' => '+964',
        'IR' => '+98',
        'IE' => '+353',
        'IM' => '+44',
        'IL' => '+972',
        'IT' => '+39',
        'JM' => '+1',
        'JP' => '+81',
        'JE' => '+44',
        'JO' => '+962',
        'KZ' => '+7',
        'KE' => '+254',
        'KI' => '+686',
        'KP' => '+850',
        'KR' => '+82',
        'XK' => '+377',
        'XK_2' => '381',
        'XK_3' => '386',
        'KW' => '+965',
        'KG' => '+996',
        'LA' => '+856',
        'LV' => '+371',
        'LB' => '+961',
        'LS' => '+266',
        'LR' => '+231',
        'LY' => '+218',
        'LI' => '+423',
        'LT' => '+370',
        'LU' => '+352',
        'MO' => '+853',
        'MK' => '+389',
        'MG' => '+261',
        'MW' => '+265',
        'MY' => '+60',
        'MV' => '+960',
        'ML' => '+223',
        'MT' => '+356',
        'MH' => '+692',
        'MQ' => '+596',
        'MR' => '+222',
        'MU' => '+230',
        'YT' => '+262',
        'MX' => '+52',
        'FM' => '+691',
        'MD' => '+373',
        'MC' => '+377',
        'MN' => '+976',
        'ME' => '+382',
        'MS' => '+1',
        'MA' => '+212',
        'MZ' => '+258',
        'MM' => '+95',
        'NA' => '+264',
        'NR' => '+674',
        'NL' => '+31',
        'BQ' => '+599',
        'NP' => '+977',
        'NC' => '+687',
        'NZ' => '+64',
        'NI' => '+505',
        'NE' => '+227',
        'NG' => '+234',
        'NU' => '+683',
        'NF' => '+672',
        'GB' => '+44',
        'GB_2' => '+28',
        'MP' => '+1',
        'NO' => '+47',
        'OM' => '+968',
        'PK' => '+92',
        'PW' => '+680',
        'PS' => '+970',
        'PA' => '+507',
        'PG' => '+675',
        'PY' => '+595',
        'PE' => '+51',
        'PH' => '+63',
        'PN' => '+64',
        'PL' => '+48',
        'PT' => '+351',
        'PR' => '+1',
        'QA' => '+974',
        'RE' => '+262',
        'RO' => '+40',
        'RU' => '+7',
        'RW' => '+250',
        'BL' => '+590',
        'SH' => '+290',
        'KN' => '+1',
        'LC' => '+1',
        'MF' => '+590',
        'PM' => '+508',
        'VC' => '+1',
        'WS' => '+685',
        'SM' => '+378',
        'ST' => '+239',
        'SA' => '+966',
        'SN' => '+221',
        'RS' => '+381',
        'SC' => '+248',
        'SL' => '+232',
        'SX' => '+1',
        'SG' => '+65',
        'SK' => '+421',
        'SI' => '+386',
        'SB' => '+677',
        'SO' => '+252',
        'ZA' => '+27',
        'GS' => '+500',
        'SS' => '+211',
        'ES' => '+34',
        'LK' => '+94',
        'SD' => '+249',
        'SR' => '+597',
        'SJ' => '+47',
        'SZ' => '+268',
        'SE' => '+46',
        'CH' => '+41',
        'SY' => '+963',
        'TW' => '+886',
        'TJ' => '+992',
        'TZ' => '+255',
        'TH' => '+66',
        'TL' => '+670',
        'TG' => '+228',
        'TK' => '+690',
        'TO' => '+676',
        'TT' => '+1',
        'TN' => '+216',
        'TR' => '+90',
        'TM' => '+993',
        'TC' => '+1',
        'TV' => '+688',
        'UG' => '+256',
        'UA' => '+380',
        'AE' => '+971',
        'GB' => '+44',
        'US' => '+1',
        'UM' => '+1',
        'UY' => '+598',
        'UZ' => '+998',
        'VU' => '+678',
        'VE' => '+58',
        'VN' => '+84',
        'VG' => '+1',
        'VI' => '+1',
        'WF' => '+681',
        'EH' => '+212',
        'YE' => '+967',
        'ZM' => '+260',
        'ZW' => '+263'
    );

    public static function countriesToString(array $countries)
    {
        if (empty($countries)) {
            return "";
        }

        return implode(',', $countries);
    }

    public static function countriesFromString($countries_string)
    {
        if (empty($countries_string)) {
            return [];
        }

        return explode(',', $countries_string);
    }

    public static function getCountryList(array $countries = null, $locale = 'en')
    {
        $country_list = Countries::getList($locale, 'php', 'cldr');

        if (empty($countries)) {
            return $country_list;
        } else {
            return array_intersect_key($country_list, array_flip($countries));
        }
    }

    public static function getCountryISOCodeList()
    {
        $country_list = self::getCountryList();
        $country_iso_list = array_keys($country_list);
        return $country_iso_list;
    }

    public static function getLocalizedCountryList(array $countries = null)
    {
        $locale = 'en';
        $app_locale = app_locale();
        if ($app_locale == 'cn') {
            $locale = 'zh';
        }
        return self::getCountryList($countries, $locale);
    }

    public static function getCountryCallingCodeList(array $countries = null)
    {
//        $country_calling_code_list = self::$country_calling_codes;
        $country_calling_code_list = self::$nexmo_supported_country_calling_codes;

        if (empty($countries)) {
            return $country_calling_code_list;
        } else {
            return array_intersect_key($country_calling_code_list, array_flip($countries));
        }
    }

    public static function getCountryInfo($country_code = null)
    {
        if (empty($country_code)) {
            $country_code = self::getCurrentUserCountry();
        }

        $countryInfoList = self::getCountryInfoIndexedList();
        if (isset($countryInfoList[$country_code])) {
            return $countryInfoList[$country_code];
        } else {
            return null;
        }
    }

    public static function getCountryInfoList()
    {
        $countryCallingCodeList = self::getCountryCallingCodeList();
        $country_iso_codes = array_keys($countryCallingCodeList);
        $country_list_en = self::getCountryList($country_iso_codes);
        $country_list_locale = self::getLocalizedCountryList($country_iso_codes);
        $country_info_list = [];
        foreach ($country_iso_codes as $country_iso_code) {
            $country_info = [];
            if (empty($country_list_en[$country_iso_code])
                || empty($country_list_locale[$country_iso_code])
            ) {
                continue;
            } else {
                $country_info['country_code'] = $country_iso_code;
                $country_info['name'] = $country_list_en[$country_iso_code];
                $country_info['locale_name'] = $country_list_locale[$country_iso_code];
                $country_info['calling_code'] = $countryCallingCodeList[$country_iso_code];
                $country_info_list[] = $country_info;
            }
        }
        return $country_info_list;
    }

    public static function getCountryInfoIndexedList()
    {
        $countryCallingCodeList = self::getCountryCallingCodeList();
        $country_iso_codes = array_keys($countryCallingCodeList);
        $country_list_en = self::getCountryList($country_iso_codes);
        $country_list_locale = self::getLocalizedCountryList($country_iso_codes);
        $country_info_list = [];
        foreach ($country_iso_codes as $country_iso_code) {
            $country_info = [];
            if (empty($country_list_en[$country_iso_code])
                || empty($country_list_locale[$country_iso_code])
            ) {
                continue;
            } else {
                $country_info['country_code'] = $country_iso_code;
                $country_info['name'] = $country_list_en[$country_iso_code];
                $country_info['locale_name'] = $country_list_locale[$country_iso_code];
                $country_info['calling_code'] = $countryCallingCodeList[$country_iso_code];
                $country_info_list[$country_iso_code] = $country_info;
            }
        }
        return $country_info_list;
    }

    public static function setCurrentUserCountry($country)
    {
        if (in_array($country, self::getCountryISOCodeList())) {
            \Session::put(self::CURRENT_USER_COUNTRY_KEY, $country);
        } else {
            \Log::warning("Invalid country [$country]");
            return false;
        }
    }

    public static function getCurrentUserCountry()
    {
        return \Session::get(self::CURRENT_USER_COUNTRY_KEY, self::$fallback_country);
    }

}