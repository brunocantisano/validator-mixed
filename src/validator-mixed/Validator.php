<?php 

namespace ValidatorMixed\BccDevelValidator;

use Illuminate\Validation\Validator as BaseValidator;

/**
* This class is part of paperinik package
*
* @author Bruno Cardoso Cantisano <bruno.cantisano@gmail.com>
*/

class Validator extends BaseValidator
{
    /**
    * Valida o formato do celular junto com o ddd
    * @param string $attribute
    * @param string $value
    * @return boolean
    */
    protected function validateCelularComDdd($attribute, $value)
    {
        return preg_match('/^\(\d{2}\)\s?\d{4,5}-\d{4}$/', $value) > 0;
    }
 
    /**
    * Valida o formato do telefone junto com o ddd
    * @param string $attribute
    * @param string $value
    * @return boolean
    */

    protected function validateTelefoneComDdd($attribute, $value)
    {
        return preg_match('/^\(\d{2}\)\s?\d{4}-\d{4}$/', $value) > 0;
    }


    /**
    * Valida o formato do celular
    * @param string $attribute
    * @param string $value
    * @return boolean
    */
    protected function validateCelular($attribute, $value)
    {
        return preg_match('/^\d{4,5}-\d{4}$/', $value) > 0;   
    }

    /**
    * Valida o formato do telefone
    * @param string $attribute
    * @param string $value
    * @return boolean
    */
    protected function validateTelefone($attribute, $value)
    {
        return preg_match('/^\d{4}-\d{4}$/', $value) > 0;
    }

    /**
    * Valida o formato do cpf
    * @param string $attribute
    * @param string $value
    * @return boolean
    */
    protected function validateFormatoCpf($attribute, $value)
    {
        return preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value) > 0;
    }

    /**
    * Valida o formato do cnpj
    * @param string $attribute
    * @param string $value
    * @return boolean
    */
    protected function validateFormatoCnpj($attribute, $value)
    {
        return preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $value) > 0;
    }

    /**
     * Valida o formato do cpf ou cnpj
     * @param string $attribute
     * @param string $value
     * @return boolean
     */
    protected function validateFormatoCpfCnpj($attribute, $value)
    {
        return $this->validateFormatoCpf($attribute, $value) || $this->validateFormatoCnpj($attribute, $value);
    }

    /**
     * Valida o formato do PIS/PASEP/NIS/NIT
     * @param string $attribute
     * @param string $value
     * @return boolean
     */
    protected function validateFormatoNis($attribute, $value)
    {
        return preg_match('/^\d{3}\.\d{5}\.\d{2}-\d{1}$/', $value) > 0;
    }

    /**
    * Valida se o CPF é válido
    * @param string $attribute
    * @param string $value
    * @return boolean
    */

    protected function validateCpf($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;

    }

    /**
    * Valida se o CNPJ é válido
    * @param string $attribute
    * @param string $value
    * @return boolean
    */
    protected function validateCnpj($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return false;

        } 

        // Remove sequências repetidas como "111111111111"
        // https://github.com/ValidatorMixed/bcc-devel-validator/issues/4

        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {

            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;

    }

    /**
     * Valida CNPJ ou CPF
     * @param string $attribute
     * @param string $value
     * @return boolean
     */
    protected function validateCpfCnpj($attribute, $value)
    {
        return ($this->validateCpf($attribute, $value) || $this->validateCnpj($attribute, $value));
    }

    /**
    * Valida se o CNH é válido
    * @param string $attribute
    * @param string $value
    * @return boolean
    */

    protected function validateCnh($attribute, $value)
    {
        $ret = false;
        
        if ((strlen($input = preg_replace('/[^\d]/', '', $value)) == 11)
            && (str_repeat($input[1], 11) != $input)) {
            $dsc = 0;

            for ($i = 0, $j = 9, $v = 0; $i < 9; ++$i, --$j) {

                $v += (int) $input[$i] * $j;

            }

            if (($vl1 = $v % 11) >= 10) {

                $vl1 = 0;
                $dsc = 2;

            }

            for ($i = 0, $j = 1, $v = 0; $i < 9; ++$i, ++$j) {

                $v += (int) $input[$i] * $j;
                
            }

            $vl2 = ($x = ($v % 11)) >= 10 ? 0 : $x - $dsc;

            $ret = sprintf('%d%d', $vl1, $vl2) == substr($input, -2);
        }

        return $ret;
    }


    /**
    * Valida se o data está no formato 31/12/1969
    * @param string $attribute
    * @param string $value
    * @return boolean
    */

    public function validateData($attribute, $value)
    {
        $regex = '/^(0[1-9]|[1-2][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/';

        return preg_match($regex, $value) > 0;
    }

    /**
     * Valida se o formato de CEP está correto
     *
     * @param string $attribute
     * @param string $value
     * @return boolean
    */

    public function validateFormatoCep($attribute, $value) 
    {
        return preg_match('/^\d{2}\.?\d{3}-\d{3}$/', $value) > 0;
    }

    /**
     * Valida se o formato de placa de veículo está correto.
     *
     * @param string $attribute
     * @param string $value
     * @return boolean
     */

    public function validateFormatoPlacaDeVeiculo($attribute, $value)
    {
        return preg_match('/^[a-zA-Z]{3}\-?[0-9]{4}$/', $value) > 0;
    }

        /**
     * Valida Titulo de Eleitor
     * @param string $attribute
     * @param string $value
     * @return boolean
     */

    protected function validateTituloEleitor($attribute, $value)
    {
        $input = preg_replace('/[^\d]/', '', $value);

        $uf = substr($input, -4, 2);

        if (((strlen($input) < 5) || (strlen($input) > 13)) || 
        (str_repeat($input[1], strlen($input)) == $input) || 
        ($uf < 1 || $uf > 28)) {
            return false;
        }

        $dv = substr($input, -2);
        $base = 2;

        $sequencia = substr($input, 0, -4);

        for ($i = 0; $i < 2; $i++) { 
            $fator = 9;
            $soma = 0;

            for ($j = (strlen($sequencia) - 1); $j > -1; $j--) { 
                $soma += $sequencia[$j] * $fator;

                if ($fator == $base) {
                    $fator = 10;
                }

                $fator--;
            }

            $digito = $soma % 11;

            if (($digito == 0) and ($uf < 3)) {
                $digito = 1;
            } elseif ($digito == 10) {
                $digito = 0;
            }
            
            if ($dv[$i] != $digito) {
                return false;
            }

            switch ($i) {
                case '0':
                    $sequencia = $uf . $digito;

                    break;
            }
        }
        
        return true;
    }
    
    /**
     * Valida PIS/PASEP/NIS/NIT
     * @param string $attribute
     * @param string $value
     * @return boolean
     */

    protected function validateNis($attribute, $value)
    {
        $nis = sprintf('%011s', preg_replace('{\D}', '', $value));

        if (strlen($nis) != 11 || preg_match("/^{$nis[0]}{11}$/", $nis)) {
            return false;
        }

        for ($d = 0, $p = 2, $c = 9; $c >= 0; $c--, ($p < 9) ? $p++ : $p = 2) {
            $d += $nis[$c] * $p;
        }

        return ($nis[10] == (((10 * $d) % 11) % 10));
    }
}