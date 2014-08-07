<?php

namespace Siesc\DataBundle\Manager;


use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\CallbackWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManager;
use Siesc\AppBundle\Entity\Docente;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ddeboer\DataImport\Reader\CsvReader;

class DocentesImportManager
{

    private $_em;
    private $doctrine;
    private $userManager;
    private $numberProcessed;

    public function __construct(Registry $doctrine, UserManager $manager)
    {
        $this->doctrine = $doctrine;
        $this->_em = $doctrine->getManager();
        $this->userManager = $manager;
        $this->numberProcessed = 0;
    }

    /**
     * @param UploadedFile $file
     * @return \Ddeboer\DataImport\Result
     */
    public function processUploadedFile(UploadedFile $file)
    {
        $reader = new CsvReader($file->openFile());
        $reader->setHeaderRowNumber(0);

        $workflow = new Workflow($reader);
        $em = $this->_em;
        $errors = array();
        $result = $workflow
            ->addWriter(new CallbackWriter(function ($row) use(&$errors) {
                try {
                    $this->saveDocenteRow($row);
                    $this->numberProcessed += 1;
                } catch(\Exception $e)
                {
                    $errors[] = array(
                        'data' => $row,
                        'error' => $e->getMessage()
                    );
                }
            }))
            ->setSkipItemOnFailure(true)
            ->process()
        ;

        $this->_em->flush();

        return array(
            'ok' => $this->numberProcessed,
            'errores' => $errors
        );

    }

    private function saveDocenteRow($row)
    {
        $cuil = $row['CUIL'];
        if (null !== $this->_em->getRepository('SiescAppBundle:Docente')->findOneByCuil($cuil)) {
            throw new \Exception(sprintf('El CUIL %s ya esta en la base de datos.', $cuil));
        }
        $docente = new Docente();
        $docente->setCuil($cuil);
        $docente->setNombre($row['NOMBRE']);
        $docente->setApellido($row['APELLIDO']);
        //$docente->setUsername(sprintf('%s %s', $docente->getNombre(), $docente->getApellido()));
        $docente->setEmail(sprintf('%s@siesc.com.ar', md5(uniqid())));
        $docente->setPlainPassword(uniqid(md5('password')));
        $docente->setDireccion($row['DIRECCION']);
        $docente->setTelefono($row['TELEFONO']);

        $this->userManager->updateCanonicalFields($docente);
        $this->userManager->updatePassword($docente);

        $this->_em->persist($docente);

    }

} 