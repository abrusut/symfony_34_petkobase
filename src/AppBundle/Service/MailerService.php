<?php
namespace AppBundle\Service;



use AppBundle\Entity\AtributoConfiguracion;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MailerService
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var AtributoConfiguracionService
     */
    private $atributoConfiguracionService;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $templating;
    /**
     * @var FileUploaderService
     */
    private $fileUploaderService;

    public function __construct(
        AtributoConfiguracionService $atributoConfiguracionService,
        \Swift_Mailer $mailer,
        \Twig_Environment $templating,
        LoggerInterface $logger,
        FileUploaderService $fileUploaderService
    )
    {
        $this->logger = $logger;
        $this->atributoConfiguracionService = $atributoConfiguracionService;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fileUploaderService = $fileUploaderService;
    }

//    public function sendMailIncumplimiento(Denuncia $denuncia, $fileName = null)
//    {
//        $this->logger->info("Enviando correo electronico...");
//
//        /* Cargo la configuracion para el envío desde la tabla de parametros */
//        $mailFrom = $this->atributoConfiguracionService->getAtributoConfiguracion('mail_incumpl_from')->getValor();
//        /** @var AtributoConfiguracion $mailsToAtr */
//        $mailsToAtr = $this->atributoConfiguracionService->getAtributoConfiguracion('mail_incumpl_to');
//        $mailsTo = json_decode($mailsToAtr->getValor(), true);
//
//
//        $fecha_denuncia = date(DATE_ATOM);
//        $subject = 'Precios Santafesinos - Denuncia - Fecha: ' . $fecha_denuncia;
//        $filePath = $this->fileUploaderService->getTargetDirectory() . '/' . $fileName;
//        $message = (new \Swift_Message($subject))
//            ->setFrom($mailFrom)
//            ->setTo($mailsTo)
//            ->setBody(
//                $this->templating->render(
//                    'default/email_incumplimiento.html.twig', [
//                        'denuncia' => $denuncia,
//                        'fechaDenuncia' => $fecha_denuncia
//                    ]
//                ),
//                'text/html'
//            )
////            ->addPart(
////                $this->renderView(
////                    'Emails/email_incumplimiento.txt.twig',
////                    ['denuncia' => $denuncia]
////                ),
////                'text/plain'
////            )
//        ;
//        if ($fileName) {
//            $message->attach( \Swift_Attachment::fromPath($filePath) );
//        }
//
//        $this->mailer->send($message);
//    }
}


?>