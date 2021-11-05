<?php

function format_money_clean($value, $format = '%n'){
    
    $cleanedValue = preg_replace("/[^0-9.]/", "", $value);

    return format_money($format, $cleanedValue);
}

function format_money_clean_no_dec($value, $format = '%.0n'){
    
    $cleanedValue = preg_replace("/[^0-9.]/", "", $value);
    
    return format_money($format, $cleanedValue);
}

function format_number_clean($value, $decimals=2){
    
    $cleanedValue = preg_replace("/[^0-9.]/", "", $value);

    return number_format_locale($cleanedValue,$decimals);
}

function number_format_locale($number,$decimals=2) {
    $locale = localeconv();
    return utf8_encode(number_format($number,$decimals,
        $locale['decimal_point'],
        $locale['thousands_sep']));
}

//need to figure out what we want to do here. int module is not neccesarily loaded by default so we can't always use new numberoformatter and money_format is deprecated.
//only supports basic formatting but should be good enough to perform basic currency formatting.
function format_money($format, $value) {
    
    //shortcircut of not set.(Default to basic formatting)
    if (setlocale(LC_MONETARY, 0) == 'C') {
        return '$'.number_format($value, 2);
    }
    
    $locale = localeconv();
    
    $regex = '/^'.             // Inicio da Expressao
        '%'.              // Caractere %
        '(?:'.            // Inicio das Flags opcionais
        '\=([\w\040])'.   // Flag =f
        '|'.
        '([\^])'.         // Flag ^
        '|'.
        '(\+|\()'.        // Flag + ou (
        '|'.
        '(!)'.            // Flag !
        '|'.
        '(-)'.            // Flag -
        ')*'.             // Fim das flags opcionais
        '(?:([\d]+)?)'.   // W  Largura de campos
        '(?:#([\d]+))?'.  // #n Precisao esquerda
        '(?:\.([\d]+))?'. // .p Precisao direita
        '([in%])'.        // Caractere de conversao
        '$/';             // Fim da Expressao
    
    if (!preg_match($regex, $format, $matches)) {
        trigger_error('Formato invalido: '.$format, E_USER_WARNING);
        return $value;
    }
    

    $opcoes = array(
        'preenchimento'   => ($matches[1] !== '') ? $matches[1] : ' ',
        'nao_agrupar'     => ($matches[2] == '^'),
        'usar_sinal'      => ($matches[3] == '+'),
        'usar_parenteses' => ($matches[3] == '('),
        'ignore_symbol' => ($matches[4] == '!'),
        'alinhamento_esq' => ($matches[5] == '-'),
        'largura_campo'   => ($matches[6] !== '') ? (int)$matches[6] : 0,
        'precisao_esq'    => ($matches[7] !== '') ? (int)$matches[7] : false,
        'fraction_digits' => ($matches[8] !== '') ? (int)$matches[8] : $locale['int_frac_digits'],
        'conversao'       => $matches[9]
    );
    
    error_log($opcoes['fraction_digits']);
    
    if ($opcoes['usar_sinal'] && $locale['n_sign_posn'] == 0) {
        $locale['n_sign_posn'] = 1;
    } elseif ($opcoes['usar_parenteses']) {
        $locale['n_sign_posn'] = 0;
    }
    
    if (isset($opcoes['fraction_digits'])) {
        $locale['frac_digits'] = (int) $opcoes['fraction_digits'];
    }

    if ($opcoes['nao_agrupar']) {
        $locale['mon_thousands_sep'] = '';
    }
    
    $tipo_sinal = $value >= 0 ? 'p' : 'n';
    if ($opcoes['ignore_symbol']) {
        $simbolo = '';
    } else {
        $simbolo = $opcoes['conversao'] == 'n' ? $locale['currency_symbol']
        : $locale['int_curr_symbol'];
    }
    $numero = number_format(abs($value), $locale['frac_digits'], $locale['mon_decimal_point'], $locale['mon_thousands_sep']);
    
    
    $sinal = $value >= 0 ? $locale['positive_sign'] : $locale['negative_sign'];
    $simbolo_antes = $locale[$tipo_sinal.'_cs_precedes'];
    
    $espaco1 = $locale[$tipo_sinal.'_sep_by_space'] == 1 ? ' ' : '';
    
    $espaco2 = $locale[$tipo_sinal.'_sep_by_space'] == 2 ? ' ' : '';
    
    $formatado = '';
    switch ($locale[$tipo_sinal.'_sign_posn']) {
        case 0:
            if ($simbolo_antes) {
                $formatado = '('.$simbolo.$espaco1.$numero.')';
            } else {
                $formatado = '('.$numero.$espaco1.$simbolo.')';
            }
            break;
        case 1:
            if ($simbolo_antes) {
                $formatado = $sinal.$espaco2.$simbolo.$espaco1.$numero;
            } else {
                $formatado = $sinal.$numero.$espaco1.$simbolo;
            }
            break;
        case 2:
            if ($simbolo_antes) {
                $formatado = $simbolo.$espaco1.$numero.$sinal;
            } else {
                $formatado = $numero.$espaco1.$simbolo.$espaco2.$sinal;
            }
            break;
        case 3:
            if ($simbolo_antes) {
                $formatado = $sinal.$espaco2.$simbolo.$espaco1.$numero;
            } else {
                $formatado = $numero.$espaco1.$sinal.$espaco2.$simbolo;
            }
            break;
        case 4:
            if ($simbolo_antes) {
                $formatado = $simbolo.$espaco2.$sinal.$espaco1.$numero;
            } else {
                $formatado = $numero.$espaco1.$simbolo.$espaco2.$sinal;
            }
            break;
    }
    
    if ($opcoes['largura_campo'] > 0 && strlen($formatado) < $opcoes['largura_campo']) {
        $alinhamento = $opcoes['alinhamento_esq'] ? STR_PAD_RIGHT : STR_PAD_LEFT;
        $formatado = str_pad($formatado, $opcoes['largura_campo'], $opcoes['preenchimento'], $alinhamento);
    }
    
    return utf8_encode($formatado);
} 


