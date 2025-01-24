<?php

namespace App\Controllers;

/**
 * Description of Sesi
 *
 * @author RAMPA
 */
use App\Models\Mcustom;
use App\Libraries\Modul;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class Exportword extends BaseController {

    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index() {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText('Hello World !');
        
        $tableStyle = array(
            'borderColor' => '006699',
            'borderSize'  => 6,
            'cellMargin'  => 50
        );
        $table = $section->addTable($tableStyle);
        $table->addRow();
        $table->addCell()->addText("No");
        $table->addCell()->addText("Judul");
        $table->addCell()->addText("Harga");

        $writer = new Word2007($phpWord);

        $filename = 'simple';
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function coba() {
        $htmlContent = '<!Doctype html>
            <html><head><title>TutorialsWebsite</title></head>
            <body>
                <h1>Hello World!</h1> 
                <h1>Welcome to Tutorialswebsite.com</h1>
                <p>This document is created from HTML.</p>
                </body>
                </html>';
        
        $this->word->createDoc($htmlContent, "document.docx", 1);
    }

}
