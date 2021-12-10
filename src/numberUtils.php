<?php
require_once __DIR__.'/config.php';

define('DEFAULT_EN_FORMAT',array(    
        "decimal_point" => '.',
        "thousands_sep" => ',',
        "int_curr_symbol" => '',
        "currency_symbol" => '$',
        "mon_decimal_point" => '.',
        "mon_thousands_sep" => ',',
        "positive_sign" => '',
        "negative_sign" => '-',
        "int_frac_digits" => 2,
        "frac_digits" => 2,
        "p_cs_precedes" => 1,
        "p_sep_by_space" => 0,
        "n_cs_precedes" => 1,
        "n_sep_by_space" => 0,
        "p_sign_posn" => 3,
        "n_sign_posn" => 3,
        "grouping" => array
        (
            "0" => 3
        ),
        
        "mon_grouping" => array
        (
            "0" => 3
        )
        
    ));

define('DEFAULT_FR_FORMAT',array(
    "decimal_point" => ',',
    "thousands_sep" => ' ',
    "int_curr_symbol" => '',
    "currency_symbol" => '$',
    "mon_decimal_point" => ',',
    "mon_thousands_sep" => '  ',
    "positive_sign" => '',
    "negative_sign" => '-',
    "int_frac_digits" => 2,
    "frac_digits" => 2,
    "p_cs_precedes" => 0,
    "p_sep_by_space" => 1,
    "n_cs_precedes" => 0,
    "n_sep_by_space" => 1,
    "p_sign_posn" => 1,
    "n_sign_posn" => 0,
    "grouping" => array
    (
        "0" => 3
    ),
    
    "mon_grouping" => array
    (
        "0" => 3
    )
    
));

function getLocale(){
    if(LEAGUE_LANG == 'FR') return DEFAULT_FR_FORMAT;
    
    return DEFAULT_EN_FORMAT;
}

//format_money_clean
function format_money($value, $format = '%n', bool $clean = false){
    
    if($clean) $value = preg_replace("/[^-0-9.]/", "", $value);

    return _format_money($format, $value);
}
//format_money_clean_no_dec
function format_money_no_dec($value, bool $clean = false){
    return format_money($value, '%.0n', $clean);
}

function format_number($value, $decimals=2, bool $clean = false){

    if($clean) $value = preg_replace("/[^-0-9.]/", "", $value);

    return _format_number($value,$decimals);
}

function _format_number($value, $decimals=2){
    $locale = getLocale();
    return utf8_encode(number_format($value,$decimals,
        $locale['decimal_point'],
        $locale['thousands_sep']));
}

function _format_money($format, $value) {
    
    $locale = getLocale();
    
    $regex = '/^'.             // start of expression
        '%'.              // % char
        '(?:'.            // start of optional flags
        '\=([\w\040])'.   // Flag =f
        '|'.
        '([\^])'.         // Flag ^
        '|'.
        '(\+|\()'.        // Flag + or (
        '|'.
        '(!)'.            // Flag !
        '|'.
        '(-)'.            // Flag -
        ')*'.             // End of optional flags
        '(?:([\d]+)?)'.   // W field width
        '(?:#([\d]+))?'.  // #n Precision accuracy
        '(?:\.([\d]+))?'. // .p Precision digits
        '([in%])'.        //conversion character
        '$/';             // Expression end
    
    if (!preg_match($regex, $format, $matches)) {
        trigger_error('Invalid format: '.$format, E_USER_WARNING);
        return $value;
    }
    

    $opcoes = array(
        'filler'   => ($matches[1] !== '') ? $matches[1] : ' ',
        'not_grouped'     => ($matches[2] == '^'),
        'plus_sign'      => ($matches[3] == '+'), 
        'parenteses_sign' => ($matches[3] == '('),
        'ignore_symbol' => ($matches[4] == '!'),
        'minus_sign' => ($matches[5] == '-'),
        'field_width'   => ($matches[6] !== '') ? (int)$matches[6] : 0,
        'precision_left'    => ($matches[7] !== '') ? (int)$matches[7] : false,
        'fraction_digits' => ($matches[8] !== '') ? (int)$matches[8] : $locale['int_frac_digits'],
        'conversion'       => $matches[9]
    );
    
    if ($opcoes['plus_sign'] && $locale['n_sign_posn'] == 0) {
        $locale['n_sign_posn'] = 1;
    } elseif ($opcoes['parenteses_sign']) {
        $locale['n_sign_posn'] = 0;
    }
    
    if (isset($opcoes['fraction_digits'])) {
        $locale['frac_digits'] = (int) $opcoes['fraction_digits'];
    }

    if ($opcoes['not_grouped']) {
        $locale['mon_thousands_sep'] = '';
    }
    
    $tipo_sinal = $value >= 0 ? 'p' : 'n';
    if ($opcoes['ignore_symbol']) {
        $currency_symbol = '';
    } else {
        $currency_symbol = $opcoes['conversion'] == 'n' ? $locale['currency_symbol']
        : $locale['int_curr_symbol'];
    }
    $number = number_format(abs($value), $locale['frac_digits'], $locale['mon_decimal_point'], $locale['mon_thousands_sep']);
    
    
    $sign = $value >= 0 ? $locale['positive_sign'] : $locale['negative_sign'];
    $symbol_before = $locale[$tipo_sinal.'_cs_precedes'];
    
    $space1 = $locale[$tipo_sinal.'_sep_by_space'] == 1 ? ' ' : '';
    
    $space2 = $locale[$tipo_sinal.'_sep_by_space'] == 2 ? ' ' : '';
    
    $formatted = '';
    switch ($locale[$tipo_sinal.'_sign_posn']) {
        case 0:
            if ($symbol_before) {
                $formatted = '('.$currency_symbol.$space1.$number.')';
            } else {
                $formatted = '('.$number.$space1.$currency_symbol.')';
            }
            break;
        case 1:
            if ($symbol_before) {
                $formatted = $sign.$space2.$currency_symbol.$space1.$number;
            } else {
                $formatted = $sign.$number.$space1.$currency_symbol;
            }
            break;
        case 2:
            if ($symbol_before) {
                $formatted = $currency_symbol.$space1.$number.$sign;
            } else {
                $formatted = $number.$space1.$currency_symbol.$space2.$sign;
            }
            break;
        case 3:
            if ($symbol_before) {
                $formatted = $sign.$space2.$currency_symbol.$space1.$number;
            } else {
                $formatted = $number.$space1.$sign.$space2.$currency_symbol;
            }
            break;
        case 4:
            if ($symbol_before) {
                $formatted = $currency_symbol.$space2.$sign.$space1.$number;
            } else {
                $formatted = $number.$space1.$currency_symbol.$space2.$sign;
            }
            break;
    }
    
    if ($opcoes['field_width'] > 0 && strlen($formatted) < $opcoes['field_width']) {
        $alinhamento = $opcoes['minus_sign'] ? STR_PAD_RIGHT : STR_PAD_LEFT;
        $formatted = str_pad($formatted, $opcoes['field_width'], $opcoes['filler'], $alinhamento);
    }
    
    return utf8_encode($formatted);
} 


