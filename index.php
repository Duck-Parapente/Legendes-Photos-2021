<?php

// dirty 80/20 class loading
function autoload($nom)
{
    $parts = explode("\\", $nom);
    
    include_once 'class/Libs/' . join('/', $parts) . '.php';
}

spl_autoload_register('autoload');

?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Aleo:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
      rel="stylesheet">

<style>
    .page {
        height: 297mm;
        width: 210mm;
        display: flex;
        flex-wrap: wrap;
        page-break-after: always;
        /*justify-content: center;*/
        color: #545454;
        font-size: 1rem;
        font-family: 'Aleo', serif;
        text-align: left;
        align-content: flex-start;
    }
    
    .page.rtl {
        flex-direction: row-reverse;
    }

    .legende {
        width: 105mm;
        height: 50mm;
        position: relative;
        box-sizing: border-box;
        padding: 6mm;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5mm;
    }

    .legende:nth-child(odd) {
        border-right: 1px solid #ccc;
    }

    .legende .title {
        font-weight: bold;
        margin-bottom: 2mm;
        font-size: 1rem;
        width: 70mm;
    }

    .legende .text {
        padding-right: 8mm;
        margin-bottom: 2mm;
        line-height: 1.4;
        font-size: .94rem;
    }

    .legende .text.small {
        font-size: .90rem;
        line-height: 1.2;
    }

    .legende .text.smaller {
        font-size: .85rem;
        line-height: 1.2;
    }

    .legende .text.smallest, .legende .text.xsmallest {
        font-size: .7rem;
        line-height: 1.2;
        font-weight: 500;
        margin-bottom: 1mm;
        margin-top: -1mm;
    }

    .legende .text.xsmallest {
        font-size: .60rem;
    }

    .concours {
        background: #38B6FF;
        padding: 1.4mm 4mm;
        color: white;
        display: inline-block;
        margin-bottom: 4mm;
        font-weight: 500;
        font-size: .8rem;
        padding-bottom: 0.4mm;
        position: relative;
        padding-left: 10mm;
    }

    .round {
        position: absolute;
        left: -2mm;
        top: 50%;
        transform: translateY(-50%);
        border: 3px solid #38B6FF;
        border-radius: 100%;
        background: white;
        height: 7mm;
        width: 7mm;
        color: #38B6FF;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        padding-top: 4px;
        padding-right: 2px;
        padding-left: 2px;
        font-weight: 600;
        
    }
    
    
    .laplusbelle .concours {
        background: #93D401;
    }
    
    .laplusbelle .round {
        border-color: #93D401;
        color: #93D401;
    }

    .author {
        font-style: italic;
        font-size: .75rem;
    }

    .footer {
        position: absolute;
        bottom: 4mm;
        left: 6mm;
        right: 5mm;
        display: flex;
        font-size: .5rem;
        justify-content: space-between;
        align-items: flex-end;
    }

    .footer img {
        width: 30mm;
        position: relative;
        top: 2mm;
    }

    .qr {
        margin-bottom: -1mm;
    }

    .logo-duck {
        position: absolute;
        top: 2mm;
        right: 4mm;
        width: 22mm;
        opacity: .5;
    }

    .preview {
        width: auto;
        max-height: 130px;
        margin-top: 2mm;
    }

    .number {
        text-align: center;
        font-size: .8rem;
    }

    .duckstyle .printby {
        opacity: 0;
    }
</style>

<?php
$filename = 'legendes.xlsx';

$reader = new PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($filename);

$sheetData = $spreadsheet->getActiveSheet()->toArray();
array_splice($sheetData, 0, 1);
$sheetData = array_filter($sheetData, function ($datum) {
    return !is_null($datum[0]);
});

$i = 0;
$count = count($sheetData);

class Legend
{
    public $legend;
    public $author;
    public $number;
    public $concours;
    public $image_link;
    
    public function __construct($legend, $title, $author, $number, $concours, $image_link)
    {
        $this->legend = $legend;
        $this->title = $title;
        $this->author = $author;
        $this->number = $number;
        $this->concours = $concours;
        $this->image_link = $image_link;
    }
}

$array_legends = [];

foreach ($sheetData as $datum) {
    $array_legends[] = new Legend($datum[5],$datum[4], $datum[2], $datum[0], $datum[6], $datum[7]);
}

echo '<div class="page">';
$i = 0;

$variant = "";

const DUCKSTYLE = 'Duck Style';
const DUCKSTYLE_CLASS = 'duckstyle';

$numbers = '';

foreach ($array_legends as $legende) {
    $class = 'laplusbelle';

    $legend_text = trim($legende->legend);

    $text_length = strlen($legend_text.$legende->title);
    
    $class_legend = '';
    if ($text_length > 220) {
        $class_legend = ' xsmallest';
    } else if ($text_length > 190) {
        $class_legend = ' smallest';
    } else if ($text_length > 140) {
        $class_legend = ' smaller';
    } else if ($text_length > 100) {
        $class_legend = ' small';
    }
    
    if ($legende->concours === DUCKSTYLE) {
        $class = DUCKSTYLE_CLASS;
    }
    
    $numbers .= '<div class="legende number">' . $legende->number . ' - ' . $legende->author . ' - ' . $legende->concours . '<br /><img src="' . str_replace(
            ['file/d/', '/view?usp=drivesdk'],
            ['thumbnail?authuser=0&id=', ''],
            $legende->image_link
        ) . ' " class="preview"/></div>';
    
    ?>
    <div class="legende <?= $class ?>">
        <?php
        $i++;
        ?>
        <div class="concours"><div class="round"><?= intval($legende->number) ?></div>Catégorie : <?= $legende->concours
            ?></div>
        <div class="title"><?= $legende->title ?></div>
        <div class="text <?= $class_legend ?>"><?= nl2br($legend_text) ?></div>
        <div class="author"><?= $legende->author ?></div>

        <img src="logo-bg-no.png" class="logo-duck"/>

        <div class="footer">
            <div>
                Duck Parapente - Concours photos 2023
            </div>

            <div class="printby">
                Imprimé par <?= $legende->concours === DUCKSTYLE ? 'Europrimm' :  '<img src="photoweb.png"/>' ?>
            </div>
        </div>
    </div>
    <?php
    // show img on verso
    if (!($i % 10) || $i == count($array_legends)) {
        echo '
        </div>
        <div class="page rtl">
        ' . $numbers . '
        </div>
        <div class="page">';
        
        $numbers = '';
    }
    ?>
    <?php
}

?>