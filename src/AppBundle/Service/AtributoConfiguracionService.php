<?php
namespace AppBundle\Service;

use AppBundle\Entity\AtributoConfiguracion;
use AppBundle\Repository\AtributoConfiguracionRepository;
use Psr\Log\LoggerInterface;

class AtributoConfiguracionService {

    /** @var AtributoConfiguracionRepository $atributoConfiguracionRepository */
    private $atributoConfiguracionRepository;
    private $logger;


    public function __construct(LoggerInterface $logger, AtributoConfiguracionRepository $repository)
    {
        $this->atributoConfiguracionRepository = $repository;
        $this->logger = $logger;
    }

    /**
     * @param AtributoConfiguracion
     * @return void
     */
    public function save(AtributoConfiguracion $atributoConfiguracion){
        return $this->atributoConfiguracionRepository->save($atributoConfiguracion);
    }

    public function findById($id){
        $this->logger->info("Buscando AtributoConfiguracion por id ".$id);
        return $this->atributoConfiguracionRepository->findById($id);
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function findBy($criteria)
    {
        $output = implode(', ', array_map(
            function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
            $criteria,
            array_keys($criteria)
        ));
        $this->logger->info("Buscando Producto por criteria ". $output);
        return $this->atributoConfiguracionRepository->findBy($criteria);
    }

    public function getAtributoConfiguracion($clave, $parceValor = null){
        $this->logger->info("Buscando AtributoConfiguracion por clave ".$clave);
        $atributoConfiguracion = null;

        $atributosConfiguracion =
            $this->atributoConfiguracionRepository->findAtributoConfiguracionByClave($clave);

        /** @var AtributoConfiguracion $atributoConfiguracion */
        $atributoConfiguracion = null;
        if($atributosConfiguracion!=null &&
            is_array($atributosConfiguracion) &&
            count($atributosConfiguracion)>0){
            $atributoConfiguracion = $atributosConfiguracion[0];
        }
        if ($parceValor == 'json' && $atributoConfiguracion && $atributoConfiguracion->getValor()) {
            $data = $this->convertJsonStringToArray($atributoConfiguracion->getValor());
            if ($data != null) {
                $atributoConfiguracion->setValor($data);
            }
        }

        return $atributoConfiguracion;
    }

    public function convertJsonStringToArray($valor) {
        $this->logger->info("Decodificando valor json a array");
        $data = json_decode($valor, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->info('ERROR - invalid json body: ' . json_last_error_msg());
            $data = null;
        }

        return $data;
    }
}



