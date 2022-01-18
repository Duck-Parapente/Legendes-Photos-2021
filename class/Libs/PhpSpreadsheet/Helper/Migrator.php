<?php

namespace PhpSpreadsheet\Helper;

class Migrator
{
    /**
     * @var string[]
     */
    private $from;

    /**
     * @var string[]
     */
    private $to;

    public function __construct()
    {
        $this->from = array_keys($this->getMapping());
        $this->to = array_values($this->getMapping());
    }

    /**
     * Return the ordered mapping from old PHPExcel class names to new PhpSpreadsheet one.
     *
     * @return string[]
     */
    public function getMapping()
    {
        // Order matters here, we should have the deepest namespaces first (the most "unique" strings)
        $classes = [
            'PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE_Blip' => \PhpSpreadsheet\Shared\Escher\DggContainer\BstoreContainer\BSE\Blip::class,
            'PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer' => \PhpSpreadsheet\Shared\Escher\DgContainer\SpgrContainer\SpContainer::class,
            'PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE' => \PhpSpreadsheet\Shared\Escher\DggContainer\BstoreContainer\BSE::class,
            'PHPExcel_Shared_Escher_DgContainer_SpgrContainer' => \PhpSpreadsheet\Shared\Escher\DgContainer\SpgrContainer::class,
            'PHPExcel_Shared_Escher_DggContainer_BstoreContainer' => \PhpSpreadsheet\Shared\Escher\DggContainer\BstoreContainer::class,
            'PHPExcel_Shared_OLE_PPS_File' => \PhpSpreadsheet\Shared\OLE\PPS\File::class,
            'PHPExcel_Shared_OLE_PPS_Root' => \PhpSpreadsheet\Shared\OLE\PPS\Root::class,
            'PHPExcel_Worksheet_AutoFilter_Column_Rule' => \PhpSpreadsheet\Worksheet\AutoFilter\Column\Rule::class,
            'PHPExcel_Writer_OpenDocument_Cell_Comment' => \PhpSpreadsheet\Writer\Ods\Cell\Comment::class,
            'PHPExcel_Calculation_Token_Stack' => \PhpSpreadsheet\Calculation\Token\Stack::class,
            'PHPExcel_Chart_Renderer_jpgraph' => \PhpSpreadsheet\Chart\Renderer\JpGraph::class,
            'PHPExcel_Reader_Excel5_Escher' => \PhpSpreadsheet\Reader\Xls\Escher::class,
            'PHPExcel_Reader_Excel5_MD5' => \PhpSpreadsheet\Reader\Xls\MD5::class,
            'PHPExcel_Reader_Excel5_RC4' => \PhpSpreadsheet\Reader\Xls\RC4::class,
            'PHPExcel_Reader_Excel2007_Chart' => \PhpSpreadsheet\Reader\Xlsx\Chart::class,
            'PHPExcel_Reader_Excel2007_Theme' => \PhpSpreadsheet\Reader\Xlsx\Theme::class,
            'PHPExcel_Shared_Escher_DgContainer' => \PhpSpreadsheet\Shared\Escher\DgContainer::class,
            'PHPExcel_Shared_Escher_DggContainer' => \PhpSpreadsheet\Shared\Escher\DggContainer::class,
            'CholeskyDecomposition' => \PhpSpreadsheet\Shared\JAMA\CholeskyDecomposition::class,
            'EigenvalueDecomposition' => \PhpSpreadsheet\Shared\JAMA\EigenvalueDecomposition::class,
            'PHPExcel_Shared_JAMA_LUDecomposition' => \PhpSpreadsheet\Shared\JAMA\LUDecomposition::class,
            'PHPExcel_Shared_JAMA_Matrix' => \PhpSpreadsheet\Shared\JAMA\Matrix::class,
            'QRDecomposition' => \PhpSpreadsheet\Shared\JAMA\QRDecomposition::class,
            'PHPExcel_Shared_JAMA_QRDecomposition' => \PhpSpreadsheet\Shared\JAMA\QRDecomposition::class,
            'SingularValueDecomposition' => \PhpSpreadsheet\Shared\JAMA\SingularValueDecomposition::class,
            'PHPExcel_Shared_OLE_ChainedBlockStream' => \PhpSpreadsheet\Shared\OLE\ChainedBlockStream::class,
            'PHPExcel_Shared_OLE_PPS' => \PhpSpreadsheet\Shared\OLE\PPS::class,
            'PHPExcel_Best_Fit' => \PhpSpreadsheet\Shared\Trend\BestFit::class,
            'PHPExcel_Exponential_Best_Fit' => \PhpSpreadsheet\Shared\Trend\ExponentialBestFit::class,
            'PHPExcel_Linear_Best_Fit' => \PhpSpreadsheet\Shared\Trend\LinearBestFit::class,
            'PHPExcel_Logarithmic_Best_Fit' => \PhpSpreadsheet\Shared\Trend\LogarithmicBestFit::class,
            'polynomialBestFit' => \PhpSpreadsheet\Shared\Trend\PolynomialBestFit::class,
            'PHPExcel_Polynomial_Best_Fit' => \PhpSpreadsheet\Shared\Trend\PolynomialBestFit::class,
            'powerBestFit' => \PhpSpreadsheet\Shared\Trend\PowerBestFit::class,
            'PHPExcel_Power_Best_Fit' => \PhpSpreadsheet\Shared\Trend\PowerBestFit::class,
            'trendClass' => \PhpSpreadsheet\Shared\Trend\Trend::class,
            'PHPExcel_Worksheet_AutoFilter_Column' => \PhpSpreadsheet\Worksheet\AutoFilter\Column::class,
            'PHPExcel_Worksheet_Drawing_Shadow' => \PhpSpreadsheet\Worksheet\Drawing\Shadow::class,
            'PHPExcel_Writer_OpenDocument_Content' => \PhpSpreadsheet\Writer\Ods\Content::class,
            'PHPExcel_Writer_OpenDocument_Meta' => \PhpSpreadsheet\Writer\Ods\Meta::class,
            'PHPExcel_Writer_OpenDocument_MetaInf' => \PhpSpreadsheet\Writer\Ods\MetaInf::class,
            'PHPExcel_Writer_OpenDocument_Mimetype' => \PhpSpreadsheet\Writer\Ods\Mimetype::class,
            'PHPExcel_Writer_OpenDocument_Settings' => \PhpSpreadsheet\Writer\Ods\Settings::class,
            'PHPExcel_Writer_OpenDocument_Styles' => \PhpSpreadsheet\Writer\Ods\Styles::class,
            'PHPExcel_Writer_OpenDocument_Thumbnails' => \PhpSpreadsheet\Writer\Ods\Thumbnails::class,
            'PHPExcel_Writer_OpenDocument_WriterPart' => \PhpSpreadsheet\Writer\Ods\WriterPart::class,
            'PHPExcel_Writer_PDF_Core' => \PhpSpreadsheet\Writer\Pdf::class,
            'PHPExcel_Writer_PDF_DomPDF' => \PhpSpreadsheet\Writer\Pdf\Dompdf::class,
            'PHPExcel_Writer_PDF_mPDF' => \PhpSpreadsheet\Writer\Pdf\Mpdf::class,
            'PHPExcel_Writer_PDF_tcPDF' => \PhpSpreadsheet\Writer\Pdf\Tcpdf::class,
            'PHPExcel_Writer_Excel5_BIFFwriter' => \PhpSpreadsheet\Writer\Xls\BIFFwriter::class,
            'PHPExcel_Writer_Excel5_Escher' => \PhpSpreadsheet\Writer\Xls\Escher::class,
            'PHPExcel_Writer_Excel5_Font' => \PhpSpreadsheet\Writer\Xls\Font::class,
            'PHPExcel_Writer_Excel5_Parser' => \PhpSpreadsheet\Writer\Xls\Parser::class,
            'PHPExcel_Writer_Excel5_Workbook' => \PhpSpreadsheet\Writer\Xls\Workbook::class,
            'PHPExcel_Writer_Excel5_Worksheet' => \PhpSpreadsheet\Writer\Xls\Worksheet::class,
            'PHPExcel_Writer_Excel5_Xf' => \PhpSpreadsheet\Writer\Xls\Xf::class,
            'PHPExcel_Writer_Excel2007_Chart' => \PhpSpreadsheet\Writer\Xlsx\Chart::class,
            'PHPExcel_Writer_Excel2007_Comments' => \PhpSpreadsheet\Writer\Xlsx\Comments::class,
            'PHPExcel_Writer_Excel2007_ContentTypes' => \PhpSpreadsheet\Writer\Xlsx\ContentTypes::class,
            'PHPExcel_Writer_Excel2007_DocProps' => \PhpSpreadsheet\Writer\Xlsx\DocProps::class,
            'PHPExcel_Writer_Excel2007_Drawing' => \PhpSpreadsheet\Writer\Xlsx\Drawing::class,
            'PHPExcel_Writer_Excel2007_Rels' => \PhpSpreadsheet\Writer\Xlsx\Rels::class,
            'PHPExcel_Writer_Excel2007_RelsRibbon' => \PhpSpreadsheet\Writer\Xlsx\RelsRibbon::class,
            'PHPExcel_Writer_Excel2007_RelsVBA' => \PhpSpreadsheet\Writer\Xlsx\RelsVBA::class,
            'PHPExcel_Writer_Excel2007_StringTable' => \PhpSpreadsheet\Writer\Xlsx\StringTable::class,
            'PHPExcel_Writer_Excel2007_Style' => \PhpSpreadsheet\Writer\Xlsx\Style::class,
            'PHPExcel_Writer_Excel2007_Theme' => \PhpSpreadsheet\Writer\Xlsx\Theme::class,
            'PHPExcel_Writer_Excel2007_Workbook' => \PhpSpreadsheet\Writer\Xlsx\Workbook::class,
            'PHPExcel_Writer_Excel2007_Worksheet' => \PhpSpreadsheet\Writer\Xlsx\Worksheet::class,
            'PHPExcel_Writer_Excel2007_WriterPart' => \PhpSpreadsheet\Writer\Xlsx\WriterPart::class,
            'PHPExcel_CachedObjectStorage_CacheBase' => \PhpSpreadsheet\Collection\Cells::class,
            'PHPExcel_CalcEngine_CyclicReferenceStack' => \PhpSpreadsheet\Calculation\Engine\CyclicReferenceStack::class,
            'PHPExcel_CalcEngine_Logger' => \PhpSpreadsheet\Calculation\Engine\Logger::class,
            'PHPExcel_Calculation_Functions' => \PhpSpreadsheet\Calculation\Functions::class,
            'PHPExcel_Calculation_Function' => \PhpSpreadsheet\Calculation\Category::class,
            'PHPExcel_Calculation_Database' => \PhpSpreadsheet\Calculation\Database::class,
            'PHPExcel_Calculation_DateTime' => \PhpSpreadsheet\Calculation\DateTime::class,
            'PHPExcel_Calculation_Engineering' => \PhpSpreadsheet\Calculation\Engineering::class,
            'PHPExcel_Calculation_Exception' => \PhpSpreadsheet\Calculation\Exception::class,
            'PHPExcel_Calculation_ExceptionHandler' => \PhpSpreadsheet\Calculation\ExceptionHandler::class,
            'PHPExcel_Calculation_Financial' => \PhpSpreadsheet\Calculation\Financial::class,
            'PHPExcel_Calculation_FormulaParser' => \PhpSpreadsheet\Calculation\FormulaParser::class,
            'PHPExcel_Calculation_FormulaToken' => \PhpSpreadsheet\Calculation\FormulaToken::class,
            'PHPExcel_Calculation_Logical' => \PhpSpreadsheet\Calculation\Logical::class,
            'PHPExcel_Calculation_LookupRef' => \PhpSpreadsheet\Calculation\LookupRef::class,
            'PHPExcel_Calculation_MathTrig' => \PhpSpreadsheet\Calculation\MathTrig::class,
            'PHPExcel_Calculation_Statistical' => \PhpSpreadsheet\Calculation\Statistical::class,
            'PHPExcel_Calculation_TextData' => \PhpSpreadsheet\Calculation\TextData::class,
            'PHPExcel_Cell_AdvancedValueBinder' => \PhpSpreadsheet\Cell\AdvancedValueBinder::class,
            'PHPExcel_Cell_DataType' => \PhpSpreadsheet\Cell\DataType::class,
            'PHPExcel_Cell_DataValidation' => \PhpSpreadsheet\Cell\DataValidation::class,
            'PHPExcel_Cell_DefaultValueBinder' => \PhpSpreadsheet\Cell\DefaultValueBinder::class,
            'PHPExcel_Cell_Hyperlink' => \PhpSpreadsheet\Cell\Hyperlink::class,
            'PHPExcel_Cell_IValueBinder' => \PhpSpreadsheet\Cell\IValueBinder::class,
            'PHPExcel_Chart_Axis' => \PhpSpreadsheet\Chart\Axis::class,
            'PHPExcel_Chart_DataSeries' => \PhpSpreadsheet\Chart\DataSeries::class,
            'PHPExcel_Chart_DataSeriesValues' => \PhpSpreadsheet\Chart\DataSeriesValues::class,
            'PHPExcel_Chart_Exception' => \PhpSpreadsheet\Chart\Exception::class,
            'PHPExcel_Chart_GridLines' => \PhpSpreadsheet\Chart\GridLines::class,
            'PHPExcel_Chart_Layout' => \PhpSpreadsheet\Chart\Layout::class,
            'PHPExcel_Chart_Legend' => \PhpSpreadsheet\Chart\Legend::class,
            'PHPExcel_Chart_PlotArea' => \PhpSpreadsheet\Chart\PlotArea::class,
            'PHPExcel_Properties' => \PhpSpreadsheet\Chart\Properties::class,
            'PHPExcel_Chart_Title' => \PhpSpreadsheet\Chart\Title::class,
            'PHPExcel_DocumentProperties' => \PhpSpreadsheet\Document\Properties::class,
            'PHPExcel_DocumentSecurity' => \PhpSpreadsheet\Document\Security::class,
            'PHPExcel_Helper_HTML' => \PhpSpreadsheet\Helper\Html::class,
            'PHPExcel_Reader_Abstract' => \PhpSpreadsheet\Reader\BaseReader::class,
            'PHPExcel_Reader_CSV' => \PhpSpreadsheet\Reader\Csv::class,
            'PHPExcel_Reader_DefaultReadFilter' => \PhpSpreadsheet\Reader\DefaultReadFilter::class,
            'PHPExcel_Reader_Excel2003XML' => \PhpSpreadsheet\Reader\Xml::class,
            'PHPExcel_Reader_Exception' => \PhpSpreadsheet\Reader\Exception::class,
            'PHPExcel_Reader_Gnumeric' => \PhpSpreadsheet\Reader\Gnumeric::class,
            'PHPExcel_Reader_HTML' => \PhpSpreadsheet\Reader\Html::class,
            'PHPExcel_Reader_IReadFilter' => \PhpSpreadsheet\Reader\IReadFilter::class,
            'PHPExcel_Reader_IReader' => \PhpSpreadsheet\Reader\IReader::class,
            'PHPExcel_Reader_OOCalc' => \PhpSpreadsheet\Reader\Ods::class,
            'PHPExcel_Reader_SYLK' => \PhpSpreadsheet\Reader\Slk::class,
            'PHPExcel_Reader_Excel5' => \PhpSpreadsheet\Reader\Xls::class,
            'PHPExcel_Reader_Excel2007' => \PhpSpreadsheet\Reader\Xlsx::class,
            'PHPExcel_RichText_ITextElement' => \PhpSpreadsheet\RichText\ITextElement::class,
            'PHPExcel_RichText_Run' => \PhpSpreadsheet\RichText\Run::class,
            'PHPExcel_RichText_TextElement' => \PhpSpreadsheet\RichText\TextElement::class,
            'PHPExcel_Shared_CodePage' => \PhpSpreadsheet\Shared\CodePage::class,
            'PHPExcel_Shared_Date' => \PhpSpreadsheet\Shared\Date::class,
            'PHPExcel_Shared_Drawing' => \PhpSpreadsheet\Shared\Drawing::class,
            'PHPExcel_Shared_Escher' => \PhpSpreadsheet\Shared\Escher::class,
            'PHPExcel_Shared_File' => \PhpSpreadsheet\Shared\File::class,
            'PHPExcel_Shared_Font' => \PhpSpreadsheet\Shared\Font::class,
            'PHPExcel_Shared_OLE' => \PhpSpreadsheet\Shared\OLE::class,
            'PHPExcel_Shared_OLERead' => \PhpSpreadsheet\Shared\OLERead::class,
            'PHPExcel_Shared_PasswordHasher' => \PhpSpreadsheet\Shared\PasswordHasher::class,
            'PHPExcel_Shared_String' => \PhpSpreadsheet\Shared\StringHelper::class,
            'PHPExcel_Shared_TimeZone' => \PhpSpreadsheet\Shared\TimeZone::class,
            'PHPExcel_Shared_XMLWriter' => \PhpSpreadsheet\Shared\XMLWriter::class,
            'PHPExcel_Shared_Excel5' => \PhpSpreadsheet\Shared\Xls::class,
            'PHPExcel_Style_Alignment' => \PhpSpreadsheet\Style\Alignment::class,
            'PHPExcel_Style_Border' => \PhpSpreadsheet\Style\Border::class,
            'PHPExcel_Style_Borders' => \PhpSpreadsheet\Style\Borders::class,
            'PHPExcel_Style_Color' => \PhpSpreadsheet\Style\Color::class,
            'PHPExcel_Style_Conditional' => \PhpSpreadsheet\Style\Conditional::class,
            'PHPExcel_Style_Fill' => \PhpSpreadsheet\Style\Fill::class,
            'PHPExcel_Style_Font' => \PhpSpreadsheet\Style\Font::class,
            'PHPExcel_Style_NumberFormat' => \PhpSpreadsheet\Style\NumberFormat::class,
            'PHPExcel_Style_Protection' => \PhpSpreadsheet\Style\Protection::class,
            'PHPExcel_Style_Supervisor' => \PhpSpreadsheet\Style\Supervisor::class,
            'PHPExcel_Worksheet_AutoFilter' => \PhpSpreadsheet\Worksheet\AutoFilter::class,
            'PHPExcel_Worksheet_BaseDrawing' => \PhpSpreadsheet\Worksheet\BaseDrawing::class,
            'PHPExcel_Worksheet_CellIterator' => \PhpSpreadsheet\Worksheet\CellIterator::class,
            'PHPExcel_Worksheet_Column' => \PhpSpreadsheet\Worksheet\Column::class,
            'PHPExcel_Worksheet_ColumnCellIterator' => \PhpSpreadsheet\Worksheet\ColumnCellIterator::class,
            'PHPExcel_Worksheet_ColumnDimension' => \PhpSpreadsheet\Worksheet\ColumnDimension::class,
            'PHPExcel_Worksheet_ColumnIterator' => \PhpSpreadsheet\Worksheet\ColumnIterator::class,
            'PHPExcel_Worksheet_Drawing' => \PhpSpreadsheet\Worksheet\Drawing::class,
            'PHPExcel_Worksheet_HeaderFooter' => \PhpSpreadsheet\Worksheet\HeaderFooter::class,
            'PHPExcel_Worksheet_HeaderFooterDrawing' => \PhpSpreadsheet\Worksheet\HeaderFooterDrawing::class,
            'PHPExcel_WorksheetIterator' => \PhpSpreadsheet\Worksheet\Iterator::class,
            'PHPExcel_Worksheet_MemoryDrawing' => \PhpSpreadsheet\Worksheet\MemoryDrawing::class,
            'PHPExcel_Worksheet_PageMargins' => \PhpSpreadsheet\Worksheet\PageMargins::class,
            'PHPExcel_Worksheet_PageSetup' => \PhpSpreadsheet\Worksheet\PageSetup::class,
            'PHPExcel_Worksheet_Protection' => \PhpSpreadsheet\Worksheet\Protection::class,
            'PHPExcel_Worksheet_Row' => \PhpSpreadsheet\Worksheet\Row::class,
            'PHPExcel_Worksheet_RowCellIterator' => \PhpSpreadsheet\Worksheet\RowCellIterator::class,
            'PHPExcel_Worksheet_RowDimension' => \PhpSpreadsheet\Worksheet\RowDimension::class,
            'PHPExcel_Worksheet_RowIterator' => \PhpSpreadsheet\Worksheet\RowIterator::class,
            'PHPExcel_Worksheet_SheetView' => \PhpSpreadsheet\Worksheet\SheetView::class,
            'PHPExcel_Writer_Abstract' => \PhpSpreadsheet\Writer\BaseWriter::class,
            'PHPExcel_Writer_CSV' => \PhpSpreadsheet\Writer\Csv::class,
            'PHPExcel_Writer_Exception' => \PhpSpreadsheet\Writer\Exception::class,
            'PHPExcel_Writer_HTML' => \PhpSpreadsheet\Writer\Html::class,
            'PHPExcel_Writer_IWriter' => \PhpSpreadsheet\Writer\IWriter::class,
            'PHPExcel_Writer_OpenDocument' => \PhpSpreadsheet\Writer\Ods::class,
            'PHPExcel_Writer_PDF' => \PhpSpreadsheet\Writer\Pdf::class,
            'PHPExcel_Writer_Excel5' => \PhpSpreadsheet\Writer\Xls::class,
            'PHPExcel_Writer_Excel2007' => \PhpSpreadsheet\Writer\Xlsx::class,
            'PHPExcel_CachedObjectStorageFactory' => \PhpSpreadsheet\Collection\CellsFactory::class,
            'PHPExcel_Calculation' => \PhpSpreadsheet\Calculation\Calculation::class,
            'PHPExcel_Cell' => \PhpSpreadsheet\Cell\Cell::class,
            'PHPExcel_Chart' => \PhpSpreadsheet\Chart\Chart::class,
            'PHPExcel_Comment' => \PhpSpreadsheet\Comment::class,
            'PHPExcel_Exception' => \PhpSpreadsheet\Exception::class,
            'PHPExcel_HashTable' => \PhpSpreadsheet\HashTable::class,
            'PHPExcel_IComparable' => \PhpSpreadsheet\IComparable::class,
            'PHPExcel_IOFactory' => \PhpSpreadsheet\IOFactory::class,
            'PHPExcel_NamedRange' => \PhpSpreadsheet\NamedRange::class,
            'PHPExcel_ReferenceHelper' => \PhpSpreadsheet\ReferenceHelper::class,
            'PHPExcel_RichText' => \PhpSpreadsheet\RichText\RichText::class,
            'PHPExcel_Settings' => \PhpSpreadsheet\Settings::class,
            'PHPExcel_Style' => \PhpSpreadsheet\Style\Style::class,
            'PHPExcel_Worksheet' => \PhpSpreadsheet\Worksheet\Worksheet::class,
        ];

        $methods = [
            'MINUTEOFHOUR' => 'MINUTE',
            'SECONDOFMINUTE' => 'SECOND',
            'DAYOFWEEK' => 'WEEKDAY',
            'WEEKOFYEAR' => 'WEEKNUM',
            'ExcelToPHPObject' => 'excelToDateTimeObject',
            'ExcelToPHP' => 'excelToTimestamp',
            'FormattedPHPToExcel' => 'formattedPHPToExcel',
            'Cell::absoluteCoordinate' => 'Coordinate::absoluteCoordinate',
            'Cell::absoluteReference' => 'Coordinate::absoluteReference',
            'Cell::buildRange' => 'Coordinate::buildRange',
            'Cell::columnIndexFromString' => 'Coordinate::columnIndexFromString',
            'Cell::coordinateFromString' => 'Coordinate::coordinateFromString',
            'Cell::extractAllCellReferencesInRange' => 'Coordinate::extractAllCellReferencesInRange',
            'Cell::getRangeBoundaries' => 'Coordinate::getRangeBoundaries',
            'Cell::mergeRangesInCollection' => 'Coordinate::mergeRangesInCollection',
            'Cell::rangeBoundaries' => 'Coordinate::rangeBoundaries',
            'Cell::rangeDimension' => 'Coordinate::rangeDimension',
            'Cell::splitRange' => 'Coordinate::splitRange',
            'Cell::stringFromColumnIndex' => 'Coordinate::stringFromColumnIndex',
        ];

        // Keep '\' prefix for class names
        $prefixedClasses = [];
        foreach ($classes as $key => &$value) {
            $value = str_replace('\', '\\\', $value);
            $prefixedClasses['\\' . $key] = $value;
        }
        $mapping = $prefixedClasses + $classes + $methods;

        return $mapping;
    }

    /**
     * Search in all files in given directory.
     *
     * @param string $path
     */
    private function recursiveReplace($path)
    {
        $patterns = [
            '/*.md',
            '/*.txt',
            '/*.TXT',
            '/*.php',
            '/*.phpt',
            '/*.php3',
            '/*.php4',
            '/*.php5',
            '/*.phtml',
        ];

        foreach ($patterns as $pattern) {
            foreach (glob($path . $pattern) as $file) {
                if (strpos($path, '/vendor/') !== false) {
                    echo $file . " skipped\n";

                    continue;
                }
                $original = file_get_contents($file);
                $converted = $this->replace($original);

                if ($original !== $converted) {
                    echo $file . " converted\n";
                    file_put_contents($file, $converted);
                }
            }
        }

        // Do the recursion in subdirectory
        foreach (glob($path . '/*', GLOB_ONLYDIR) as $subpath) {
            if (strpos($subpath, $path . '/') === 0) {
                $this->recursiveReplace($subpath);
            }
        }
    }

    public function migrate()
    {
        $path = realpath(getcwd());
        echo 'This will search and replace recursively in ' . $path . PHP_EOL;
        echo 'You MUST backup your files first, or you risk losing data.' . PHP_EOL;
        echo 'Are you sure ? (y/n)';

        $confirm = fread(STDIN, 1);
        if ($confirm === 'y') {
            $this->recursiveReplace($path);
        }
    }

    /**
     * Migrate the given code from PHPExcel to PhpSpreadsheet.
     *
     * @param string $original
     *
     * @return string
     */
    public function replace($original)
    {
        $converted = str_replace($this->from, $this->to, $original);

        // The string "PHPExcel" gets special treatment because of how common it might be.
        // This regex requires a word boundary around the string, and it can't be
        // preceded by $ or -> (goal is to filter out cases where a variable is named $PHPExcel or similar)
        $converted = preg_replace('~(?<!\$|->)(\b|\\\\)PHPExcel\b~', '\\' . \PhpSpreadsheet\Spreadsheet::class, $converted);

        return $converted;
    }
}
