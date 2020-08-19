<?php
namespace AppBundle\Service;

use AppBundle\Entity\AtributoConfiguracion;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mime\MimeTypes;

class FileUploaderService extends Filesystem
{
    private $targetDirectory;
    /**
     * @var LoggerInterface
     */
    private $logger;
    private $projectDirectory;
    /**
     * @var MimeTypes
     */
    private $mimeTypes;
    /**
     * @var string
     */
    private $filesDirectory;

    public function __construct(
        $projectDirectory,
        AtributoConfiguracionService $atributoConfiguracionService,
        LoggerInterface $logger
    )
    {
        /** @var AtributoConfiguracion $files_directory_atr */
        $files_directory_atr = $atributoConfiguracionService->getAtributoConfiguracion('files_directory');
        $this->filesDirectory = $files_directory_atr->getValor();
        $this->targetDirectory = $projectDirectory . 'web/' . $files_directory_atr->getValor();
        $this->logger = $logger;
        $this->projectDirectory = $projectDirectory;
        $this->mimeTypes = new MimeTypes();

    }

    public function upload(UploadedFile $file, $folder = '', $fileName = '', $fileExtension = '')
    {
        $this->logger->info("Subiendo archivo...");
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        if ( !$fileName || trim($fileName) == '') {
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $fileName = $safeFilename . '-' . uniqid();
        }
        if ( !$fileExtension || trim($fileExtension) == '') {
            $fileFullName = $fileName . '.' . $file->guessExtension();
        }
        else {
            $fileFullName = $fileName . '.' . $fileExtension;
        }

        try {
            $file->move($this->getTargetDirectory() . $folder, $fileFullName);
            $this->logger->info("Se ha subido el archivo '$originalFilename' con el nombre '$fileFullName' al directorio '$this->targetDirectory $folder}'");
        } catch (FileException $e) {
            $this->logger->error("No se ha subido el archivo '$originalFilename' con el nombre '$fileFullName' al directorio '$this->targetDirectory $folder'");
            $this->logger->error("FileException message: $e.get_error_message()");
            // TODO: ... handle exception if something happens during file upload
            throw $e;
        }

        return $fileFullName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    /**
     * @return mixed
     */
    public function getProjectDirectory()
    {
        return $this->projectDirectory;
    }

    public function getBase64UploadedFile ($fileName, $folder = '')
    {
        try {
            $mimeType = $this->mimeTypes->guessMimeType($this->getTargetDirectory() . $folder . '/' . $fileName);
            //        var_dump("$fileName  $mimeType");die;
            $file = file_get_contents($this->getTargetDirectory() . $folder . '/' . $fileName);
            $fileB64 = base64_encode($file);
        }
        catch (\Exception $e) {
            // No se pudo abir el archivo, se retorna nulo
            return null;
        }

        return [
            'fileName'  => $fileName,
            'fileB64'   => $fileB64,
            'mimeType'  => $mimeType,
        ];
    }

    /**
     * @return string
     */
    public function getFilesDirectory(): ?string
    {
        return $this->filesDirectory;
    }

}


?>