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
    }
    
    .page.rtl {
        flex-direction: row-reverse;
    }

    .legende {
        width: 100mm;
        height: 59.9mm;
        position: relative;
        box-sizing: border-box;
        padding: 6mm;
        padding-top: 7mm;
        border-bottom: 1px solid #ccc;
    }

    .legende:nth-child(odd) {
        border-right: 1px solid #ccc;
    }

    .legende .text {
        font-weight: bold;
        padding-right: 22mm;
        margin-bottom: 3mm;
        line-height: 1.4;
    }

    .legende .text.small {
        font-size: .96rem;
        line-height: 1.2;
    }

    .legende .text.smaller {
        font-size: .90rem;
        line-height: 1.2;
    }

    .legende .text.smallest {
        padding-right: 20mm;
        font-size: .75rem;
        line-height: 1.2;
        font-weight: 500;
        margin-bottom: 1mm;
        margin-top: -1mm;
    }

    .concours {
        background: #38B6FF;
        padding: 1.4mm 2mm;
        color: white;
        display: inline-block;
        margin-bottom: 4mm;
        font-weight: 500;
        font-size: .9rem;
        padding-bottom: 0.4mm;
        position: relative;
        padding-left: 11.5mm;
    }

    .round {
        position: absolute;
        left: -2mm;
        top: 50%;
        transform: translateY(-50%);
        border: 4px solid #38B6FF;
        border-radius: 100%;
        background: white;
        height: 9mm;
        width: 9mm;
        color: #38B6FF;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        padding-top: 4px;
        padding-right: 2px;
        padding-left: 2px;
        font-weight: 600;
        
    }
    
    
    .duckstyle .concours {
        background: #93D401;
    }
    
    .duckstyle .round {
        border-color: #93D401;
        color: #93D401;
    }

    .auhtor {
        font-style: italic;
        font-size: .9rem;
    }

    .footer {
        position: absolute;
        bottom: 6mm;
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
        top: 4mm;
        right: 4mm;
        width: 28mm;
        opacity: .3;
    }

    .preview {
        width: auto;
        max-height: 150px;
    }

    .number {
        text-align: center;
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
    
    public function __construct($legend, $author, $number, $concours, $image_link)
    {
        $this->legend = $legend;
        $this->author = $author;
        $this->number = $number;
        $this->concours = $concours;
        $this->image_link = $image_link;
    }
}

$array_legends = [];

foreach ($sheetData as $datum) {
    $array_legends[] = new Legend($datum[4], $datum[2], $datum[0], $datum[5], $datum[7]);
}

echo '<div class="page">';
$i = 0;

$variant = "";

const DUCKSTYLE = 'Duck Style';
const DUCKSTYLE_CLASS = 'duckstyle';

$numbers = '';

foreach ($array_legends as $legende) {
    $class = 'laplusbelle';
    
    $text_length = strlen($legende->legend);
    
    $replaced = 0;
    $legend_text = trim(str_replace(
        '[QRCODE]',
        '<br /><img src="frame.png" width="80mm" class="qr"/>',
        $legende->legend,
        $replaced
    ));
    
    if ($legend_text === '') {
        $legend_text = '( Sans titre )';
    }
    
    $class_legend = '';
    if ($text_length > 182 || $replaced > 0) {
        $class_legend = ' smallest';
    } else if ($text_length > 130) {
        $class_legend = ' smaller';
    } else if ($text_length > 120) {
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
        <div class="text <?= $class_legend ?>"><?= $legend_text ?></div>
        <div class="auhtor"><?= $legende->author ?></div>

        <img src="logo-bg-no.png" class="logo-duck"/>

        <div class="footer">
            <div>
                Duck Parapente - Concours photos 2021
            </div>

            <div class="printby">
                Imprimé par
                <img src="photoweb.png"/>
            </div>
        </div>
    </div>
    <?php
    // show img on verso
    if (!($i % 10)) {
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