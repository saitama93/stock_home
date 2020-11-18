<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfService extends AbstractController{

    /**
     * Permet de télécharger une page HTML en PDF
     *
     * @param integer $id
     * @param string $fileName => Nom du fichier à télécharger
     * @param string $templatePath => Le chemin du template twig
     * @param string $templateParams => Les parametre de ce template si il y en a 
     * 
     * @return void
     */
    public function download(string $fileName, string $templatePath, array $templateParams = null)
    {
        // Instanciation et configuration de Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Initialisation des options
        $dompdf = new Dompdf($pdfOptions);


        $html = $this->renderView($templatePath, $templateParams);

        // Chargement du PDF dans Dompdf
        $dompdf->loadHtml($html);

        // Rendu du HTML en PDF
        $dompdf->render();
        // Génération du PDF et téléchargement sur l'espace local
        // $dompdf->stream($fileName . ".pdf", [
        //     "Attachment" => true
        // ]);
        $output = $dompdf->output();
        file_put_contents('pdf/nouveau_compte.pdf', $output);
    }
}