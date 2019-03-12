<?php 

namespace BrunoCantisano\ValidatorMixed;

use Illuminate\Support\ServiceProvider;

class ValidatorProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
     
    public function boot()
    {

        $me = $this;

        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $customAttributes) use($me)
        {
            $messages += $me->getMessages();
            
            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }


    protected function getMessages()
    {
        return [        
            'celular'          => 'O campo :attribute não é um celular válido',
            'celular_com_ddd'  => 'O campo :attribute não é um celular com DDD válido',
            'cnh'              => 'O campo :attribute não é uma carteira nacional de habilitação válida',
            'cnpj'             => 'O campo :attribute não é um CNPJ válido',
            'cpf'              => 'O campo :attribute não é um CPF válido',
            'cpf_cnpj' 		   => 'CPF ou CNPJ inválido',
            'nis'              => 'PIS/PASEP/NIT/NIS inválido',
            'data'             => 'O campo :attribute não é uma data com formato válido',
            'formato_cnpj'     => 'O campo :attribute não possui o formato válido de CNPJ',
            'formato_cpf'      => 'O campo :attribute não possui o formato válido de CPF',
            'formato_cpf_cnpj' => 'Formato inválido para CPF ou CNPJ',
            'formato_nis'      => 'Formato inválido para PIS/PASEP/NIT/NIS',            
            'telefone'         => 'O campo :attribute não é um telefone válido',
            'telefone_com_ddd' => 'O campo :attribute não é um telefone com DDD válido',
            'formato_cep'      => 'O campo :attribute não possui um formato válido de CEP',
            'formato_placa_de_veiculo'   => 'O campo :attribute não possui um formato válido de placa',
            'titulo_eleitor' => 'Título de Eleitor inválido',
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
