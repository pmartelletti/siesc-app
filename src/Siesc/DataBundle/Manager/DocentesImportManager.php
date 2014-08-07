<?php

namespace Siesc\DataBundle\Manager;


use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\CallbackWriter;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManager;
use Siesc\AppBundle\Entity\Docente;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ddeboer\DataImport\Reader\CsvReader;

class DocentesImportManager
{

    private $_em;
    private $userManager;

    public function __construct(EntityManager $em, UserManager $manager)
    {
        $this->_em = $em;
        $this->userManager = $manager;
    }

    /**
     * @param UploadedFile $file
     * @return \Ddeboer\DataImport\Result
     */
    public function processUploadedFile(UploadedFile $file)
    {
        $reader = new CsvReader($file->openFile());
        $reader->setHeaderRowNumber(0);

        $writer = new DoctrineWriter($this->_em, 'SiescAppBundle:Docente');

        $workflow = new Workflow($reader);
        $em = $this->_em;
        $result = $workflow
            ->addWriter(new CallbackWriter(function ($row) {
                $this->saveDocenteRow($row);
            }))
            ->setSkipItemOnFailure(true)
            ->process()
        ;

        $this->_em->flush();

        return $result;

    }

    private function saveDocenteRow($row)
    {
        $docente = new Docente();
        $docente->setCuil($row['CUIL']);
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